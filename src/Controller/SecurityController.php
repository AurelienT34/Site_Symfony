<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserName;
use App\Form\EditProfileType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $request
     * @param ManagerRegistry $manager
     * @param UserPasswordEncoderInterface $encoder
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
     * @Route("/profile", name="profile")
     * @param Request $request
     * @param ManagerRegistry $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function profile(Request $request, ManagerRegistry  $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $manager->getManager()->persist($user);
            $manager->getManager()->flush();

            $this->addFlash('message','Profil mis à jour');
            return $this->redirectToRoute('profile');
        }

        return $this->render('security/profile.html.twig',[
            'profileForm'=>$form->createView()
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
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(): Response {}
}
