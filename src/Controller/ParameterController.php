<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Administrateur'),
    IsGranted('ROLE_ADMIN')
]
class ParameterController extends AbstractController
{
    #[Route('/parameter', name: 'app_parameter_index')]
    public function index(): Response
    {
        return $this->render('parameter/index.html.twig', [
            'controller_name' => 'ParameterController',
        ]);
    }
    #[Route('/parameter', name: 'app_parameter_modal_config')]
    public function modalConfig(): Response
    {
        return $this->render('fragments/_config_user.html.twig');
    }
}
