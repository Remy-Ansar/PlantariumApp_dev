<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Users;
use App\Entity\Seasons;
use App\Entity\UserInfos;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(
            private UserPasswordHasherInterface $hasher
    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new Users)
            ->setEmail('admin@test.com')
            ->setPassword(
                $this->hasher->hashPassword(new Users, 'Test1234!')
            )
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        

        $userInfos =(new UserInfos)
        ->setId($user->getId())
        ->setFirstName('Remy')
        ->setLastName('Ansar')
        ->setLevel('Débutant');

        $user->setUserInfos($userInfos);
        $userInfos->setUsers($user);

        $manager->persist($userInfos);


        for ($i = 0; $i < 10; $i++) {
            $user = (new Users)
                ->setEmail($this->faker->unique()->email())
                ->setPassword(
                    $this->hasher->hashPassword(new Users, 'Test1234!'),
                )
                ->setRoles(
                    $this->faker->randomElements(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_EDITOR'])
                );
                

            $manager->persist($user);
        

        
            $userInfos = (new UserInfos)
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setLevel($this->faker->randomElement(['Débutant','Intermédiaire','Expert'])
            );
            $user->setUserInfos($userInfos);
            $userInfos->setUsers($user);

            $manager->persist($userInfos);
        }
            
        // $seasons = (new Seasons)
        // ->setName(['Printemps', 'Eté', 'Automne', 'Hiver']);

        // $manager->persist($seasons);

        $manager->flush();
    }
}