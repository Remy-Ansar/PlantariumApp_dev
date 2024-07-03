<?php

namespace App\Controller\Backend;

use App\Entity\Categories;
use App\Entity\Colors;
use App\Entity\Families;
use App\Entity\Plants;
use App\Entity\Seasons;
use App\Entity\Species;
use App\Form\PlantsType;
use App\Entity\Trait\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Entity\UserPlants;
use App\Repository\FamiliesRepository;
use App\Repository\PlantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/editor/plants', name: 'editor.plants')]
class PlantsController extends AbstractController
{

    public function __construct(

        private readonly EntityManagerInterface $em,
        private readonly PlantsRepository $plantsRepository,
        private readonly FamiliesRepository $familiesRepository
    ) {
    }

    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Plants/index.html.twig', [
            'plants' => $this->plantsRepository->findAll(),
            'family' => $this->familiesRepository->findAll()
        ]);
    }

    #[Route('/new', name: '.new', methods:['GET', 'POST'])]
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

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function plantEdit(Request $request, Plants $plant, EntityManagerInterface $em): Response
    {
        if (!$plant) {
            $this->addFlash('danger', 'Cette plante est introuvable. Êtes-vous certain de son id?');

            return $this->redirectToRoute('editor.plants.index');
        }

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
            $this->addFlash('danger', 'Cette plante est introuvable. Êtes-vous certain de son id?');

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


}
