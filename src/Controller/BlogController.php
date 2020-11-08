<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('Blog/blog.html.twig');
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
     * @Route("/blog/article", name="singleArticle")
     */
    public function showSingleArticle(): Response
    {
        return $this->render('blog/singleArticle.html.twig');
    }
}