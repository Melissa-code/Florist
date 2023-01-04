<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    /**
     * Read the addresses
     *
     * @return Response
     */
    #[Route('/account/address', name: 'app_account_address')]
    public function index(): Response
    {
        //dd($this->getUser());
        return $this->render('account/address.html.twig', [
        ]);
    }

    /**
     * Create or Update an address
     *
     * @param Address|null $address
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/account/add-address', name: 'app_account_add_address', methods: 'GET|POST')]
    #[Route('/account/update-address/{id}', name: 'app_account_update_address', methods: 'GET|POST')]
    public function createOrUpdate(?Address $address, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if(!$address) {
            $address = new Address();
        }
        $isUpdated = $address->getId() !== null;

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            //dd($address);
            $managerRegistry->getManager()->persist($address);
            $managerRegistry->getManager()->flush();
            $this->addFlash("success", ($isUpdated) ? "La modification a bien été effectuée." : "L'Ajout a bien été effectué.");
            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account/createOrUpdateAddress.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
            'isUpdated' => $address->getId() !== null
        ]);
    }

    #[Route('/account/delete-address/{id}', name: 'app_account_delete_address', methods: 'DELETE')]
    public function delete(?Address $address, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if($this->isCsrfTokenValid('REMOVE'.$address->getId(), $request->get('_token'))){
            $managerRegistry->getManager()->remove($address);
            $managerRegistry->getManager()->flush();
            $this->addFlash("success",  "La suppression a bien été effectuée.");
            return $this->redirectToRoute('app_account_address');
        }
    }


}
