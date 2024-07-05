<?php

namespace App\Controller\Frontend;

use App\Repository\PlantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/users/plants', name: 'users.plants')]
class ShowPlantsController extends AbstractController
{
    public function __construct(

        private readonly EntityManagerInterface $em,
        private readonly PlantsRepository $plantsRepository
    )
    {
        
    }

    #[Route('', name: 'index')]
    public function index(PlantsRepository $plantsRepository): Response
    {
        return $this->render('Frontend/Plants/index.html.twig', [
            'controller_name' => 'ShowPlantsController',
        ]);
    }
}
