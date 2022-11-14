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
        return $this->render('shop/index.html.twig');
    }

    #[Route('/shop/{id}', name:'app_shop_article')]
    public function article($id): Response
    {
        return $this->render('shop/article.html.twig');
    }
}