<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    /**
     * Change the user password
     *
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    #[Route('/account/password', name: 'app_account_password')]
    public function index(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Get the logged in user
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();

            // Check if the DB hashed password matches with the old password
            if($passwordHasher->isPasswordValid($user, $old_password)) {
                $new_password = $form->get('new_password')->getData();
                // Hash new password
                $password = $passwordHasher->hashPassword($user, $new_password);
                $user->setPassword($password);
                // Update password in the database
                $managerRegistry->getManager()->flush();
                $this->addFlash('success', "Votre mot de passe a bien été mis à jour.");
            } else {
                $this->addFlash('danger', "Votre mot de passe actuel n'est pas le bon.");
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
