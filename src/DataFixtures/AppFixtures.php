<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Users;
use App\Entity\Plants;
use App\Entity\Seasons;
use App\Entity\UserInfos;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CategoriesFixtures;
use App\Entity\Families;
use App\Entity\Species;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Fixture for admin user
        $user = (new Users)
            ->setEmail('admin@test.com')
            ->setPassword(
                $this->hasher->hashPassword(new Users(), 'Test1234!')
            )
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $userInfos = (new UserInfos)
            ->setFirstName('Remy')
            ->setLastName('Ansar')
            ->setLevel('Débutant');

        $user->setUserInfos($userInfos);
        $userInfos->setUsers($user);

        $manager->persist($userInfos);

        // Fixture for regular users
        for ($i = 0; $i < 10; $i++) {
            $user = (new Users)
                ->setEmail($this->faker->unique()->email())
                ->setPassword(
                    $this->hasher->hashPassword(new Users(), 'Test1234!')
                )
                ->setRoles(
                    $this->faker->randomElements(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_EDITOR'], 1)
                );

            $manager->persist($user);

            $userInfos = (new UserInfos)
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setLevel($this->faker->randomElement(['Débutant', 'Intermédiaire', 'Expert']));

            $user->setUserInfos($userInfos);
            $userInfos->setUsers($user);

            $manager->persist($userInfos);
        }

        // // Fixtures pour les familles de plantes
        // $familyArray =  [
        //     'APIACÉES','ASTÉRACÉES',
        //     'BRASSICACÉES','CARYOPHYLLACÉES',
        //     'CYPERACÉES','FABACÉES',
        //     'LAMIACÉES','POACÉES',
        //     'RENONCULACÉES','ROSACÉES'
        // ];
        
        // foreach ($familyArray as $familyName)
        // {
        //     $family = (new Families)
        //         ->setName($familyName);

        //     $manager->persist($family);

        //     $family[] = $family;
        // }

        // // Fixtures pour les espèces de plantes
        // $speciesArray = [
        //     'Amaranthe','Anémone',
        //     'Achilée','Choux',
        //     'Hélianthème','Jonc',
        //     'Lys','Rose',
        //     'Valériane','Sauge'
        // ];

        // foreach ($speciesArray as $specieName)
        // {
        //     $specie = (new Species)
        //         ->setName($specieName);

        //     $manager->persist($specie);

        //     $specie[] = $specie;
        // }

        // Fixture pour ajouter des plantes avec les autres entitées reliées.
        for ($i = 0; $i < 10; $i++) {
            $plant = (new Plants)
                ->setName($this->faker->word())
                ->setDescription($this->faker->sentence(20, true))
                ->setEnable($this->faker->boolean);
                
                
            $family = (new Families)
                ->setName($this->faker->randomElement(
                    [
                        'APIACÉES','ASTÉRACÉES','BRASSICACÉES','CARYOPHYLLACÉES',
                        'CYPERACÉES','FABACÉES',
                        'LAMIACÉES','POACÉES',
                        'RENONCULACÉES','ROSACÉES'
                    ]));
                    $manager->persist($family);

                ->setFamilies($this->faker->randomElement($family));
                // ->setSpecies($this->faker->randomElement(
                //     [
                //         'Amaranthe','Anémone',
                //         'Achilée','Choux',
                //         'Hélianthème','Jonc',
                //         'Lys','Rose',
                //         'Valériane','Sauge'
                //     ]));
            // Pour ajouter une ou des couleurs aléatoire aux plantes.
            $randomColors = $this->faker->randomElements(array_values(ColorFixtures::COLOR_REFERENCES), $this->faker->numberBetween(1, 4));
            foreach ($randomColors as $colorReference) {
                $color = $this->getReference($colorReference);
                $plant->addColor($color);
            }
            // Pour ajouter une ou des saisons aléatoire aux plantes.
            $randomSeasons = $this->faker->randomElements(array_values(SeasonsFixtures::SEASONS_REFERENCES), $this->faker->numberBetween(1, 3));
            foreach ($randomSeasons as $seasonReference) {
                $season = $this->getReference($seasonReference);
                $plant->addSeason($season);
            }
            // Pour ajouter une ou des saisons aléatoire aux plantes.
            $randomCategory = $this->faker->randomElements(array_values(CategoriesFixtures::CATEGORIES_REFERENCES), $this->faker->numberBetween(1, 2));
            foreach ($randomCategory as $categoryReference) {
                $category = $this->getReference($categoryReference);
                $plant->addCategory($category);
            }
            
    



            $manager->persist($plant);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ColorFixtures::class,
            SeasonsFixtures::class,
            CategoriesFixtures::class,
        ];
    }
}