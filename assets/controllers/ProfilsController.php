<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilsController extends AbstractController
{
    #[Route('/profils', name: 'app_profils')]
    public function index(): Response
    {
        return $this->render('profils/index.html.twig', [
            'controller_name' => 'ProfilsController',
        ]);
    }
}
