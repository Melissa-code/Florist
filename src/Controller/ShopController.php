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
     * Search a flower via the searchbar in the navbar
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
     * Display the Flower results of the search via the searchbar
     *
     * @param $search
     * @param FlowerRepository $flowerRepository
     * @return Response
     */
    #[Route('/search-flower/{search}', name:'app_results_flowers')]
    public function resultFlower($search, FlowerRepository $flowerRepository): Response
    {
        $flowersResult = $flowerRepository->searchFlower($search);

        return $this->render("shop/result_flowers.html.twig", [
            'flowers' => $flowersResult
        ]);
    }

    /**
     * Select a category via the select
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/selectCategory', name:'app_select_category')]
    public function selectCategory(Request $request): Response
    {
        $categorySelected = $request->query->get("categorySelected");

        return $this->redirectToRoute("app_results_category", [
            'categorySelected' => $categorySelected
        ]);
    }

    /**
     * Display the Flower results of the search via the category select
     *
     * @param $categorySelected
     * @param FlowerRepository $flowerRepository
     * @return Response
     */
    #[Route('/select-category/{categorySelected}', name:'app_results_category')]
    public function resultCategory($categorySelected, FlowerRepository $flowerRepository): Response
    {
        $flowers = $flowerRepository->selectCategory($categorySelected);

        return $this->render("shop/result_flowers.html.twig", [
            'flowers' => $flowers
        ]);
    }
}