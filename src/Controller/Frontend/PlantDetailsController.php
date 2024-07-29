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
use App\Repository\PlantDetailRepository;
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
        private readonly PlantDetailRepository $plantDetailRepository
    ) {
    }
    
#[Route('/users/plantarium/{name}/details', name: 'plantarium.details', methods: ['GET', 'POST'])]
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

#[Route('/users/{name}/details', name: 'userPlants.details', methods: ['GET'])]
public function UserPlantDetails(string $name): Response
{
    $plant = $this->plantsRepository->findOneBy(['Name' => $name]);

    if (!$plant) {
        $this->addFlash('error', 'Cette plante n\'existe pas');
        return $this->redirectToRoute('editor.plants.index');
    }

    $plantDetail = $this->em->getRepository(PlantDetail::class)->findOneBy(['Plant' => $plant]);

    if (!$plantDetail) {

        $plantDetail = new PlantDetail();
        $plantDetail->setPlant($plant);

        $user = $this->getUser();
        $userPlant = $this->userPlantsRepository->findOneBy(['plant' => $plant, 'User' => $user]);

        $userPlant->setPlant($plant);
        $userPlant->setUser($user);
        $this->em->persist($userPlant);
        $this->em->flush(); 

    $plantDetail->setUserPlants($userPlant);

        $healthStatus = new HealthStatus();
        $this->em->persist($healthStatus);

        $plantDetail->setHealthStatus($healthStatus);

        $this->em->persist($plantDetail);
        $this->em->flush();
    }

    return $this->render('Frontend/PlantDetails/UserPlantsDetails.html.twig', [
        'plant' => $plant,
        'plantdetail' => $plantDetail,
        
    ]);
}

#[Route('/users/{name}/details/{id}/edit', name: 'userPlants.details.edit', methods: ['GET', 'POST'])]
public function UserPlantDetailsEdit(string $name, Request $request, PlantDetail $plantDetail, ?Plants $plant, EntityManagerInterface $em, UserPlants $userPlant): Response
{
    if (!$plantDetail) {
        $this->addFlash('error', 'Cette plante n\'existe pas');
        return $this->redirectToRoute('editor.plants.index');
    }

    $plantDetail = $this->em->getRepository(PlantDetail::class)->findOneBy(['Plant' => $plant]);

    $form = $this->createForm(UserPlantDetailFormType::class, $plantDetail);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        foreach ($plantDetail->getDiseases() as $diseases) {
            $em->persist($diseases);
        }

        foreach ($plantDetail->getHealthStatus() as $healthStatus) {
            $em->persist($healthStatus);
        }

        foreach ($plantDetail->getUserPlants() as $userPlant) {
            $em->persist($userPlant);
        }

        $this->em->flush();

        $this->addFlash('success', 'Les détails de la plante ont été modifiés avec succès.');
        return $this->redirectToRoute('userPlants.details', ['name' => $name]);
    }

    return $this->render('Frontend/PlantDetails/edit.html.twig', [
        'form' => $form,
        'plantdetail' => $plantDetail,
        'plant' => $plant,
        'userplant' => $userPlant,
        

    ]);
}
}

