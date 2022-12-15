<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminCategoryController extends AbstractController
{
    /**
     * Get all the categories
     *
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    #[Route('/admin/category', name: 'app_admin_category')]
    public function getAll(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin_category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * Update a category
     *
     * @param Category $category
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/admin/category/{id}', name: 'app_update_category', methods: 'GET|POST')]
    public function updateOrCreate(Category $category, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if(!$category) {
            $category = new Category();
        }
        //$isUpdated = $category->getId() !== null;
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $managerRegistry->getManager()->persist($category);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('admin_category/createOrUpdate.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'isUpdated' => $category->getId() !== null
        ]);
    }

}
