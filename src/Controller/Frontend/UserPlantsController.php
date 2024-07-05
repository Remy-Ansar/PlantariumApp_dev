<?php

namespace App\Controller\Frontend;

use App\Entity\Plants;
use App\Entity\UserPlants;
use App\Repository\UsersRepository;
use App\Repository\PlantsRepository;
use App\Repository\UserInfosRepository;
use App\Repository\UserPlantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/users', name: '.users')]
class UserPlantsController extends AbstractController
{
    public function __construct(
        private readonly UsersRepository $usersRepository,
        private readonly UserInfosRepository $userInfosRepository,
        private readonly PlantsRepository $plantsRepository,
        private readonly EntityManagerInterface $em,
        private readonly Security $security,
        private readonly UserPlantsRepository $userPlantsRepository,
    ) {
    }
    
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/UserPlants/UserPlantProfile/index.html.twig', [
            'users' => $this->usersRepository->findAll(),
            'usersInfos' => $this->userInfosRepository->findAll(),
            'plants' => $this->plantsRepository->findAll(),
            'userPlants' => $this->userPlantsRepository->findAll()
        ]);
    }

    #[Route('/{id}/mesPlantes', name: '.myplants', methods: ['GET'])]
    public function myPlants(): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Cet utilisateur est introuvable.');

            return $this->redirectToRoute('.users.index');
        }

        $userPlants = $this->userPlantsRepository->findBy(['user' => $user]);

        return $this->render('Frontend/UserPlants/UserPlantProfile/index.html.twig', [
            'userPlants' => $userPlants,
        ]);
    }

    #[Route('/{plantId}/addPlant', name: '.add.plants')]
    public function addPlantToUser(int $plantId): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Cet utilisateur est introuvable.');

            return $this->redirectToRoute('.users.index');
        }

        $plant = $this->em->getRepository(Plants::class)->find($plantId);
        if (!$plant){
            $this->addFlash('danger', 'Cette plante n\'existe pas');

            return $this->redirectToRoute('.users.index');
        } 

        $userPlant = new UserPlants();
        $userPlant->setUser($user);
        $userPlant->addPlant($plant);

        $this->em->persist($userPlant);
        $this->em->flush();

        $this->addFlash('success', 'Cette plante a bien été ajoutée à votre profil.');

        return $this->redirectToRoute('.users.index');
    
    }
    // #[Route('/showPlants', name: '.showPlants', methods:['GET', 'POST'])]
    // public function showPlant(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    // {
        
    // }
}
