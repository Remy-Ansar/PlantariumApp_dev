<?php

namespace App\Controller\Frontend;

use App\Entity\Plants;
use App\Repository\PlantsRepository;
use App\Repository\UsersRepository;
use App\Repository\UserInfosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/users', name: '.users')]
class UserPlantsController extends AbstractController
{
    public function __construct(
        private readonly UsersRepository $usersRepository,
        private readonly UserInfosRepository $userInfosRepository,
        private readonly PlantsRepository $plantsRepository,
        private readonly EntityManagerInterface $em,
    ) {
    }
    
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/UserPlants/index.html.twig', [
            'users' => $this->usersRepository->findAll(),
            'usersInfos' => $this->userInfosRepository->findAll(),
            'plants' => $this->plantsRepository->findAll(),
        ]);
    }
}
