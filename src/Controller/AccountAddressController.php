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
    #[Route('/account/address', name: 'app_account_address')]
    public function index(): Response
    {
        //dd($this->getUser());
        return $this->render('account/address.html.twig', [
        ]);
    }

    #[Route('/account/add-address', name: 'app_account_add_address')]
    public function add(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            //dd($address);

            $managerRegistry->getManager()->persist($address);
            $managerRegistry->getManager()->flush();
        }

        return $this->render('account/addAddress.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
