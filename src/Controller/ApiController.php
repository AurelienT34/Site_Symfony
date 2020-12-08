<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/lastArticle", name="api_lastArticle", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function index(ArticleRepository  $articleRepository): JsonResponse
    {
        $articles = $articleRepository->findBy(array(),array('createAt'=>'DESC'),5,0);
        $serializedArticles = [];
        foreach ($articles as $article) {
            $serializedArticles[]= [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'date' => $article->getCreateAt(),
            ];
        }

        return new JsonResponse(['data' => $serializedArticles, 'items' => count($serializedArticles)]);
    }
}
