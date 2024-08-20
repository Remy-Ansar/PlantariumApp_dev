<?php

namespace App\Controller\Backend;

use App\Entity\Warnings;
use App\Form\WarningsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;

class WarningsController extends AbstractController
{
    #[Route('/warnings/new', name: 'warnings_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $warning = new Warnings();
        $form = $this->createForm(WarningsType::class, $warning);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($warning);
            $entityManager->flush();

            return $this->redirectToRoute('warnings_list'); // Change 'warnings_list' to your route
        }

        return $this->render('warnings/new.html.twig', [
            'form' => $form
        ]);
    }
}
