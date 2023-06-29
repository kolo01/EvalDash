<?php

namespace App\Controller;


use App\Entity\Commande;

use App\Form\CommandeType;

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
    // #[Route('/{id}', name: 'commande_delete', methods: ['POST'])]
    // public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
    //         $commandeRepository->remove($commande, true);
    //     }

    //     return $this->redirectToRoute('app_commande');
    // }

    #[Route('/commande/{id}/edit', name: 'commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,  CommandeRepository $commandeRepository,Commande  $commande): Response
    {
       
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_commande');
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }
    
    #[Route('/commande/{id}', name: 'commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
       
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }
}
