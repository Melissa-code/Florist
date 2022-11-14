<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name:'app_shop')]
    public function shop(): Response
    {
        $flowers = [
            1 => [
                "id" => 1,
                "name"=>"Mimosa",
                "price"=> 19.95,
            ],
            2 => [
                "id" => 2,
                "name"=>"Chrysanthème",
                "price"=> 20.95,
            ],
            3 => [
                "id" => 3,
                "name"=>"Hortensia",
                "price"=> 21.95,
            ],
            4 => [
                "id" => 4,
                "name"=>"Lavande",
                "price"=> 22.95,
            ],

        ];

        return $this->render('shop/index.html.twig', [
            "flowers" => $flowers
        ]);
    }

    #[Route('/shop/{id}', name:'app_shop_article')]
    public function article($id): Response
    {
        return $this->render('shop/article.html.twig');
    }
}