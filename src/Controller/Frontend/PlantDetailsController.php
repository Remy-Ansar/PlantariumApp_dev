<?php

namespace App\Controller\Frontend;

use App\Entity\Diseases;
use App\Entity\HealthStatus;
use App\Entity\Plants;
use App\Entity\UserPlants;
use App\Entity\PlantDetail;
use App\Repository\PlantsRepository;
use App\Form\UserPlantDetailFormType;
use App\Repository\FamiliesRepository;
use App\Repository\UserPlantsRepository;
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
        private readonly FamiliesRepository $familiesRepository,
        private readonly UserPlantsRepository $userPlantsRepository,
    ) {
    }
    
#[Route('/user/plantarium/{name}/details', name: 'plantarium.details', methods: ['GET', 'POST'])]
public function PlantariumDetail(string $name): Response | RedirectResponse
{
    $plant = $this->plantsRepository->findOneBy(['Name' => $name]);

    if (!$plant) {
        $this->addFlash('error', 'Cette plante n\'existe pas');

        return $this->redirectToRoute('editor.plants.index',  [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('Frontend/PlantDetails/PlantariumDetails.html.twig', [
        'plant' => $plant,
    ]);
}

#[Route('/user/{name}/details', name: 'userPlants.details', methods: ['GET'])]
    public function UserPlantDetails(string $name): Response
    {
        $plant = $this->plantsRepository->findOneBy(['Name' => $name]);

        if (!$plant) {
            $this->addFlash('error', 'Cette plante n\'existe pas');
            return $this->redirectToRoute('editor.plants.index');
        }

        // Fetch existing PlantDetail for this plant if it exists
        $plantDetail = $this->em->getRepository(PlantDetail::class)->findOneBy(['Plant' => $plant]);

        if (!$plantDetail) {
            // If no PlantDetail exists, create a new one
            $plantDetail = new PlantDetail();
            $plantDetail->setPlant($plant);
            $this->em->persist($plantDetail);
            $this->em->flush();
        }

        return $this->render('Frontend/PlantDetails/UserPlantsDetails.html.twig', [
            'plant' => $plant,
            'plantdetail' => $plantDetail,
        ]);
    }

    #[Route('/user/{name}/details/{id}/edit', name: 'userPlants.details.edit', methods: ['GET', 'POST'])]
    public function UserPlantDetailsEdit(Request $request, PlantDetail $plantDetail): Response
    {
        if (!$plantDetail) {
            $this->addFlash('error', 'Cette plante n\'existe pas');
            return $this->redirectToRoute('editor.plants.index');
        }

        $form = $this->createForm(UserPlantDetailFormType::class, $plantDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();


            $this->addFlash('success', 'Les détails de la plante ont été modifiés avec succès.');
            return $this->redirectToRoute('userPlants.details', ['name' => $plantDetail->getPlant()->getName()]);
        }

        return $this->render('Frontend/PlantDetails/edit.html.twig', [
            'form' => $form->createView(),
            'plantdetail' => $plantDetail,

        ]);
    }
}

