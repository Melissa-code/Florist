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
            "flowers" => $flowers
        ]);
    }

    /**
     * Update a flower
     *
     * @param Flower $flower
     * @return Response
     */
    #[Route('/admin/flower/{id}', name: 'app_admin_update_flower')]
    public function update(Flower $flower, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(FlowerType::class, $flower);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->persist($flower);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('app_admin_flower');
        }

        return $this->render('admin_flower/update.html.twig', [
            "flower" => $flower,
            "form" => $form->createView()
        ]);
    }

}
