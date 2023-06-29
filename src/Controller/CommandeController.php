<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Form\CommandeType;
use App\Form\LigneCommamdeType;
use App\Form\LigneCommandeType;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
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
    public function new(Request $req, ManagerRegistry $doctrine, ProduitRepository $prodRep, CommandeRepository $comRep, LigneCommandeRepository $lig): Response
    {

        $Commande = new Commande();
        
        $compteurC = (count($comRep->findAll()) + 1);
        $message = '';

        $form = $this->createForm(CommandeType::class,  $Commande);

        if ($req->isMethod('POST')) {
           
            $form->handleRequest($req);
           
            if ($form->isSubmitted() && $form->isValid()) {
                
                $em = $doctrine->getManager();
                $em->persist($Commande);
                
                $em->flush();
                $message = 'Commande effectue';
            }
        }

        return $this->render('commande/new.html.twig', [
            'form' => $form->createView(),
          
            'message' => $message,
            'numc' => $compteurC,




        ]);
        // } else {
        //     return $this->render('commande/new.html.twig', [
        //         'form' =>$form->createView(),
        //         'form2'=>$form2->createView(),
        //         'numc'=>$compteurC,
        //         'montht'=>0,
        //         'lcomm' => $Tabcomm,
        //         'totttc' => $totttc,
        //     ]);
        // }
        return $this->render('commande/index.html.twig', []);
        // declarer un compteur pour avoir le numero de commande 

    }
}
