<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class ExController extends AbstractController
{
    #[Route('/ex', name: 'app_ex')]
    public function index(): Response
    {
        
        return $this->render('ex/index.html.twig', [
            'controller_name' => 'ExController',
        ]);
    }
}
