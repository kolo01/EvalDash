<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
           
            'commandes' => $commandeRepository->findAll(),
        ]);
    }
    #[Route('/newCommand', name: 'app_commande_new')]
    public function new(Request $req,ManagerRegistry $em): Response
    {
        $client = new Client();
        $commande=new Commande();

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
