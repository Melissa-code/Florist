<?php

namespace App\Controller;

use App\Repository\FlowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * Display all the flowers in alphabetical order
     *
     * @param FlowerRepository $flowerRepository
     * @return Response
     */
    #[Route('/shop', name:'app_shop')]
    public function shop(FlowerRepository $flowerRepository): Response
    {
        $flowers = $flowerRepository->findByAlphabeticalOrder();

        return $this->render('shop/index.html.twig', [
            "flowers" => $flowers,
        ]);
    }

    /**
     * Display the flower detail
     *
     * @param FlowerRepository $flowerRepository
     * @param int $id
     * @return Response
     */
    #[Route('/shop/{id}', name:'app_shop_article')]
    public function article(FlowerRepository $flowerRepository, int $id): Response
    {
        $flower = $flowerRepository->find($id);

        return $this->render('shop/article.html.twig', [
            "flower" => $flower
        ]);
    }
}