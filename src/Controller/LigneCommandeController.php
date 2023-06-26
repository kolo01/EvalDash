<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LigneCommandeController extends AbstractController
{
    #[Route('/ligne/commande', name: 'app_ligne_commande')]
    public function index(): Response
    {
        return $this->render('ligne_commande/index.html.twig', [
            'controller_name' => 'LigneCommandeController',
        ]);
    }
}
