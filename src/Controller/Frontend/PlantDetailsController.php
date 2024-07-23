<?php

namespace App\Controller\Frontend;

use App\Entity\Plants;
use App\Repository\PlantsRepository;
use App\Repository\FamiliesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PlantDetailsController extends AbstractController
{

    public function __construct(

        private readonly EntityManagerInterface $em,
        private readonly PlantsRepository $plantsRepository,
        private readonly FamiliesRepository $familiesRepository
    ) {
    }
#[Route('/user/plantarium/{name}/details', name: 'plantarium.details', methods: ['GET', 'POST'])]
public function PlnatariumDetail(string $name): Response | RedirectResponse
{
    $plant = $this->plantsRepository->findOneBy(['Name' => $name]);

    if (!$plant) {
        $this->addFlash('error', 'Cette plante n\'existe pas');

        return $this->redirectToRoute('editor.plants.index');
    }

    return $this->render('Frontend/PlantDetails/PlantariumDetails.html.twig', [
        'plant' => $plant,
    ]);
}

#[Route('/user/{name}/details', name: 'userPlants.details', methods: ['GET', 'POST'])]
public function UserPlantDetails(string $name): Response | RedirectResponse
{
    $plant = $this->plantsRepository->findOneBy(['Name' => $name]);

    if (!$plant) {
        $this->addFlash('error', 'Cette plante n\'existe pas');

        return $this->redirectToRoute('editor.plants.index');
    }

    // $form->

    return $this->render('Frontend/PlantDetails/UserPlantsDetails.html.twig', [
        'plant' => $plant,
    ]);
}

}