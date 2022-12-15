<?php

namespace App\Controller;

use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\DiscountRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            "discounts" => $discounts
        ]);
    }


    #[Route('/admin/discount/{id}', name: 'app_update_discount', methods: 'POST|GET')]
    public function createOrUpdate(Discount $discount, Request $request, ManagerRegistry $managerRegistry): Response
    {

        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->persist($discount);
            $managerRegistry->getManager()->flush();
            $this->addFlash("success", "La modification a bien été effectuée.");
            return $this->redirectToRoute('app_admin_discount');
        }

        return $this->render('admin_discount/createOrUpdate.html.twig', [
            "discount" => $discount,
            "form" => $form->createView(),
            'isUpdated' => $discount->getId() !== null
        ]);
    }


}
