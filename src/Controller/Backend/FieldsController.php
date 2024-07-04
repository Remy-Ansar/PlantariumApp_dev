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
use App\Form\FamiliesType;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\Trait\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Form\ColorsType;
use App\Form\SpeciesType;
use App\Repository\ColorsRepository;
use App\Repository\PlantsRepository;
use App\Repository\SeasonsRepository;
use App\Repository\SpeciesRepository;
use App\Repository\FamiliesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

#[Route('/editor/plants/field', name: 'editor.plants.field')]

class FieldsController extends AbstractController
{

    public function __construct(

        private readonly EntityManagerInterface $em,
        private readonly PlantsRepository $plantsRepository,
        private readonly FamiliesRepository $familiesRepository,
        private readonly SpeciesRepository $speciesRepository,
        private readonly ColorsRepository $colorsRepository,
        private readonly CategoriesRepository $categoriesRepository,
        private readonly SeasonsRepository $seasonsRepository
    ) {
    }

    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Plants/Fields/index.html.twig', [
            'plants' => $this->plantsRepository->findAll(),
            'families' => $this->familiesRepository->findAll(),
            'species' => $this->speciesRepository->findAll(),
            'colors' => $this->colorsRepository->findAll(),
        ]);
    }

    // #[Route('/new', name: '.new', methods:['GET', 'POST'])]
    // public function newField(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    // {
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

    //         $em->persist($specie);
    //         $em->persist($family);
    //         $em->persist($color);

    //         $em->flush();

    //         $this->addFlash('success', 'Les nouveautées ont bien été ajoutées.');

    //         return $this->redirectToRoute('editor.plants.index', [], Response::HTTP_SEE_OTHER);
    //     } else {
    //         // Debugging output for invalid form
    //         dump($form->getErrors(true, false));
    //     }
        
    //     return $this->render('Backend/Plants/Fields/newfield.html.twig', [
    //         'form' => $form,
    //     ]);
    //  }     

    //Nouveaux champs 

    #[Route('/family/new', name: '.family.new', methods:['GET', 'POST'])]
    public function newFamily(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    {

        $family = new Families();

        $form = $this->createForm(FamiliesType::class, [
            'families' => $family,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($family);
            $em->flush();

            $this->addFlash('success', 'Les nouveautées ont bien été ajoutées.');

            return $this->redirectToRoute('editor.plants.field.index', [], Response::HTTP_SEE_OTHER);
        } else {
            // Debugging output for invalid form
            dump($form->getErrors(true, false));
        }
        
        return $this->render('Backend/Plants/Fields/newColor.html.twig', [
            'form' => $form,
        ]);
    } 

    #[Route('/species/new', name: '.specie.new', methods:['GET', 'POST'])]
    public function newSpecie(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    {

        $specie = new Species();

        $form = $this->createForm(SpeciesType::class, [
            'species' => $specie,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($specie);
            $em->flush();

            $this->addFlash('success', 'Les nouveautées ont bien été ajoutées.');

            return $this->redirectToRoute('editor.plants.field.index', [], Response::HTTP_SEE_OTHER);
        } else {
            // Debugging output for invalid form
            dump($form->getErrors(true, false));
        }
        
        return $this->render('Backend/Plants/Fields/newColor.html.twig', [
            'form' => $form,
        ]);
    } 

    #[Route('/color/new', name: '.color.new', methods:['GET', 'POST'])]
    public function newColor(EntityManagerInterface $em, Request $request): Response | RedirectResponse
    {
        $color = new Colors();

        $form = $this->createForm(ColorType::class, [
            'colors' => $color,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($color);
            $em->flush();

            $this->addFlash('success', 'Les nouveautées ont bien été ajoutées.');

            return $this->redirectToRoute('editor.plants.field.index', [], Response::HTTP_SEE_OTHER);
        } else {
            // Debugging output for invalid form
            dump($form->getErrors(true, false));
        }
        
        return $this->render('Backend/Plants/Fields/newColor.html.twig', [
            'form' => $form,
        ]);
    }
    
    //edition des champs 

    #[Route('/family/{name}/edit', name: '.family.edit', methods: ['GET', 'POST'])]
    public function EditFamily(Request $request, string $name): Response
    {
        $family = $this->familiesRepository->findOneByName($name);
        if (!$family) {
            $this->addFlash('danger', 'Cette famille de plante n\'existe pas.');

            return $this->redirectToRoute('editor.plants.field');
        }

        $form = $this->createForm(FamiliesType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'La famille a été modifiée avec succès.');
            
            return $this->redirectToRoute('editor.plants.field.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Plants/Fields/editFamily.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/specie/{name}/edit', name: '.specie.edit', methods: ['GET', 'POST'])]
    public function EditSpecie(Request $request, string $name): Response
    {
        $specie = $this->speciesRepository->findOneByName($name);
        if (!$specie) {
            $this->addFlash('danger', 'Cette espèce de plante n\'existe pas.');

            return $this->redirectToRoute('editor.plants.field');
        }

        $form = $this->createForm(SpeciesType::class, $specie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'L\'espèce a été modifiée avec succès.');
            
            return $this->redirectToRoute('editor.plants.field.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Plants/Fields/editSpecie.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/color/{name}/edit', name: '.color.edit', methods: ['GET', 'POST'])]
    public function EditColor(Request $request, string $name): Response
    {
        $color = $this->colorsRepository->findOneByName($name);
        if (!$color) {
            $this->addFlash('danger', 'Cette couleur de plante n\'existe pas.');

            return $this->redirectToRoute('editor.plants.field');
        }

        $form = $this->createForm(ColorsType::class, $color);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'La couleur a été modifiée avec succès.');
            
            return $this->redirectToRoute('editor.plants.field.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Plants/Fields/editColor.html.twig', [
            'form' => $form,
        ]);
    }

}
