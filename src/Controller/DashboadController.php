<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboadController extends AbstractController
{
    #[Route('/dashboad', name: 'app_dashboard')]
    public function index(ClientRepository $client, ProduitRepository $prod, LigneCommandeRepository $ligne): Response
    {   
        $C= $client->findAll();
        $numC = count($C);
        $P= $prod->findAll();
        $numP = count($P);
        $Com= $ligne->findAll();
        $numCom = count($Com);
        return $this->render('dashboard/index.html.twig', [
            'numC' => $numC,
            'numP' => $numP,
            'numCom' => $numCom,
        ]);
    }
}
