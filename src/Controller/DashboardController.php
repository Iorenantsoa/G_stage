<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('Administrateur') , 
    IsGranted('ROLE_ADMIN')
]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(ManagerRegistry $doctrine): Response
    {

        $nbEtudiantRepository = $doctrine->getRepository(User::class);
        $nbEtudiant = $nbEtudiantRepository->findNbEtudiant("ROLE_USER");
        

        return $this->render('dashboard/index.html.twig', [
            'nbEtudiant'=> $nbEtudiant[0]
        ]);
    }
}
