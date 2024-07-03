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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/editor/plants/field', name: 'editor.plants.field')]
class FieldsController extends AbstractController
{

    public function __construct(

        private readonly EntityManagerInterface $em,
        private readonly PlantsRepository $plantsRepository,
        private readonly FamiliesRepository $familiesRepository
    ) {
    }

    // #[Route('', name: '.index', methods:['GET'])]
    // public function index(): Response
    // {
    //     return $this->render('Backend/Plants/index.html.twig', [
    //         'plants' => $this->plantsRepository->findAll(),
    //         'family' => $this->familiesRepository->findAll()
    //     ]);
    // }


    #[Route('/new', name: '.new', methods:['GET', 'POST'])]
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
        
        return $this->render('Backend/Plants/Fields/newfield.html.twig', [
            'form' => $form,
        ]);
     }     
    
    // #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    // public function plantEdit(Request $request, EntityManagerInterface $em): Response
    // {
    //     if (!$plant) {
    //         $this->addFlash('danger', 'Ce champs est introuvable. Êtes-vous certain de son id?');

    //         return $this->redirectToRoute('editor.plants.index');
    //     }

    //     $specie = new Species();
    //     $family = new Families();
    //     $color = new Colors();


    //     $form = $this->createForm(FieldsType::class, [
    //         'species' => $specie,
    //         'families' => $family,
    //         'colors' => $color,
    //     ]);
    //     $form->handleRequest($request);
        
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em->flush();

    //         $this->addFlash('success', 'Le champs a été modifiée avec succès.');

    //         return $this->redirectToRoute('editor.plants.index', [], Response::HTTP_SEE_OTHER);
    //     }
    
    //     return $this->render('Backend/Plants/Fields/edit.html.twig',[
    //         'form' => $form,
    //     ]);
    // }

}
