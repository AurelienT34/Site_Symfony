<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Expr\Cast\Object_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        return $this->render('Blog/index.html.twig');
    }

    /**
     * @Route("/blog/article/{id}", name="singleArticle")
     * @param Article $article
     * @param Request $request
     * @param ManagerRegistry $manager
     * @return Response
     */
    public function showSingleArticle(Article $article, Request $request, ManagerRegistry  $manager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article);

            $manager->getManager()->persist($comment);
            $manager->getManager()->flush();
            return  $this->redirectToRoute('singleArticle',['id'=>$article->getId()]);
        }
        return $this->render('Blog/singleArticle.html.twig',[
            'article'=>$article,
            'commentForm'=>$form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
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

        return $this->render('Blog/creationArticle.html.twig',[
            'formArticle' => $form->createView(),
            'editMode'=> $article->getId() !== null]);
    }
}