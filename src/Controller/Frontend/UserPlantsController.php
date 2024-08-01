<?php

namespace App\Controller\Frontend;

use App\Entity\Users;
use App\Entity\Plants;
use App\Entity\UserPlants;
use App\Entity\PlantDetail;
use App\Factory\UserPlantFactory;
use App\Manager\UserPlantManager;
use App\Repository\UsersRepository;
use App\Repository\PlantsRepository;
use App\Repository\UserInfosRepository;
use App\Repository\UserPlantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
        private readonly PlantsRepository $plantsRepository,
        private readonly UserPlantManager $userPlantManager,
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
    public function plantariumList(Request $request, PaginatorInterface $paginator, ?Plants $plants): Response
    {
        $queryBuilder = $this->plantsRepository->paginationOrder();

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            5 /* limit per page */
        );


        return $this->render('Frontend/UserPlants/PlantList/index.html.twig',  [
            // 'plants' => $this->plantsRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

    #[Route('/plantarium/addPlant', name: '.plantarium.addPlant', methods: ['GET','POST'])]
    public function addPlant(Request $request): Response
        {
            // Step 2: Fetch the Current User and Selected Plant
            $user = $this->getUser();
            if (!$user instanceof Users) {
                $this->addFlash('danger', 'Vous n\'êtes pas authorisé.');
                return $this->redirectToRoute('app_login');
            }
    
            $plantId = $request->request->get('plant_id'); // Ensure the form sends plant_id as POST parameter
            if (!$plantId) {
                $this->addFlash('danger', 'Plant ID is missing.');
                return $this->redirectToRoute('users.plantarium');
            }
    
            $plant = $this->em->getRepository(Plants::class)->find($plantId);
            if (!$plant) {
                $this->addFlash('danger', 'La plante n\'existe pas.');
                return $this->redirectToRoute('users.plantarium');
            }
    
            // Create and Persist the UserPlant Entity and the related plantDetail 
            $userPlant = new UserPlants();
            $plantDetail = new PlantDetail();
            $userPlant->setUser($user, $plantDetail);
            $userPlant->setPlant($plant, $plantDetail);
            
    
            $this->em->persist($userPlant, $plantDetail);
            $this->em->flush();
    
            $this->addFlash('success', 'Votre plante a bien été ajoutée.');
            return $this->redirectToRoute('users.plantarium');
        }

        // #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
        // public function deleteUserPlant(?UserPlants $userPlant, Request $request): RedirectResponse
        // {
        //     if (!$userPlant) {
        //         $this->addFlash('danger', 'Cette plante ne fait pas partie de votre profil.');

        //         return $this->redirectToRoute('users.index');
        //     }

        //     if ($this->isCsrfTokenValid('delete' . $userPlant->getId(), $request->request->get('token'))) {
        //         $this->em->remove($userPlant);
        //         $this->em->flush();
    
        //         $this->addFlash('success', 'La plante a été supprimée avec succès.');
        //     } else {
        //         $this->addFlash('danger', 'Le token CSRF est invalide.');
        //     }
    
        //     return $this->redirectToRoute('users.index');

        // }
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
