<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Remarques;
use App\Form\UserFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/user'),
  IsGranted('ROLE_USER')
]
class ProfilController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profil(): Response
    {
        $role = $this->getUser()->getRoles();
        // dd($this->getUser()->getStage());
        // $stage->isAFaitStage()
        return $this->render('profil/profil.html.twig',[
            'role'=> $role[0]
        ]);
    }
    #[Route('/EditProfile', name: 'app_edit_profile')]
    public function editProfile(ManagerRegistry $doctrine ,Request $request , SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class,$user);
        $form->remove('note');
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $doctrine->getManager(); 
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('picture_profile_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                // $user->setBrochureFilename($newFilename);
                $user->setImage($newFilename);
            }


            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Une modification a été effectué avec succes');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profil/editProfile.html.twig',[
          'form'=>$form->createView()
        ]);
    }
    #[Route('/showremarque/{id?0}', name:'app_show_remarque_user')
    ]
    public function listRemarque(User $user = null , ManagerRegistry $doctrine) :Response {

        $manager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Remarques::class);
        $remarques = $repository->findBy(['user'=> $user->getId()]);
        $user->setCheckRemarque(0);
        $manager->persist($user);
        $manager->flush();
        return $this->render('remarque/show_remarque_by_user.html.twig',[
            'remarques' =>$remarques
            
        ]);
    }

}
