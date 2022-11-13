<?php

namespace App\Controller;

use App\Entity\FicheEvaluation;
use App\Form\FicheEvaluationType;
use App\Services\UploaderPdf;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('user'),
    IsGranted('ROLE_USER')
]
class FicheEvaluationController extends AbstractController
{
    #[Route('/FicheEvaluation', name: 'app_fiche_evaluation')]
    public function deposerPresentation(ManagerRegistry $doctrine , Request $request ,UploaderPdf $uploaderPdf): Response
    {

        if(!$this->getUser()->getFicheEvaluation()){
            $ficheEvaluation = new FicheEvaluation();
            $ficheEvaluation->setEstDeploye(false);
        }else{
            $repository = $doctrine->getRepository(FicheEvaluation::class);
            $ficheEvaluation = $repository->find($this->getUser()->getFicheEvaluation()->getId());
            $ficheEvaluation->setEstDeploye(false);
        }

        $ficheEvaluationForm = $this->createForm(FicheEvaluationType::class, $ficheEvaluation);
        $ficheEvaluationForm->remove('user');
        $ficheEvaluationForm->handleRequest($request);
        
        if ($ficheEvaluationForm->isSubmitted() && $ficheEvaluationForm->isValid()) { 
            $ficheEvaluationPDF = $ficheEvaluationForm->get('fichier')->getData();
            $manager = $doctrine->getManager();
            
            if ($ficheEvaluationPDF) {
                
                $ficheEvaluationDirectory = $this->getParameter('fiche_evaluation_directory');
                $ficheEvaluation->setEstDeploye(true);
                $ficheEvaluation->setFichier($uploaderPdf->uploadPdf($ficheEvaluationPDF , $ficheEvaluationDirectory ));
                $ficheEvaluation->setUser($this->getUser());
                $manager->persist($ficheEvaluation);
                $manager->flush();
                $this->addFlash('success', 'Votre fiche d\'évaluation du stage a été bien ajouté avec success');

                return  $this->redirectToRoute('app_profile');
            }
        }


        return $this->render('ficheEvaluation/ficheEvaluation.html.twig', [
            'ficheEvaluationForm' => $ficheEvaluationForm->createView()
        ]);
    }
}
