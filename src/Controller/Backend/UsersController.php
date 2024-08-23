<?php

namespace App\Controller\Backend;

use App\Entity\Users;

use App\Form\UsersType;
use App\Entity\UserInfos;
use App\Repository\UsersRepository;
use App\Repository\UserInfosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/admin/users', name: 'admin.users')]
class UsersController extends AbstractController
{
    public function __construct(
        private readonly UsersRepository $usersRepository,
        private readonly UserInfosRepository $userInfosRepository,
        private readonly EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
public function index(Request $request, PaginatorInterface $paginator): Response
{
    $session = $request->getSession();
    $page = $request->query->getInt('page', 1);
    $session->set('users_page', $page);

    // Récupération des filtres depuis la requête
    $firstName = $request->query->get('FirstName');
    $lastName = $request->query->get('LastName');

    // Utilisation de la méthode de recherche
    $userInfos = $this->userInfosRepository->findByFullName($firstName, $lastName);

    // Pagination des résultats filtrés
    $pagination = $paginator->paginate(
        $userInfos,
        $page,
        5 // Nombre d'éléments par page
    );

    return $this->render('Backend/Users/index.html.twig', [
        'users' => $this->usersRepository->findAll(),
        'usersInfos' => $userInfos, // Résultats filtrés
        'header' => $this,
        'pagination' => $pagination,
    ]);
}

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Users $users, ?UserInfos $userInfos, Request $request): Response|RedirectResponse
    {
        if (!$users) {
            $this->addFlash('danger', 'Cet utilisateur est introuvable.');

            return $this->redirectToRoute('admin.users.index');
        }

        $form = $this->createForm(UsersType::class, $users, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($users, $userInfos);
            $this->em->flush();

            $this->addFlash('success', 'L\'utilisateur a été modifié avec succès');

            return $this->redirectToRoute('admin.users.index');
        }

        return $this->render('Backend/Users/edit.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Users $users, ?UserInfos $userInfos, Request $request): RedirectResponse
    {
        if (!$users){
            $this->addFlash('danger', 'Cet utilisateur est introuvable.' );

            return $this->redirectToRoute('admin.users.index');
        }

        if ($this->isCsrfTokenValid('delete' . $users->getId(), $request->request->get('token'))) {
            $this->em->remove($users);
            $this->em->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');
        } else {
            $this->addFlash('danger', 'Le token CSRF est invalide.');
        }

        return $this->redirectToRoute('admin.users.index');
    }
}
