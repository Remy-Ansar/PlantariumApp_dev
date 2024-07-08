<?php

namespace App\Controller\Frontend;

use App\Entity\Users;
use App\Entity\Plants;
use App\Entity\UserPlants;
use App\Factory\UserPlantFactory;
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


#[Route('/users', name: 'users')]
class UserPlantsController extends AbstractController
{
    public function __construct(
        private readonly UserPlantFactory $userPlantFactory,
        private readonly EntityManagerInterface $em,
        private readonly Security $security,
        private readonly UserPlantsRepository $userPlantsRepository,
        private readonly PlantsRepository $plantsRepository
    ) {
    }
    
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/UserPlants/UserPlantProfile/index.html.twig', [
            'userPlants' => $this->userPlantsRepository->findAll()
        ]);
    }

    #[Route('/calendar', name: '.calendar', methods : ['GET', 'POST'])]
    public function calendar(): Response
    {
        return $this->render('Frontend/UserPlants/Calendar/index.html.twig');
    }

    #[Route('/plantarium', name: '.plantarium', methods: ['GET', 'POST'])]
    public function plantariumList(?Plants $plants): Response
    {
        return $this->render('Frontend/UserPlants/PlantList/index.html.twig',  [
            'plants' => $this->plantsRepository->findAll(),
        ]);
    }

    #[Route('/plantarium/{id}/addPlant', name: '.plantarium.addPlant')]
    public function addPlant(Request $request, PlantsRepository $plantsRepository, int $id): Response
    {
        $user = $this->getUser();
        if (!$user instanceof Users) {
            $this->addFlash('danger', 'Vous n\'êtes pas authorisé.');
            return $this->redirectToRoute('app_login');
        }
    
        $userId = $user->getId();
        $plantId = $request->get('plant_id');
        if (!$plantId) {
            $this->addFlash('danger', 'La plante est introuvable.');
            return $this->redirectToRoute('users.plantarium');
        }
        
        // Debugging: log the plantId
        dump($plantId);

        $user = $this->em->getRepository(Users::class)->find($userId);
        if (!$user) {
            $this->addFlash('danger', 'L\'utilisateur n\'existe pas', 400);
            return $this->redirectToRoute('users.index');
        }

        $plant = $this->em->getRepository(Plants::class)->find($plantId);
        if (!$plant) {
        $this->addFlash('danger', 'La plante n\'existe pas', 400);
        return $this->redirectToRoute('users.plantarium');
        }
        $userPlant = new UserPlants();
        $plant = $plantsRepository->find($id);
        $userPlant = $plant->setUserPlant();

        // $userPlant = $this->userPlantFactory->createUserPlant($plant);

        $this->em->persist($userPlant);
        $this->em->flush();

        return new Response('Votre plante à bien été ajoutée.');

    }

    // #[Route('/{id}/mesPlantes', name: '.myplants', methods: ['GET'])]
    // public function myPlants(): Response
    // {
    //     $user = $this->security->getUser();
    //     if (!$user) {
    //         $this->addFlash('danger', 'Cet utilisateur est introuvable.');

    //         return $this->redirectToRoute('.users.index');
    //     }

    //     $userPlants = $this->userPlantsRepository->findBy(['user' => $user]);

    //     return $this->render('Frontend/UserPlants/UserPlantProfile/index.html.twig', [
    //         'userPlants' => $userPlants,
    //     ]);
    // }

    // #[Route('/{plantId}/addPlant', name: '.add.plants')]
    // public function addPlantToUser(int $plantId): Response
    // {
    //     $user = $this->security->getUser();
    //     if (!$user) {
    //         $this->addFlash('danger', 'Cet utilisateur est introuvable.');

    //         return $this->redirectToRoute('.users.index');
    //     }

    //     $plant = $this->em->getRepository(Plants::class)->find($plantId);
    //     if (!$plant){
    //         $this->addFlash('danger', 'Cette plante n\'existe pas');

    //         return $this->redirectToRoute('.users.index');
    //     } 

    //     $userPlant = new UserPlants();
    //     $userPlant->setUser($user);
    //     $userPlant->addPlant($plant);

    //     $this->em->persist($userPlant);
    //     $this->em->flush();

    //     $this->addFlash('success', 'Cette plante a bien été ajoutée à votre profil.');

    //     return $this->redirectToRoute('.users.index');
    
    // }
    // #[Route('/showPlants', name: '.showPlants', methods:['GET', 'POST'])]
    // public function showPlant(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    // {
        
    // }
}
