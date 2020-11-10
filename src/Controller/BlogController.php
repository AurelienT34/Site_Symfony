<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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

    /**
     * @Route("/blog/creationarticle"), name="creationArticle")
     * @Route("/blog/creationarticle/{id}/edit", name="modificationArticle")
     * @param Article|null $article
     * @param Request $request
     * @param ManagerRegistry $manager
     * @return Response
     */
    public function formManager(?Article $article,Request $request, ManagerRegistry  $manager): Response
    {
        if(!$article) {
            $article = new Article();
        }

        if($article->getId() !== null) {
            $article->setTitle($article->getTitle())
                    ->setContent($article->getContent())
                    ->setImage($article->getImage());
        }

        /**
        $form = $this->createFormBuilder($article)
                        ->add('title')
                        ->add('content')
                        ->add('image')
                        ->getForm();
        */

        $form = $this->createForm(ArticleType::class,$article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if(!$article->getId()) {
                $article->setCreateAt(new \DateTime());
            }

            $manager->getManager()->persist($article);
            $manager->getManager()->flush();
            return  $this->redirectToRoute('singleArticle',['id'=>$article->getId()]);
        }

        return $this->render('blog/creationArticle.html.twig',[
            'formArticle' => $form->createView(),
            'editMode'=> $article->getId() !== null]);
    }
}