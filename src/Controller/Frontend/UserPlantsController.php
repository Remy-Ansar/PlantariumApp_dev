<?php

namespace App\Controller\Frontend;

use App\Entity\Users;
use App\Entity\Plants;
use App\Entity\UserPlants;
use App\Entity\PlantDetail;
use App\Factory\UserPlantFactory;
use App\Manager\UserPlantManager;
use App\Repository\UsersRepository;
use App\Repository\ColorsRepository;
use App\Repository\PlantsRepository;
use App\Repository\SeasonsRepository;
use App\Repository\SpeciesRepository;
use App\Repository\FamiliesRepository;
use App\Repository\UserInfosRepository;
use App\Repository\CategoriesRepository;
use App\Repository\UserPlantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlantDetailRepository;
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
        private readonly UserPlantManager $userPlantManager,
        private readonly SpeciesRepository $speciesRepository,
        private readonly FamiliesRepository $familiesRepository,
        private readonly ColorsRepository $colorsRepository,
        private readonly SeasonsRepository $seasonsRepository,
        private readonly CategoriesRepository $categoriesRepository,
        private readonly PlantsRepository $plantsRepository,
        private readonly PlantDetailRepository $plantDetailRepository
    ) {
    }
    
    //Page recensant toutes les plantes d'un utilisateur
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        // Verification de la connexion de l'utilisateur
        $user = $this->getUser();
        if (!$user instanceof Users) {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé.');
            return $this->redirectToRoute('app_login');
        }

        $session = $request->getSession();
        $page = $request->query->getInt('page', 1);
        $session->set('plants_page', $page);

        // Récupération des filtres depuis la requête
        $filters = $request->query->all();
        $query =$this->plantDetailRepository->findEnabledUserPlantsQuery($filters, $user);
       

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

        return $this->render('Frontend/UserPlants/UserPlantProfile/index.html.twig', [
            'pagination' => $pagination,
            'species' => $species,
            'families' => $families,
            'colors' => $colors,
            'seasons' => $seasons,
            'categories' => $categories,
    ]);
    }

    //Page de calendrier de l'utilisateur (travail en cours)
    #[Route('/calendar', name: '.calendar', methods : ['GET', 'POST'])]
    public function calendar(): Response
    {
        return $this->render('Frontend/UserPlants/Calendar/index.html.twig');
    }

    //Page listant les plantes disponibles à l'ajout pour les utilisateurs
    #[Route('/plantarium', name: '.plantarium', methods: ['GET', 'POST'])]
    public function plantariumList(Request $request, PaginatorInterface $paginator, PlantsRepository $plantsRepository): Response
    {

        $session = $request->getSession();
        $page = $request->query->getInt('page', 1);
        $session->set('plants_page', $page);

        // Récupération des filtres depuis la requête
        $filters = $request->query->all();
        $query = $plantsRepository->findEnabledPlantsQuery($filters);

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

    //Ajout de plante pour l'utilisateur
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

        // Récupération de l'entité Plants
        $plant = $this->em->getRepository(Plants::class)->find($plantId);
        if (!$plant) {
            $this->addFlash('danger', 'La plante n\'existe pas.');
            return $this->redirectToRoute('users.plantarium');
        }

        // Vérification de la présence de l'entité UserPlants. Si non, création de cette entité
        $userPlant = $this->em->getRepository(UserPlants::class)->findOneBy(['User' => $user]);

        if ($userPlant === null) {
            $userPlant = new UserPlants();
            $userPlant->setUser($user);
            $userPlant->setPlant($plant);
            $this->em->persist($userPlant);
        }

        // Création de l'entité
        $plantDetail = new PlantDetail();
        $plantDetail->setUserPlants($userPlant); // synchronisation de l'entité existante
        $plantDetail->setPlant($plant);
        $this->em->persist($plantDetail);

        $this->em->flush();

        // Récupération et pagination
        $plants = $this->plantsRepository->findAll();
        $pagination = $paginator->paginate($plants, $page, 6);

        $this->addFlash('success', 'Votre plante a bien été ajoutée.');
        return $this->redirectToRoute('users.plantarium');
    }

}
