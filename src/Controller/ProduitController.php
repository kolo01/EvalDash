<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'produit_liste')]
    public function index(ProduitRepository $produit): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produit->findAll(),
        ]);
    }
    #[Route('/Ajout-produit', name: 'produit_new')]
    public function new(Request $req, ManagerRegistry $doctrine): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        if ($req->isMethod('POST')) {
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $doctrine->getManager();
                $em->persist($produit);
                $em->flush();
                $message = 'Le Produit a ete ajoute avec succes';
            }
            return $this->render('produit/new.html.twig', [
                'form' => $form->createView(),
                'message' => $message
            ]);
        } else {
            return $this->render('produit/new.html.twig', [
                'form' => $form->createView(),
                'message' => ''
            ]);
        }
        return $this->render('produit/index.html.twig', []);
    }
    #[Route('/produit/{id}', name: 'produit_show', methods: ['GET', 'POST'])]
    public function edit(Produit $produit, Request $req, ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_liste');
        }
        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/delete/{id}', name: 'produit_delete', methods: ['GET', 'delete'])]
    public function delete(Produit $produit, Request $req, ManagerRegistry $doctrine): Response
    {


        $em = $doctrine->getManager();
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('produit_liste');
    }
}
