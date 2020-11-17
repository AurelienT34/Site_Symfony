<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserName;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $request
     * @param ManagerRegistry $manager
     * @param UserPasswordEncoder $encoder
     * @return Response
     */
    public function registration(Request $request, ManagerRegistry  $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new UserName();

        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);

        // Cryptage du mot de passe a l'aide de bcrypt
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $manager->getManager()->persist($user);
            $manager->getManager()->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/login", name="security_login")
     */
    public function login(): Response
    {
        return $this->render("security/login.html.twig");
    }

    /**
     * @param UserName $user
     * @return Response
     * @Route("/user/compte/{id}", name="security_compte")
     */
    public function compte(UserName $user): Response
    {
        return $this->render("security/compte.html.twig",[
            'user'=>$user
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(): Response {}
}
