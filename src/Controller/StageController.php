<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\User;
use App\Form\EntrepriseType;
use App\Form\StageType;
use App\Form\UserFormType;
use App\Form\UserNoteType;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class StageController extends AbstractController
{
    #[Route('user/addStage', name: 'app_add_stage'
    ),
        IsGranted('ROLE_USER'
    )]
    public function addStage( Request $request , ManagerRegistry $doctrine): Response
    {
        
        $user = $this->getUser();
        
        if(!$this->getUser()->getEntreprise()){
            $entreprise = new Entreprise();
        }else{
            $repository = $doctrine->getRepository(Entreprise::class);
            $entreprise = $repository->find($this->getUser()->getEntreprise()->getId());

        }
        $entrepriseForm = $this->createForm(EntrepriseType::class , $entreprise);

        if(!$this->getUser()->getStage()){
            $stage = new Stage();
            $stage->setAFaitStage(false);
            $stage->setEncadre(false);
            
        }else{
            $repository = $doctrine->getRepository(Stage::class);
            $stage = $repository->find($this->getUser()->getStage()->getId());
            $stage->setAFaitStage(false);
        }
       
        $stageForm = $this->createForm(StageType::class , $stage);


        $stageForm->remove('user');
        
        $stageForm->remove('validation');

        $entrepriseForm->handleRequest($request);
        $stageForm->handleRequest($request);
        
        if ($entrepriseForm->isSubmitted()  && $stageForm->isSubmitted() ) { 
            $manager = $doctrine->getManager();
            $stage->setAFaitStage(true);
            $stage->setEncadre(false);
            $user->setStage($stage);
            $user->setEntreprise($entreprise);
            $manager->persist($entreprise);
            $manager->persist($stage);
            $manager->flush();
            $this->addFlash('success','Ajout stage avec success');
            return  $this->redirectToRoute('app_profile');
        }


        return $this->render('stage/addStage.html.twig',[
            'id_user'=>$this->getUser()->getId() ,
            'entrepriseForm'=> $entrepriseForm->createView(),
            'stageForm'=> $stageForm->createView()
        ]);
    }
    
    #[Route('enseignant/allStage', name:'app_all_user') ,
        IsGranted('ROLE_ENSEIGNANT')
     ]
    public function allStage(ManagerRegistry $doctrine ){

        $repository = $doctrine->getRepository(Stage::class);
        $allStages = $repository->findAll();
        return $this->render('stage/all_stage.html.twig',[
            'all_stages' => $allStages
        ]);
    }
    #[Route('Adminisrateur/allStage', name:'app_all_user_by_admin') ,
        IsGranted('ROLE_ADMIN')
     ]
     public function allStageByAdmin(ManagerRegistry $doctrine ){

        $repository = $doctrine->getRepository(Stage::class);
        $allStages = $repository->findAll();
        return $this->render('stage/all_stage_by_admin.html.twig',[
            'all_stages' => $allStages
        ]);
    }
    

    #[Route('enseignant/stageAValider/{id?0}', name:'app_valider_encadrement') ,
        IsGranted('ROLE_ENSEIGNANT')]
    public function stageAValider(Stage $stage=null , ManagerRegistry $doctrine ) :Response {

        if($stage){
            $manager = $doctrine->getManager();
            $stage->getUser()->setUser($this->getUser());
            $stage->setEncadre(true);
            $manager->persist($stage);
            $manager->flush();
            $this->addFlash('success','Encadrement effectuée');
           return $this->redirectToRoute('app_stage_a_encadrer');
        }else{
            $this->addFlash('danger','La stage n\'existe pas');
            return $this->redirectToRoute('app_stage_a_encadrer');
        }
       return $this->redirectToRoute('app_stage_a_encadrer');
    }
    #[Route('enseignant/stageAEncadrer', name:'app_stage_a_encadrer') ,
        IsGranted('ROLE_ENSEIGNANT')]
    public function stageAEncadrer(ManagerRegistry $doctrine ){

        $repository = $doctrine->getRepository(Stage::class);
        // $stageAEncadrer = $repository->findStageAEncadrer();
        $stageAEncadrer = $repository->findStageAEncadrer();

        return $this->render('stage/stage_a_encadrer.html.twig',[
            'stage_a_encadrer' => $stageAEncadrer
        ]);
    }

    #[Route('enseignant/MesEncadrements', name:'app_mes_encadrement') ,
        IsGranted('ROLE_ENSEIGNANT')]
        public function mesEncadrements(ManagerRegistry $doctrine ){
            $repository = $doctrine->getRepository(User::class);
            
            $mesEncadrements = $repository->findMyEncadrements($this->getUser()->getId());
    
            return $this->render('stage/mes_encadrements.html.twig',[
                'mes_encadrements' => $mesEncadrements
            ]);
        }
        #[Route('enseignant/AnnulationEncadrement/{id?0}', name:'app_annulation_encadrement') ,
        IsGranted('ROLE_ENSEIGNANT')]
        public function annulationEncadrements( User $user=null , ManagerRegistry $doctrine ) : Response {
            $manager = $doctrine->getManager();
            $user->getStage()->setEncadre(false);
            $user->setUser(NULL);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Annulation d\'encadrement effectuée avec success');
            
            return $this->redirectToRoute('app_stage_a_encadrer');
        }
        #[Route('enseignant/validationStageSoutenance', name:'app_valider_stage_soutenance') ,
        IsGranted('ROLE_ENSEIGNANT')]
        public function vaiderStageSoutenance( ManagerRegistry $doctrine ) : Response {
            $repository = $doctrine->getRepository(User::class);
            $mes_encadrements = $repository->findMyEncadrements($this->getUser()->getId());
            
            return $this->render('stage/valider_stage_soutenance.html.twig', [
                'mes_encadrements'=> $mes_encadrements
            ]);
        }

        #[Route('enseignant/validation/{id?0}', name:'app_valider_stage') ,
        IsGranted('ROLE_ENSEIGNANT')]
        public function validerStageSoutenance( User $user=null , ManagerRegistry $doctrine ) : Response {
            $manager = $doctrine->getManager();
            $user->getStage()->setValidation("YES");
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Validation effectué avec success');
            
            return $this->redirectToRoute('app_valider_stage_soutenance');
        }
        #[Route('enseignant/notvalidation/{id?0}',name:'app_ne_pas_valider_stage'),
            IsGranted('ROLE_ENSEIGNANT')
        ]
        public function nePasValiderLaStage (User $user , ManagerRegistry $doctrine) : RedirectResponse {
            $manager = $doctrine->getManager();
            $user->getStage()->setValidation("NO");
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Etudiant non validé');
            return $this->redirectToRoute('app_valider_stage_soutenance');
        }
        #[Route('enseignant/attributNote' , name:'app_attribution_note'),
        IsGranted('ROLE_ENSEIGNANT')]
        public function attributNote(  ManagerRegistry $doctrine ,Request $request):  Response {

            
            $userRepository = $doctrine->getRepository(User::class) ;
            $userEcadreValid = $userRepository->findStageANoter($this->getUser());
            // dd($user);
            // $user_a_noter = $userRepository->find($id);

            // $form = $this->createForm(UserNoteType::class , $user_a_noter);

            return $this->render('stage/attribution_note.html.twig',[
                'usersEcadreValid' => $userEcadreValid,
                // 'form' =>$form->createView()
            ]);
        }
        #[Route('enseignant/noteModal/{id}' , name:'app_note_modal'),
        IsGranted('ROLE_ENSEIGNANT')]
        public function noteModal( User $user = null , ManagerRegistry $doctrine ,Request $request):  Response {
            $form = $this->createForm(UserNoteType::class , $user);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) { 
                $manager = $doctrine->getManager();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success','Etudiant noté');
                return $this->redirectToRoute('app_attribution_note');
            }

            return $this->render('fragments/_attributionNoteModale.html.twig',[
                'form' =>$form->createView(),
                'user' => $user
            ]);
        }
        
        #[Route('Administrateur/listeEtudiantAvecEncadreur' , name:"app_etudiant_encadreur") ,
            IsGranted('ROLE_ADMIN')
        ]
        public function listeEtudiantEncadreur( ManagerRegistry $doctrine ) :Response{

            $repository = $doctrine->getRepository(User::class);
            $users = $repository->findUserHaveEncadreur();
            
            // dd($users);
            return $this->render('stage/liste_etudiant_par_encadreur.html.twig',[
                'users' =>  $users
            ]);
        }
        #[Route('Administrateur/listeEtudiantSansEncadreur' , name:"app_etudiant_sans_encadreur") ,
            IsGranted('ROLE_ADMIN')
        ]
        public function listeEtudiantSansEncadreur( ManagerRegistry $doctrine ) :Response{

            $repository = $doctrine->getRepository(User::class);
            $users = $repository->findUserDontHaveEncadreur("ROLE_USER");
            
            
            return $this->render('stage/liste_etudiant_pas_encadreur.html.twig',[
                'users' =>  $users
            ]);
        }
        #[Route('Administrateur/listeEtudiantSansRapport' , name:"app_etudiant_sans_rapprort") ,
            IsGranted('ROLE_ADMIN')
        ]
        public function listeEtudiantSansRapport( ManagerRegistry $doctrine ) :Response{

            $repository = $doctrine->getRepository(User::class);
            $users = $repository->findUserDontHaveRapport("ROLE_USER");
            return $this->render('stage/liste_pas_de_rapport.html.twig',[
                'users' =>  $users
            ]);
        }
        #[Route('Administrateur/listeStageValide' , name:"app_liste_stage_valide") ,
            IsGranted('ROLE_ADMIN')
        ]
        public function listeStageValide( ManagerRegistry $doctrine ) :Response{

            $repository = $doctrine->getRepository(Stage::class);
            $stages = $repository->findStagevalide();

            return $this->render('stage/liste_stage_valide.html.twig',[
                'stages' =>  $stages
            ]);
        }
        #[Route('Administrateur/listeNoteEtudian' , name:"app_liste_note_etudiant") ,
        IsGranted('ROLE_ADMIN')
        ]
        public function listeNoteEtudiant( ManagerRegistry $doctrine ) :Response{

            $repository = $doctrine->getRepository(User::class);
            $users = $repository->findUserNote();

            return $this->render('stage/liste_etudian_avec_note.html.twig',[
                'users' =>  $users
            ]);
        }
    }
    
   