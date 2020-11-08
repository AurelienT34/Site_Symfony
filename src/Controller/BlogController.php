<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     * @param ArticleRepository $repo
     * @return Response
     */
    public function index(ArticleRepository  $repo): Response
    {
        /**
         * $article = $repo->find(12); // Article numéro 12
         *  $article = $repo->findOneByTitle('Titre de l\'article');
         *  $articles = $repo->findByTitle('Titre de l\'article');
         */

        $articles = $repo->findAll();
        return $this->render('Blog/blog.html.twig',[
            'articles'=>$articles]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('blog/index.html.twig');
    }

    /**
     * @Route("/accountCreation", name="creation")
     */
    public function accountCreation(): Response
    {
        return $this->render('user/accountCreation.html.twig');
    }

    /**
     * @Route("/blog/article/{id}", name="singleArticle")
     * @param Article $article
     * @return Response
     */
    public function showSingleArticle(Article $article): Response
    {
        return $this->render('blog/singleArticle.html.twig',[
            'article'=>$article
        ]);
    }
}