<?php

namespace App\Controller;

use App\Entity\Flower;
use App\Form\FlowerType;
use App\Repository\FlowerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminFlowerController extends AbstractController
{
    /**
     * Get all the flowers
     *
     * @param FlowerRepository $flowerRepository
     * @return Response
     */
    #[Route('/admin/flower', name: 'app_admin_flower')]
    public function getAll(FlowerRepository $flowerRepository): Response
    {
        $flowers = $flowerRepository->findAll();

        return $this->render('admin_flower/index.html.twig', [
            'flowers' => $flowers
        ]);
    }

    /**
     * Update or Create a flower
     *
     * @param Flower|null $flower
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/admin/flower/create', name: 'app_admin_create_flower')]
    #[Route('/admin/flower/{id}', name: 'app_admin_update_flower')]
    public function createOrUpdate(?Flower $flower, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if(!$flower) {
            $flower = new Flower();
        }

        $form = $this->createForm(FlowerType::class, $flower);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->persist($flower);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('app_admin_flower');
        }

        return $this->render('admin_flower/createOrUpdate.html.twig', [
            'flower' => $flower,
            'form' => $form->createView(),
            'isUpdated' => $flower->getId() !== null
        ]);
    }

    #[Route('/admin/flower/{id}', name: 'app_admin_delete_flower')]
    public function delete(?Flower $flower, Request $request, ManagerRegistry $managerRegistry): Response
    {

    }

}
