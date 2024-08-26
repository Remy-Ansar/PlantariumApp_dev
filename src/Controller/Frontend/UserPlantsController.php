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
use App\Repository\FamiliesRepository;
use App\Repository\SpeciesRepository;
use App\Repository\ColorsRepository;
use App\Repository\SeasonsRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/users', name: 'users')]
class UserPlantsController extends AbstractController
{   
    private $plantsRepository;
    private $speciesRepository;
    private $familiesRepository;
    private $colorsRepository;
    private $seasonsRepository;
    private $categoriesRepository;

    public function __construct(
        private readonly UserPlantFactory $userPlantFactory,
        private readonly EntityManagerInterface $em,
        private readonly Security $security,
        private readonly UserPlantsRepository $userPlantsRepository,
        private readonly UserPlantManager $userPlantManager,
        SpeciesRepository $speciesRepository,
        FamiliesRepository $familiesRepository,
        ColorsRepository $colorsRepository,
        SeasonsRepository $seasonsRepository,
        CategoriesRepository $categoriesRepository,
        PlantsRepository $plantsRepository
    ) {
        $this->plantsRepository = $plantsRepository;
        $this->speciesRepository = $speciesRepository;
        $this->familiesRepository = $familiesRepository;
        $this->colorsRepository = $colorsRepository;
        $this->seasonsRepository = $seasonsRepository;
        $this->categoriesRepository = $categoriesRepository;
    }
    
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof Users) {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé.');
            return $this->redirectToRoute('app_login');
        }
    
        // Utiliser la méthode findUserPlantsByUser pour récupérer les plantes de cet utilisateur
        $userPlants = $this->userPlantsRepository->findUserPlantsByUser($user);
    
        return $this->render('Frontend/UserPlants/UserPlantProfile/index.html.twig', [
            'userPlants' => $userPlants
        ]);
    }

    #[Route('/calendar', name: '.calendar', methods : ['GET', 'POST'])]
    public function calendar(): Response
    {
        return $this->render('Frontend/UserPlants/Calendar/index.html.twig');
    }

    #[Route('/plantarium', name: '.plantarium', methods: ['GET', 'POST'])]
    public function plantariumList(Request $request, PaginatorInterface $paginator, PlantsRepository $plantsRepository): Response
    {

        $session = $request->getSession();
        $page = $request->query->getInt('page', 1);
        $session->set('plants_page', $page);

        // Récupération des filtres depuis la requête
        $filters = $request->query->all();
        $query = $plantsRepository->findEnabledPlantsQuery($filters);

        // Application des filtres
        $plants = [];

        if (!empty($filters['name'])) {
            $plants = $this->plantsRepository->findPlantsByName($filters['name']);
        } elseif (!empty($filters['species'])) {
            $plants = $this->plantsRepository->findPlantsBySpecies((int)$filters['species']);
        } elseif (!empty($filters['families'])) {
            $plants = $this->plantsRepository->findPlantsByFamilies((int)$filters['families']);
        } elseif (!empty($filters['colors'])) { 
            $plants = $this->plantsRepository->findPlantsByColors((int)$filters['colors']);
        } elseif (!empty($filters['seasons'])) {
            $plants = $this->plantsRepository->findPlantsBySeasons((int)$filters['seasons']);
        } elseif (!empty($filters['categories'])) { 
            $plants = $this->plantsRepository->findPlantsByCategories((int)$filters['categories']);
        } else {
            $plants = $this->plantsRepository->findEnabledPlantsQuery($filters);
        }

    // Pagination des résultats filtrés
    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        6
    );

    // Récupération des valeurs nécessaires pour les filtres
    $species = $this->speciesRepository->findAll();
    $families = $this->familiesRepository->findAll();
    $colors = $this->colorsRepository->findAll();
    $seasons = $this->seasonsRepository->findAll();
    $categories = $this->categoriesRepository->findAll();

    return $this->render('Frontend/UserPlants/PlantList/index.html.twig', [
        'pagination' => $pagination,
        'species' => $species,
        'families' => $families,
        'colors' => $colors,
        'seasons' => $seasons,
        'categories' => $categories,
    ]);
}


#[Route('/plantarium/addPlant', name: '.plantarium.addPlant', methods: ['GET', 'POST'])]
public function addPlant(Request $request, PaginatorInterface $paginator): Response
{
    $session = $request->getSession();
    $page = $session->get('plants_page', 1);

    // Fetch the Current User
    $user = $this->getUser();
    if (!$user instanceof Users) {
        $this->addFlash('danger', 'Vous n\'êtes pas autorisé.');
        return $this->redirectToRoute('app_login');
    }

    // Get the Plant ID from the request
    $plantId = $request->request->get('plant_id');
    if (!$plantId) {
        $this->addFlash('danger', 'Plant ID is missing.');
        return $this->redirectToRoute('users.plantarium');
    }

    // Fetch the Plant Entity
    $plant = $this->em->getRepository(Plants::class)->find($plantId);
    if (!$plant) {
        $this->addFlash('danger', 'La plante n\'existe pas.');
        return $this->redirectToRoute('users.plantarium');
    }

    // Fetch or create UserPlants entity
    $userPlant = $this->em->getRepository(UserPlants::class)->findOneBy(['User' => $user]);

    if ($userPlant === null) {
        $userPlant = new UserPlants();
        $userPlant->setUser($user);
        $userPlant->setPlant($plant);
        $this->em->persist($userPlant);
    }

    // Create and persist the PlantDetail entity
    $plantDetail = new PlantDetail();
    $plantDetail->setUserPlants($userPlant); // Set the existing UserPlants instance
    $plantDetail->setPlant($plant);
    $this->em->persist($plantDetail);

    // Flush changes to the database
    $this->em->flush();

    // Fetch and paginate the plants for the view
    $plants = $this->plantsRepository->findAll();
    $pagination = $paginator->paginate($plants, $page, 6);

    // Add a success message and redirect
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
