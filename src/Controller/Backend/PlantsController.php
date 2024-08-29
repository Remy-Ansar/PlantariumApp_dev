<?php

namespace App\Controller\Backend;

use App\Entity\Colors;
use App\Entity\Plants;
use App\Entity\Seasons;
use App\Entity\Species;
use App\Entity\Families;
use App\Form\FieldsType;
use App\Form\PlantsType;
use App\Entity\Categories;
use App\Entity\UserPlants;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\Trait\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\PlantsRepository;
use App\Repository\FamiliesRepository;
use App\Repository\SpeciesRepository;
use App\Repository\ColorsRepository;
use App\Repository\SeasonsRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/editor/plants', name: 'editor.plants')]
class PlantsController extends AbstractController
{

    private $plantsRepository;
    private $speciesRepository;
    private $familiesRepository;
    private $colorsRepository;
    private $seasonsRepository;
    private $categoriesRepository;

    public function __construct(
        PlantsRepository $plantsRepository,
        SpeciesRepository $speciesRepository,
        FamiliesRepository $familiesRepository,
        ColorsRepository $colorsRepository,
        SeasonsRepository $seasonsRepository,
        CategoriesRepository $categoriesRepository
    ) {
        $this->plantsRepository = $plantsRepository;
        $this->speciesRepository = $speciesRepository;
        $this->familiesRepository = $familiesRepository;
        $this->colorsRepository = $colorsRepository;
        $this->seasonsRepository = $seasonsRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator): Response
{
    $session = $request->getSession();
    $page = $request->query->getInt('page', 1);
    $session->set('plants_page', $page);

    // Récupération des filtres depuis la requête
    $filters = $request->query->all();

    // Initialisation de la variable $plants
    $plants = [];

    // Application des filtres
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
        $plants = $this->plantsRepository->findAll(); // Afficher toutes les plantes si aucun filtre n'est appliqué
    }

    // Pagination des résultats filtrés
    $pagination = $paginator->paginate(
        $plants,
        $page,
        5
    );

    // Récupération des valeurs nécessaires pour les filtres
    $species = $this->speciesRepository->findAll();
    $families = $this->familiesRepository->findAll();
    $colors = $this->colorsRepository->findAll();
    $seasons = $this->seasonsRepository->findAll();
    $categories = $this->categoriesRepository->findAll();

    return $this->render('Backend/Plants/index.html.twig', [
        'pagination' => $pagination,
        'species' => $species,
        'families' => $families,
        'colors' => $colors,
        'seasons' => $seasons,
        'categories' => $categories,
    ]);
}


    #[Route('/new', name: '.new', methods: ['GET', 'POST'])]
    public function newPlant(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    {
        $plant = new Plants();
        $form = $this->createForm(PlantsType::class, $plant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($plant->getSeasons() as $season) {
                $season->addPlant($plant);
                $em->persist($season);
            }

            foreach ($plant->getColors() as $color) {
                $color->addPlant($plant);
                $em->persist($color);
            }

            foreach ($plant->getCategories() as $categorie) {
                $categorie->addPlant($plant);
                $em->persist($categorie);
            }

            $em->persist($plant);
            $em->flush();

            $this->addFlash('success', 'La plante a bien été ajoutée.');

            return $this->redirectToRoute('editor.plants.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Plants/new.html.twig', [
            'plant' => $plant,
            'form' => $form,
        ]);
    }

    #[Route('/new/field', name: '.new.field', methods: ['GET', 'POST'])]
    public function newField(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    {
        $specie = new Species();
        $family = new Families();
        $color = new Colors();

        $form = $this->createForm(FieldsType::class, [
            'species' => $specie,
            'families' => $family,
            'colors' => $color,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($specie);
            $em->persist($family);
            $em->persist($color);

            $em->flush();

            $this->addFlash('success', 'Les nouveautées ont bien été ajoutées.');

            return $this->redirectToRoute('editor.plants.index', [], Response::HTTP_SEE_OTHER);
        } else {
            // Debugging output for invalid form
            dump($form->getErrors(true, false));
        }

        return $this->render('Backend/Plants/newfield.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
public function plantEdit(Request $request, Plants $plant, EntityManagerInterface $em, PaginatorInterface $paginator): Response
{
    $session = $request->getSession();
    $page = $session->get('plants_page', 1);

    if (!$plant) {
        $this->addFlash('danger', 'Cette plante est introuvable. Êtes-vous certain de son id?');

        return $this->redirectToRoute('editor.plants.index');
    }

    // Fetch original collections
    $originalSeasons = new ArrayCollection($plant->getSeasons()->toArray());
    $originalColors = new ArrayCollection($plant->getColors()->toArray());
    $originalCategories = new ArrayCollection($plant->getCategories()->toArray());

    $form = $this->createForm(PlantsType::class, $plant);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        foreach ($originalSeasons as $season) {
            if (!$plant->getSeasons()->contains($season)) {
                $season->removePlant($plant);
                $em->persist($season);
            }
        }

        foreach ($originalColors as $color) {
            if (!$plant->getColors()->contains($color)) {
                $color->removePlant($plant);
                $em->persist($color);
            }
        }

        foreach ($originalCategories as $category) {
            if (!$plant->getCategories()->contains($category)) {
                $category->removePlant($plant);
                $em->persist($category);
            }
        }

        foreach ($plant->getSeasons() as $season) {
            if (!$originalSeasons->contains($season)) {
                $season->addPlant($plant);
                $em->persist($season);
            }
        }

        foreach ($plant->getColors() as $color) {
            if (!$originalColors->contains($color)) {
                $color->addPlant($plant);
                $em->persist($color);
            }
        }

        foreach ($plant->getCategories() as $category) {
            if (!$originalCategories->contains($category)) {
                $category->addPlant($plant);
                $em->persist($category);
            }
        }

        $em->persist($plant);
        $em->flush();

        $this->addFlash('success', 'La plante a été modifiée avec succès.');

        return $this->redirectToRoute('editor.plants.index', ['page' => $page], Response::HTTP_SEE_OTHER);
    }

    // Récupérer toutes les plantes pour la pagination
    $plants = $this->plantsRepository->findAll(); 

    $pagination = $paginator->paginate(
        $plants,
        $page,
        5
    );

    return $this->render('Backend/Plants/edit.html.twig', [
        'plants' => $plant,
        'form' => $form,
        'pagination' => $pagination,
    ]);
}

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function deletePlant(?Plants $plant, Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $page = $session->get('plants_page', 1);

        if (!$plant) {
            $this->addFlash('danger', 'Cette plante est introuvable. Êtes-vous certain de son identification?');

            return $this->redirectToRoute('editor.plants.index');
        }

        if ($this->isCsrfTokenValid('delete' . $plant->getId(), $request->request->get('token'))) {
            $this->em->remove($plant);
            $this->em->flush();

            $this->addFlash('success', 'La plante a été supprimée avec succès.');
        } else {
            $this->addFlash('danger', 'Le token CSRF est invalide.');
        }

        return $this->redirectToRoute('editor.plants.index');
    }

    #[Route('/{name}/details', name: '.showPlant', methods: ['GET', 'POST'])]
    public function showPlant(string $name): Response | RedirectResponse
    {
        $plant = $this->plantsRepository->findOneBy(['Name' => $name]);

        if (!$plant) {
            $this->addFlash('error', 'Cette plante n\'existe pas');

            return $this->redirectToRoute('editor.plants.index');
        }

        return $this->render('Backend/Plants/showPlant.html.twig', [
            'plant' => $plant,
        ]);
    }

    #[Route('/{id}/switch', name: '.switch', methods: ['POST'])]
public function togglePlant(int $id, PlantsRepository $plantsRepository, EntityManagerInterface $entityManager): JsonResponse
{
    $plant = $entityManager->getRepository(Plants::class)->find($id);

    if (!$plant) {
        return new JsonResponse(['success' => false, 'message' => 'Plant not found'], 404);
    }

    // Inverse la valeur du champ 'enable'
    $plant->setEnable(!$plant->getEnable());

    // Sauvegarde les modifications
    $entityManager->flush();

    return new JsonResponse(['success' => true, 'enabled' => $plant->getEnable()]);
}

}
