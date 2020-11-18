<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api", name="api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/articles", name="get", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function getter(EntityManagerInterface $entityManager): JsonResponse
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        $serializerArticles = [];
        foreach ($articles as $article) {
            $serializerArticles[] = [
                'id'=>$article->getId(),
                'title'=>$article->getTitle(),
                'content'=>$article->getContent(),
                'category'=>$article->getCategory(),
                'image'=>$article->getImage(),
                'createAt'=>$article->getCreateAt(),
                'comments'=>$article->getComments()
            ];
        }
        return new JsonResponse(['data'=>$serializerArticles, 'items'=>count($serializerArticles)]);
    }

    /**
     * @Route("/articles/{id}", name="getById", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @param Article $articleToFind
     * @return JsonResponse
     */
    public function getterById(EntityManagerInterface $entityManager,Article $articleToFind): JsonResponse
    {
        $article = $entityManager->getRepository(Article::class)->find($articleToFind);
            $serializerArticle[] = [
                'id'=>$article->getId(),
                'title'=>$article->getTitle(),
                'content'=>$article->getContent(),
                'category'=>$article->getCategory(),
                'image'=>$article->getImage(),
                'createAt'=>$article->getCreateAt(),
                'comments'=>$article->getComments()
            ];
        return new JsonResponse(['data'=>$serializerArticle, 'items'=>count($serializerArticle)]);
    }
}
