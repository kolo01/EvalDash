<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(ClientRepository $clientRepository): Response
    {
       
        
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
        
    }
    #[Route('/newclient', name: 'app_client_add')]
    public function new(Request $req,ManagerRegistry $doctrine): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        if ($req->isMethod('POST'))
            {
                $form->handleRequest($req);
                if ($form->isSubmitted() && $form->isValid())
                {
                    $em = $doctrine->getManager();
                    $em->persist($client);
                    $em->flush();
                    $message='Le Client a ete ajoute avec succes';
                }
                return $this->render('client/ajouter.html.twig', [
                    'form' => $form->createView(),
                    'message'=> $message]);
            }else {
                return $this->render('client/ajouter.html.twig', [
                    'form' => $form->createView(),
                    'message'=> '']);
            }
        
    }
    #[Route('/editClient/{id}', name: 'app_client_edit', methods:["GET","POST"])]
    public function edit(Request $req,ManagerRegistry $doctrine,Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($client);
            $em->flush();
            $message='Le Client a ete ajoute avec succes';
            return $this->redirectToRoute('app_client');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
       
    }
    #[Route('/deleteClient/{id}', name: 'app_client_del', methods:['GET','delete'])]
    public function delete(Request $req,ManagerRegistry $doctrine,Client $client): Response
    {
       
        $em = $doctrine->getManager();
        $em->remove($client);
        $em->flush();
        

        return $this->redirectToRoute('app_client');
        
    }
   
}
