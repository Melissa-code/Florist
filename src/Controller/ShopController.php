<?php

namespace App\Controller;

use App\Repository\FlowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name:'app_shop')]
    public function shop(FlowerRepository $flowerRepository): Response
    {
        $flowers = $flowerRepository->findAll();

        return $this->render('shop/index.html.twig', [
            "flowers" => $flowers
        ]);
    }

    #[Route('/shop/{id}', name:'app_shop_article')]
    public function article($id): Response
    {


        return $this->render('shop/article.html.twig', [

        ]);
    }
}