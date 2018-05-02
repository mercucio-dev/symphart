<?php
/**
 * Created by PhpStorm.
 * User: mercucio
 * Date: 27.04.18
 * Time: 08:59
 */
    namespace App\Controller;

    use App\Entity\Article;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use function Sodium\add;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    class ArticleController extends Controller{
        /**
         * @Route("/", name="article_list")
         *
         */
        public function index(){

            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

            return $this->render('articles/index.html.twig', array(
                'articles' => $articles
            ));
        }

        /**
         * @Route("/article/new", name="new_article")
         */
        public function new(Request $request){
            $article = new Article();

            $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, array('attr' => array('class'=>'form-control')))
                ->add('body', TextareaType::class, array('required' =>false, 'attr'=>array('class'=>'form-control')))
                ->add('save',SubmitType::class, array('label'=>'Create', 'attr'=>array('class'=>'btn btn-primary mt-3')))->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $article=$form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('article_list');
            }

            return $this->render('articles/new.html.twig', array('form'=>$form->createView()));
        }

        /**
         * @Route("/article/edit/{id}", name="edit_article")
         */
        public function edit(Request $request, $id){
            //$article = new Article();
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, array('attr'=>array('class'=>'form-control')))
                ->add('body', TextareaType::class, array('required'=>false, 'attr'=>array('class'=>'form-control')))
                ->add('save',SubmitType::class, array('label'=>'Save','attr'=>array('class'=>'btn btn-primary mt-3')))->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $article=$form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('article_list');
            }

            return $this->render('articles/edit.html.twig', array('form'=>$form->createView()));
        }

        /**
         * @Route("/article/{id}", name="article_show")
         */
        public function show($id){

            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            return $this->render('articles/show.html.twig', array(
                'article' => $article
            ));
        }

        /**
         * @Route("/article/delete/{id}")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id){
            $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();

            $response = new Response();
            $response->send();
        }
    }