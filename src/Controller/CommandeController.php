<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Form\CommandeType;
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
    public function new(Request $req, ManagerRegistry $doctrine): Response
    {
       
        $Commande = new Commande();
        $form = $this->createForm(CommandeType::class,  $Commande);
        if ($req->isMethod('POST')) {
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $doctrine->getManager();
                $em->persist($Commande);
                $em->flush();
                $message = 'La Commande a ete ajoute avec succes';
            }
            return $this->render('commande/new.html.twig', [
                'form' => $form->createView(),
                'message' => $message
            ]);
        } else {
            return $this->render('commande/new.html.twig', [
                'form' =>$form->createView(),
            ]);
        }
        return $this->render('commande/index.html.twig', []);
        // declarer un compteur pour avoir le numero de commande 
   
    }
}
