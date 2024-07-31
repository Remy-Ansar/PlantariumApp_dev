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

        if (!$userPlant) {
            $userPlant = new UserPlants();
            $userPlant->setPlant($plant);
            $userPlant->setUser($user);
            $this->em->persist($userPlant);
            $this->em->flush(); 
        }

        $plantDetail->setUserPlants($userPlant);

        $this->em->persist($plantDetail);
        $this->em->flush();
    }


    return $this->render('Frontend/PlantDetails/UserPlantsDetails.html.twig', [
        'plant' => $plant,
        'plantdetail' => $plantDetail,
    ]);
}

#[Route('/users/{name}/details/{id}/edit', name: 'userPlants.details.edit', methods: ['GET', 'POST'])]
public function UserPlantDetailsEdit(string $name, Request $request, PlantDetail $plantDetail, ?Plants $plant, ?HealthStatus $healthStatus, ?Diseases $diseases): Response
{
    $plant = $plantDetail->getPlant(); 

    if (!$plantDetail) {
        $this->addFlash('error', 'Cette plante n\'existe pas');
        return $this->redirectToRoute('users.index');
    }

    $form = $this->createForm(UserPlantDetailFormType::class, $plantDetail);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $newJournalEntry = $form->get('newJournalEntry')->getData();

            // Append the new entry to the existing journal content
            if ($newJournalEntry) {
                $currentDateTime = new \DateTime();
                $journalEntry = sprintf("[%s] %s\n\n", $currentDateTime->format('Y-m-d H:i:s'), $newJournalEntry);
                $plantDetail->setJournal($plantDetail->getJournal() . $journalEntry);
            }
            
        $this->em->persist($plantDetail);
        $this->em->flush();

        $this->addFlash('success', 'Les détails de la plante ont été modifiés avec succès.');
        return $this->redirectToRoute('userPlants.details', ['name' => $name]);
    }

    return $this->render('Frontend/PlantDetails/edit.html.twig', [
        'form' => $form,
        'plantdetail' => $plantDetail,
        'plant' => $plant,

    ]);
}
#[Route('/users/{name}/details/{id}/delete', name: 'userPlants.details.delete', methods: ['POST'])]
public function deletePlantDetail(?PlantDetail $plantDetail, ?UserPlants $userPlant, Request $request): RedirectResponse
{

    if (!$plantDetail && !$userPlant) {
        $this->addFlash('danger', 'Cette plante est introuvable. Êtes-vous certain de son identification?');
        return $this->redirectToRoute('users.index');
    }
    $userPlant =$plantDetail->getUserPlants(); 

    if ($this->isCsrfTokenValid('delete' . $plantDetail->getId(), $request->request->get('token'))) {
        $this->em->remove($plantDetail);
        
        if ($userPlant) {
            $this->em->remove($userPlant);
            $this->em->flush(); // Flush the changes to persist deletion of UserPlants
        }

        $this->addFlash('success', 'Le détail de la plante a été supprimé avec succès.');
    } elseif ($plantDetail) {
        $this->addFlash('danger', 'Le token CSRF est invalide pour la suppression du détail de la plante.');
    }

    // // Check if the CSRF token for UserPlants is valid and remove UserPlants if it exists
    // if ($userPlant && $this->isCsrfTokenValid('delete' . $userPlant->getId(), $request->request->get('token'))) {
    //     $this->em->remove($userPlant);
    //     $this->em->flush();
    //     $this->addFlash('success', 'La plante a été supprimée de votre profil avec succès.');
    // } elseif ($userPlant) {
    //     $this->addFlash('danger', 'Le token CSRF est invalide pour la suppression de la plante du profil.');
    // }

    return $this->redirectToRoute('users.index');
}
}

