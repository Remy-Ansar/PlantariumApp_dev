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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/editor/plants', name: 'editor.plants')]
class PlantsController extends AbstractController
{

    public function __construct(

        private readonly EntityManagerInterface $em,
        private readonly PlantsRepository $plantsRepository,
        private readonly FamiliesRepository $familiesRepository
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Plants/index.html.twig', [
            'plants' => $this->plantsRepository->findAll(),
            'family' => $this->familiesRepository->findAll()
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
public function plantEdit(Request $request, Plants $plant, EntityManagerInterface $em): Response
{
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

        // Handle removal of Seasons
        foreach ($originalSeasons as $season) {
            if (!$plant->getSeasons()->contains($season)) {
                $season->removePlant($plant);
                $em->persist($season);
            }
        }

        // Handle removal of Colors
        foreach ($originalColors as $color) {
            if (!$plant->getColors()->contains($color)) {
                $color->removePlant($plant);
                $em->persist($color);
            }
        }

        // Handle removal of Categories
        foreach ($originalCategories as $category) {
            if (!$plant->getCategories()->contains($category)) {
                $category->removePlant($plant);
                $em->persist($category);
            }
        }

        // Handle addition of Seasons
        foreach ($plant->getSeasons() as $season) {
            if (!$originalSeasons->contains($season)) {
                $season->addPlant($plant);
                $em->persist($season);
            }
        }

        // Handle addition of Colors
        foreach ($plant->getColors() as $color) {
            if (!$originalColors->contains($color)) {
                $color->addPlant($plant);
                $em->persist($color);
            }
        }

        // Handle addition of Categories
        foreach ($plant->getCategories() as $category) {
            if (!$originalCategories->contains($category)) {
                $category->addPlant($plant);
                $em->persist($category);
            }
        }

        $em->persist($plant);
        $em->flush();

        $this->addFlash('success', 'La plante a été modifiée avec succès.');

        return $this->redirectToRoute('editor.plants.index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('Backend/Plants/edit.html.twig', [
        'plants' => $plant,
        'form' => $form,
    ]);
}

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function deletePlant(?Plants $plant, Request $request): RedirectResponse
    {
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
}
