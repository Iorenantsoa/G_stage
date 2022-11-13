<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Entity\User;
use App\Form\RapportType;
use App\Services\UploaderPdf;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/user'),
    IsGranted('ROLE_USER')
]
class RapportController extends AbstractController
{



    #[Route('/rapport', name: 'app_deposerRapport')]
    public function deposerRapport(): Response
    {
        return $this->render('rapport/deposerRapport.html.twig');
    }


    #[Route('/firstrapport', name: 'app_firstRapport')]
    public function firstRapport( Request $request, UploaderPdf $uploaderPdf , ManagerRegistry $doctrine): Response
    {
        
        if(!$this->getUser()->getRapport() ){
            $rapport = new Rapport();
            $rapport->setFirstVersionEstDeploye(false);
            $rapport->setFirstVersionCreatedAt(new DateTime());
            $rapport->setFirstVersionUpdatedAt(new DateTime());
        }else{

            $repository = $doctrine->getRepository(Rapport::class);
            $rapport = $repository->find($this->getUser()->getRapport()->getId());
            $rapport->setFirstVersionEstDeploye(false);
        }
        $rapportForm = $this->createForm(RapportType::class, $rapport);
        $rapportForm->remove('user');
        $rapportForm->remove('last_version');
        
        $rapportForm->handleRequest($request);
      
        if($rapportForm->isSubmitted() && $rapportForm->isValid()){
            $firstVersion = $rapportForm->get('first_version')->getData();
            $manager = $doctrine->getManager();
            
            if ($firstVersion) {
                
                $firstVersionDirectory = $this->getParameter('rapport_first_version_directory');
                $rapport->setFirstVersionEstDeploye(true);
                $rapport->setFirstVersionUpdatedAt(new DateTime());
                $rapport->setFirstVersion($uploaderPdf->uploadPdf($firstVersion , $firstVersionDirectory ));
                $rapport->setUser($this->getUser());
                $manager->persist($rapport);
                $manager->flush();
                $this->addFlash('success', 'Votre première version du rapport a été bien ajouté');

                return  $this->redirectToRoute('app_profile');
            }
        }

        return $this->render('rapport/firstRapport.html.twig',[
            'firstForm'=>$rapportForm->createView()
        ]);
    }
    #[Route('/lastRapport', name: 'app_lastRapport')]
    public function lastRapport( Request $request, UploaderPdf $uploaderPdf, ManagerRegistry $doctrine): Response
    {
        if($this->getUser()->getRapport() == null ||  $this->getUser()->getRapport()->isFirstVersionEstDeploye() == false){
            return $this->redirectToRoute('app_deposerRapport');
        }
        if($this->getUser()->getRapport()->isFirstVersionEstDeploye() == true ){
            
            $repository = $doctrine->getRepository(Rapport::class);
            $rapport = $repository->find($this->getUser()->getRapport()->getId());
            
        }
       
        $rapportForm = $this->createForm(RapportType::class, $rapport);
        $rapportForm->remove('user');
        $rapportForm->remove('first_version');
        
        $rapportForm->handleRequest($request);
        if($rapportForm->isSubmitted() && $rapportForm->isValid()){
            $lastVersion = $rapportForm->get('last_version')->getData();
            $manager = $doctrine->getManager();
            
            if ($lastVersion) {
                
                $lastVersionDirectory = $this->getParameter('rapport_last_version_directory');
                if($this->getUser()->getRapport()->isLastVersionEstDeploye() == false){

                    $rapport->setLastVersionCreatedAt(new DateTime());
                    $rapport->setLastVersionUpdatedAt(new DateTime());
                }else{
                    $rapport->setLastVersionUpdatedAt(new DateTime());
                }
                
                $rapport->setLastVersionEstDeploye(true);
                $rapport->setLastVersion($uploaderPdf->uploadPdf($lastVersion , $lastVersionDirectory ));
                $this->addFlash('success', 'Votre version finale du rapport a été bien ajouté');
                $manager->persist($rapport);
                $manager->flush();
                return  $this->redirectToRoute('app_profile');
            }
            
        }
        return $this->render('rapport/lastRapport.html.twig',[
            'lastForm'=>$rapportForm->createView()
        ]); 
    }
}
