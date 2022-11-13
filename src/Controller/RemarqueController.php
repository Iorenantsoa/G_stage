<?php

namespace App\Controller;

use App\Entity\Remarques;
use App\Entity\User;
use App\Form\RemarqueType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/enseignant')]
class RemarqueController extends AbstractController
{

    #[Route('/remarque/{id?0}', name: 'app_remarquer'), 
        IsGranted("ROLE_ENSEIGNANT")
    ]
    public function remarquer(User $user = null , Request $request , ManagerRegistry $doctrine): Response
    {
        $remarque = new Remarques();

        $remarqueForm = $this->createForm(RemarqueType::class , $remarque);
        $remarqueForm->remove('user');
        $remarqueForm->remove('createdAt');

        $remarqueForm->handleRequest($request);
        
        if ($remarqueForm->isSubmitted() ) { 
            $manager = $doctrine->getManager();
            $remarque->setUser($user);
            
            $nbremarque = 0;
            if($user->getCheckRemarque() == null ){
                $nbremarque = 0;
            }else{
                $nbremarque = $user->getCheckRemarque();
            }
            $nbremarque++;
            $user->setCheckRemarque($nbremarque);
            
            
            $manager->persist($remarque);
            $manager->flush();
            $this->addFlash('success','Remarque ajoutée');
            return $this->redirect('/enseignant/showprofile/'.$user->getId());
        }
        return $this->render('fragments/_remarques.html.twig', [
            'remarqueForm' => $remarqueForm->createView(),
            "remarque" => $remarque,
            'user' => $user
        ]);
    }
    #[Route('list/remarque/{id?0}', name:'app_list_remarque')
    ]
    public function listRemarque(User $user , ManagerRegistry $doctrine) :Response {

        $role = $this->getUser()->getRoles();
        $manager = $doctrine->getRepository(Remarques::class);
        $remarques = $manager->findBy(['user'=> $user->getId()]);
       
        return $this->render('remarque/liste_remarque.html.twig',[
            'remarques' =>$remarques,
            'role'=> $role[0]
            
        ]);
    }
    
}
