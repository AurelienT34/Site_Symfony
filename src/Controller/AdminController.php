<?php

namespace App\Controller;

use App\Entity\UserName;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @param UserRepository $users
     * @return Response
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function compte(UserRepository $users): Response
    {
        return $this->render("admin/compte.html.twig",[
            'utilisateurs'=>$users->findAll()
        ]);
    }

    /**
     * @Route("/utilisateur/modifier/{id}", name="modifier_utilisateur")
     * @param UserName $user
     * @param Request $request
     * @param ManagerRegistry $manager
     * @return Response
     */
    public function editUser(UserName $user, Request $request,ManagerRegistry  $manager): Response
    {
        $form = $this->createForm(EditUserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->getManager()->persist($user);
            $manager->getManager()->flush();

            $this->addFlash('message','Utilisateur modifié avec succés');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/edituser.html.twig',[
            'userForm'=>$form->createView()
        ]);
    }
}
