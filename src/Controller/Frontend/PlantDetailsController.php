<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlantDetailsController extends AbstractController
{
    #[Route('/plant/details', name: 'app_plant_details')]
    public function index(): Response
    {
        return $this->render('plant_details/index.html.twig', [
            'controller_name' => 'PlantDetailsController',
        ]);
    }
}
