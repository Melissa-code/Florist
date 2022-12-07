<?php

namespace App\Controller;

use App\Repository\FlowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFlowerController extends AbstractController
{
    #[Route('/admin/flower', name: 'app_admin_flower')]
    public function getAll(FlowerRepository $flowerRepository): Response
    {
        $flowers = $flowerRepository->findAll();

        return $this->render('admin_flower/index.html.twig', [
            "flowers" => $flowers
        ]);
    }
}
