<?php

namespace App\Controller;

use App\Services\Bdd;
use App\Entity\TrtUser;
use App\Services\EnvoieEmail;
use App\Form\RegistrationFormType;
use App\Repository\TrtUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    /**
     * 
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @param TrtUserRepository $reposUser
     * @param EnvoieEmail $envoieEmail
     * @return Response
     * 
     * @Route("/admin", name="app_admin")
     * IsGranted("ROLE_ADMIN")
     */

    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, TrtUserRepository $reposUser, EnvoieEmail $envoieEmail, Bdd $basedd): Response
    {
        $user = new TrtUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_CONSULTANT']);

            $user->setValider(1);

            $entityManager->persist($user);

            $entityManager->flush();

            $subject = "Vous ête consultant";
            $template = 'templateEmail/email_consultant.html.twig';
            $context = [""];
            $envoieEmail->SendEmail($user->getEmail(), $subject, $template, $context);
            return $this->redirectToRoute('app_admin');
        }
        $listeConsultant = $basedd->getUserRole('ROLE_CONSULTANT');


        return $this->render('admin/index.html.twig', [
            'page' => 'admin',
            'formconsultant' => $form->createView(),
            'liste' => $listeConsultant,
        ]);
    }
}
