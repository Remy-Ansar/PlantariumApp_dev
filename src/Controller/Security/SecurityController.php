<?php

namespace App\Controller\Security;

use App\Entity\Users;
use App\Entity\UserInfos;
use App\Form\ProfileType;
use App\Entity\UserPlants;
use App\Form\InscriptionType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private readonly EntityManagerInterface $em,
        private readonly UsersRepository $usersRepository
    ) {
    }


    #[Route('/home', name: 'app.home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('Security/home.html.twig');
    }

    

    #[Route('/connexion', name: 'app.connexion', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authUtils): Response
    {
        // Utilisez le service de sécurité pour obtenir l'utilisateur authentifié
        $user = $this->getUser();
        
    // If the user is already logged in, redirect them to the target route
        if ($this->getUser()) {
            return $this->redirectToRoute('users.userPlants.index');
    }

        return $this->render('Security/connexion.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'lastUsername' => $authUtils->getLastUsername(),
        ]);
    }

    #[Route('/inscription', name: 'app.inscription', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $users = new Users();

        $form = $this->createForm(InscriptionType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users->setPassword(
                $this->hasher->hashPassword($users, $form->get('password')->getData())
            );
            //Création d'une nouvelle entité UserPlants associée au user
            $userPlants = new UserPlants();
            $userPlants->setUser($users);
            $em->persist($userPlants);
            
            $em->persist($users);
            $em->flush();
            $userId =$request->getSession()->set('user.id', $users->getId());

            $this->addFlash('success', 'Votre compte a bien été créé.');
        // dd($userId);
            return $this->redirectToRoute('app.profile', ['users'=>$users->getId()] );
        }

        return $this->render('Security/inscription.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/inscription/profile', name: 'app.profile', methods: ['GET', 'POST'])]
    public function profile(Request $request): Response
    {
        // Deuxième étape : Compléter le profil avec UserInfos entity et ProfileType form
        $userId = $request->getSession()->get('user.id');
        $users = $this->em->getRepository(Users::class)->find($userId);
        
 
        // dd($users, $userId);

        $userInfos = new UserInfos();
        $form = $this->createForm(ProfileType::class, $userInfos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Compléter l'enregistrement du profil (UserInfos entity)
            $userInfos->setUsers($users);
            $this->em->persist($userInfos);
            $this->em->flush();

            // Rediriger vers la page d'accueil après inscription réussie
            return $this->redirectToRoute('app.connexion');
        }
        

        return $this->render('Security/profil.html.twig', [
            'form' => $form
        ]);
    }


}
