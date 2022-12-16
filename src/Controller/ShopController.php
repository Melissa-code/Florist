<?php

namespace App\Controller;

use App\Repository\FlowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * Display one flower
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

    /**
     * Search a flower in the navbar
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/searchFlower', name:'app_search_flower')]
    public function searchFlower(Request $request): Response
    {
        // Get the user input in the url
        $search = $request->query->get("search");

        // Redirect to the results page (var $search)
        return $this->redirectToRoute("app_results_flowers", [
            'search' => $search
        ]);
    }

    /**
     * Display the Flower results of the serach in the searchbar
     *
     * @param $search
     * @param FlowerRepository $flowerRepository
     * @return Response
     */
    #[Route('/search-flower/{search}', name:'app_results_flowers')]
    public function results($search, FlowerRepository $flowerRepository)
    {
        $flowersResult = $flowerRepository->searchFlower($search);

        return $this->render("shop/result_flowers.html.twig", [
            'flowers' => $flowersResult
        ]);
    }
}