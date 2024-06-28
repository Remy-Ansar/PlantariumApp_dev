<?php

namespace App\Controller\Backend;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/[admin,editor]/plants', name: 'app.plants')]
class PlantsController extends AbstractController
{
    public function __construct(

        private readonly EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('plants/index.html.twig', [
            'controller_name' => 'PlantsController',
        ]);
    }
}
