<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
    /**
     * Sign up
     *
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    #[Route('signup', name: 'app_signup')]
    public function signup(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            // dd($hashedPassword);
            $user->setPassword($hashedPassword);

            $managerRegistry->getManager()->persist($user);
            $managerRegistry->getManager()->flush();
        }

        return $this->render('signup/signup.html.twig', [
            'user' => $user,
            'form'=> $form->createView()
        ]);
    }



//    #[Route('login', name: 'app_login')]
//    public function login(): Response
//    {
//        return $this->render('signup/login.html.twig');
//    }

}