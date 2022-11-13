<?php

namespace App\Controller;

use App\Entity\AttestationStage;
use App\Entity\Presentation;
use App\Form\AttestationStageType;
use App\Form\PresentationType;
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
class AttestationController extends AbstractController
{
    #[Route('/attestation', name: 'app_attestation')]
    public function deposerPresentation(ManagerRegistry $doctrine , Request $request ,UploaderPdf $uploaderPdf): Response
    {

        if(!$this->getUser()->getAttestationStage()){
            $attestationStage = new attestationStage();
            $attestationStage->setEstDeploye(false);
        }else{
            $repository = $doctrine->getRepository(AttestationStage::class);
            $attestationStage = $repository->find($this->getUser()->getAttestationStage()->getId());
            $attestationStage->setEstDeploye(false);
        }

        $attestationStageForm = $this->createForm(AttestationStageType::class, $attestationStage);
        $attestationStageForm->remove('user');
        $attestationStageForm->handleRequest($request);
        
        if ($attestationStageForm->isSubmitted() && $attestationStageForm->isValid()) { 
            $attestationStagePDF = $attestationStageForm->get('fichier')->getData();
            $manager = $doctrine->getManager();
            
            if ($attestationStagePDF) {
                
                $attestationStageDirectory = $this->getParameter('attestation_directory');
                $attestationStage->setEstDeploye(true);
                $attestationStage->setFichier($uploaderPdf->uploadPdf($attestationStagePDF , $attestationStageDirectory ));
                $attestationStage->setUser($this->getUser());
                $manager->persist($attestationStage);
                $manager->flush();
                $this->addFlash('success', 'Votre attestation du stage a été bien ajouté avec success');

                return  $this->redirectToRoute('app_profile');
            }
        }


        return $this->render('attestationStage/attestationStage.html.twig', [
            'attestationStageForm' => $attestationStageForm->createView()
        ]);
    }
}
