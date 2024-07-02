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


}
