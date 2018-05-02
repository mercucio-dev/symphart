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
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;

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
         * @Route("/article/{id}", name="article_show")
         */
        public function show($id){

            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            return $this->render('articles/show.html.twig', array(
                'article' => $article
            ));
        }
//
//        /**
//         * @Route("/article/save")
//         *
//         */
//        public function save(){
//            $entityManager = $this->getDoctrine()->getManager();
//
//            $article=new Article();
//            $article->setTitle('Articule One');
//            $article->setBody('This is the body for articule two');
//
//            $entityManager->persist($article);
//            $entityManager->flush();
//
//            return new Response('Saved an article with the id of '.$article->getId());
//        }
    }