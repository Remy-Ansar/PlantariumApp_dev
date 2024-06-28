<?php

namespace App\Controller\Backend;

use App\Entity\Plants;
use App\Form\PlantsType;
use App\Entity\Trait\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\PlantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/editor/plants', name: 'editor.plants')]
class PlantsController extends AbstractController
{

    public function __construct(

        private readonly EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Plants/index.html.twig', [
            'plants' => 'PlantsController',
        ]);
    }

    #[Route('/new', name: '.new', methods:['GET', 'POST'])]
    public function newPlant(Request $request): Response
    {
        $plant = new Plants();
        $form = $this->createForm(PlantsType::class, $plant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($plant);
            $this->em->flush();

            $this->addFlash('success', 'La plante a bien été ajoutée.');

            return $this->redirectToRoute('editor.plants.index');
        }

        return $this->render('Backend/Plants/new.html.twig', [
            'plant' => $plant,
            'form' => $form,
        ]);
    }

    
}
