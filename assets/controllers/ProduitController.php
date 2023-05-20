<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produit;
use App\Form\FournisseurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'liste_produit')]
    public function index(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $produit = $em->getRepository(Produit::class)->findAll();
        return $this->render(
            'produit/index.html.twig',
            ['produit' => $produit]
        );
    }
    #[Route('/addproduit', name: 'add_produit')]
    public function add(ManagerRegistry $doctrine, Request $req)
    {
        $message = '';
        $produit = new Produit();
        $form = $this->createFormBuilder($produit)
            ->add('Nom de produit', TextType::class)
            ->add('quantité', NumberType::class)
            ->add('Prix de vente', NumberType::class)
            ->add('Prix d\'achat', NumberType::class)
          
            ->getForm();
        return $this->render(
            'produit/ajout.html.twig',
            [
                'produit' => $produit,
                'form' => $form
            ]
        );
    }
    #[Route('/updateproduit/{id}', name: 'update_produit')]
    public function update(ManagerRegistry $doctrine, $id, Request $request)
    {
        $message = '';
        $em = $doctrine->getManager();
        if (isset($id)) {
            // modification d'un acteur existant : on recherche ses données
            $produit = $em->getRepository(Produit::class)->find($id);
            if (!$produit) {
                $message = 'Aucun Produit trouvé';
            }
        } else {
            // ajout d'un nouvel acteur
            $produit = new Produit();
        }
        $form = $this->createFormBuilder($produit)
            ->add('Nom_de_produit', TextType::class)
            ->add('quantite', NumberType::class)
            ->add('Prix_de_vente', NumberType::class)
            ->add('Prix_Achat', NumberType::class)
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);;
            if ($form->isValid()) {
                $em = $doctrine->getManager();
                $em->persist($produit);
                $em->flush();
                $message = 'succes';
                if (isset($id)) {
                    $message = 'Produit modifié avec succès !';
                } else {
                    $message = 'Produit ajouté avec succès !';
                }
            }
        }
        return $this->render(
            'produit/update.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
            )
        );
    }
}
