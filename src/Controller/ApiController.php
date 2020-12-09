<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
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

    /**
     * @Route("api/externalData", name="api_external_data")
     * @return JsonResponse
     */
    public function getFromDidierMartin(): Response
    {
        $json = file_get_contents('http://didier-martin-blog.herokuapp.com/api');
        $obj = json_decode($json, true);
        $articles = [];

        //var_dump(date_create($obj['data'][0]['datePost']['date']), "Y-m-d h:i:s");

        for($i=0;$i<$obj['items'];$i++) {
            $article = new Article();
            $article->setTitle($obj['data'][$i]['title'])
                    ->setContent($obj['data'][$i]['content'])
                    ->setCreateAtFromString($obj['data'][0]['datePost']['date']);

            $articles[]= $article;
        }

        return $this->render('api/getExternal.html.twig',[
            'articles'=>$articles
        ]);
    }
}
