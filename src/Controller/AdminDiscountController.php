<?php

namespace App\Controller;

use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDiscountController extends AbstractController
{
    /**
     * Get all the discounts
     *
     * @param DiscountRepository $discountRepository
     * @return Response
     */
    #[Route('/admin/discount', name: 'app_admin_discount')]
    public function getAll(DiscountRepository $discountRepository): Response
    {
        $discounts = $discountRepository->findAll();

        return $this->render('admin_discount/index.html.twig', [
            "discounts" => $discounts,
        ]);
    }


}
