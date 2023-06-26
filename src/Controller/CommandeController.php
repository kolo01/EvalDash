<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Form\CommandeType;
use App\Form\LigneCommamdeType;
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
    public function new(Request $req, ManagerRegistry $doctrine,ProduitRepository $prodRep, CommandeRepository $comRep,LigneCommandeRepository $lig): Response
    {
     
        $Commande = new Commande();
        $lCommande= new LigneCommande();
        $compteurC=(count($comRep->findAll()) + 1);
        $compteurL=(count($lig->findAll()) + 1);

        $form = $this->createForm(CommandeType::class,  $Commande);
        $form2 = $this->createForm(LigneCommamdeType::class,  $lCommande);
        $totttc = 0;
        $lig = 0;
        $choix = "";
        $session = $req->getSession();
        if (!$session->has('commande')) {
            $session->set('commande', array());
        }
        $Tabcomm = $session->get('commande', []);
        // if ($req->isMethod('POST')) {
            $form->handleRequest($req);
            $form2->handleRequest($req);
            $choix = $req->get('bt');

            if ($choix == "Valider") {


                $em = $doctrine->getManager();
                $lig = sizeof($Tabcomm);
                for ($i = 1; $i <= $lig; $i++) {
                    $lCommande= new LigneCommande();
                    $prod = $prodRep->findOneBy(array('id' => $Tabcomm[$i]->getProduit()));
                    $lCommande->setProduit($prod);
                    $lCommande->setNumc($compteurC);
                    $lCommande->setPrixVente($Tabcomm[$i]->getPv());
                    $lCommande->setquantite($Tabcomm[$i]->getQte());
                  
                    $em->persist($lCommande);
                    $em->flush();
                    $montht = $Tabcomm[$i]->getPrixVente() * $Tabcomm[$i]->getquantite();
                    $totttc = $totttc + $montht;
                }

                
                $Commande->settotal($totttc);
                $em->persist($Commande);
                $em->flush();
                $message = 'La Commande a ete ajoute avec succes';
            } else if ($choix == "Add") {
                $montht = $lCommande->getPrixVente() * $lCommande->getquantite();
                $lig = sizeof($Tabcomm) + 1;
                $lCommande->setNumC($compteurC);
                // $lCommande->setLig($lig);
                $Tabcomm[$lig] = $lCommande;
                $session->set('commande', $Tabcomm);
            }
            // if ($form->isSubmitted() && $form->isValid() || $form2->isSubmitted() && $form2->isValid()) {
            //     $em = $doctrine->getManager();
            //     $em->persist($lCommande);
            //     $em->persist($Commande);
            //     $em->flush();
              
            // }
           
            return $this->render('commande/new.html.twig', [
                'form' => $form->createView(),
                'form2'=>$form2->createView(),
                'message' => $message,
                'numc'=>$compteurC,
                'montht'=>$montht,
                'lcomm' => $Tabcomm,
                'totttc' => $totttc,
                
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
