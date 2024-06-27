<?php

namespace App\Controller\Frontend;

use App\Repository\UserPlantsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users/mes_plantes', name:'users.userPlants')]
class UserPlantsController extends AbstractController
{
    public function __construct(
        private readonly UsersRepository $usersRepository,
        private readonly UserPlantsRepository $userPlantsRepository,
        private readonly EntityManagerInterface $em,
    ) {   
        
    }

    #[Route('/', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/Userplants/index.html.twig', [
            'usersPlant' => $this->userPlantsRepository->findAll(),
        ]);
    }

}
