<?php

namespace App\Controller;

use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\DiscountRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
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

    /**
     * Create or update a discount
     *
     * @param Discount|null $discount
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/admin/discount/create', name: 'app_create_discount', methods: 'POST|GET')]
    #[Route('/admin/discount/{id}', name: 'app_update_discount', methods: 'POST|GET')]
    public function createOrUpdate(?Discount $discount, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if ($discount == null) {
            $discount = new Discount();
        }

        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        $isUpdated = $discount->getId() !== null;
        if($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->persist($discount);
            $managerRegistry->getManager()->flush();
            $this->addFlash( "success", ($isUpdated) ? "La modification a bien été effectuée." :  "L'ajout a bien été effectué.");
            return $this->redirectToRoute('app_admin_discount');
        }

        return $this->render('admin_discount/createOrUpdate.html.twig', [
            "discount" => $discount,
            "form" => $form->createView(),
            'isUpdated' => $discount->getId() !== null
        ]);
    }

    /**
     * Delete a discount
     *
     * @param Discount $discount
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/admin/discount/{id}', name: 'app_delete_discount', methods: 'DELETE')]
    public function delete(Discount $discount, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if($this->isCsrfTokenValid('REMOVE'.$discount->getId(), $request->get('_token'))) {
            $managerRegistry->getManager()->remove($discount);
            $managerRegistry->getManager()->flush();
            $this->addFlash("success", "La suppression a bien été effectuée.");
            return $this->redirectToRoute('app_admin_discount');
        }
    }

}
