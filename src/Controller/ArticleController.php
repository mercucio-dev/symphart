<?php
/**
 * Created by PhpStorm.
 * User: mercucio
 * Date: 27.04.18
 * Time: 08:59
 */
    namespace App\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;

    class ArticleController extends Controller{
        /**
         * @Route("/")
         *
         */
        public function index(){

            $articles = ['Article 1', 'Article 2', 'Article 3'];

            return $this->render('articles/index.html.twig', array(
                'articles' => $articles
            ));
        }

    }