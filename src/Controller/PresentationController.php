<?php

namespace App\Controller;

use App\Entity\Presentation;
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
class PresentationController extends AbstractController
{
    #[Route('/presentation', name: 'app_presentation')]
    public function deposerPresentation(ManagerRegistry $doctrine , Request $request ,UploaderPdf $uploaderPdf): Response
    {

        
        if(!$this->getUser()->getPresentation()){
            $presentation = new Presentation();
            $presentation->setEstDeploye(false);
        }else{
            $repository = $doctrine->getRepository(Presentation::class);
            $presentation = $repository->find($this->getUser()->getPresentation()->getId());
            $presentation->setEstDeploye(false);
        }

        $presentationForm = $this->createForm(PresentationType::class, $presentation);
        $presentationForm->remove('user');
        $presentationForm->handleRequest($request);
        
        if ($presentationForm->isSubmitted() && $presentationForm->isValid()) { 
            $presentationPDF = $presentationForm->get('fichier')->getData();
            $manager = $doctrine->getManager();
            
            if ($presentationPDF) {
                
                $presentationDirectory = $this->getParameter('presentation_directory');
                $presentation->setEstDeploye(true);
                $presentation->setFichier($uploaderPdf->uploadPdf($presentationPDF , $presentationDirectory ));
                $presentation->setUser($this->getUser());
                
                $manager->persist($presentation);
                $manager->flush();
                $this->addFlash('success', 'Votre Présentation a été bien ajouté avec success');

                return  $this->redirectToRoute('app_profile');
            }
        }


        return $this->render('presentation/deposerPresentation.html.twig', [
            'presentationForm' => $presentationForm->createView()
        ]);
    }
}
