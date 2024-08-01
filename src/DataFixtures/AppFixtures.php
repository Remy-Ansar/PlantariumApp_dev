<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Users;
use App\Entity\Plants;
use App\Entity\Species;
use App\Entity\Families;
use App\Entity\UserInfos;
use App\Entity\UserPlants;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CategoriesFixtures;
use App\Entity\Diseases;
use App\Entity\HealthStatus;
use App\Validator\Constraints\Uppercase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            ->setRoles(['ROLE_ADMIN'])
            ->setCGU(true);
        // $userPlant = new UserPlants();
        // $userPlant->setUser($user);
        $manager->persist($user);
        // $manager->persist($userPlant);
        
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
                )
                ->setCGU(true);
           
            $manager->persist($user);


            $userInfos = (new UserInfos)
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setLevel($this->faker->randomElement(['Débutant', 'Intermédiaire', 'Expert']));

            $user->setUserInfos($userInfos);
            $userInfos->setUsers($user);

            $manager->persist($userInfos);
        }

  // Fixtures for Families
  $families = [];
  $familyNames = [
      'APIACÉES', 'ASTÉRACÉES', 'BRASSICACÉES', 'CARYOPHYLLACÉES',
      'CYPERACÉES', 'FABACÉES', 'LAMIACÉES', 'POACÉES',
      'RENONCULACÉES', 'ROSACÉES'
  ];
  
  foreach ($familyNames as $familyName) {
      $family = (new Families())
          ->setName(strtoupper ($familyName));
      $manager->persist($family);
      $families[] = $family;
  }

  // Fixtures for Species
  $species = [];
  $speciesNames = [
      'Amaranthe', 'Anémone', 'Achilée', 'Choux',
      'Hélianthème', 'Jonc', 'Lys', 'Rose',
      'Valériane', 'Sauge'
  ];

  foreach ($speciesNames as $speciesName) {
      $specie = (new Species())
          ->setName($speciesName);
      $manager->persist($specie);
      $species[] = $specie;
  }

  // Fixtures for Diseases
  $diseases = [];
  $diseasesNames = [
      '', 'Alternariose', 'Mildiou', 'Rouille', 'Acariens',
      'Feu bactérien ', 'Marsonia', 'Botrytis', 'Tavelure',
      'Carence en fer '
  ];

  foreach ($diseasesNames as $diseasesName) {
    $disease = (new Diseases())
        ->setName($diseasesName);
    $manager->persist($disease);
    $diseases[] = $disease; // Add the disease to the array
  }
    // Fixtures for HealthStatus
    $healthStatuses = [];
    $healthStatusNames = [
        'En bonne santé', 'Malade', 'Morte'
    ];

    foreach ($healthStatusNames as $healthStatusName) {
    $healthStatus = (new HealthStatus())
        ->setName($healthStatusName);
    $manager->persist($healthStatus);
    $healthStatuses[] = $healthStatus;

}

$manager->flush();

        // Fixture pour ajouter des plantes avec les autres entitées reliées.
        for ($i = 0; $i < 10; $i++) {
            $plant = (new Plants)
                ->setName($this->faker->word())
                ->setDescription($this->faker->sentence(20, true))
                ->setEnable($this->faker->boolean);
                // ->setImage($this->uploadImage());
                 // Set random Family
            $plant->setFamilies($this->faker->randomElement($families));

            // Set random Species
            $plant->setSpecies($this->faker->randomElement($species));
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

    // private function uploadImage(): UploadedFile
    // {
    //     $files = glob(__DIR__ . '/images/Plant/*.*');

    //     $index = array_rand($files);

    //     $file = new File($files[$index]);
    //     $file = new UploadedFile($file, $file->getFilename());

    //     return $file;
    // }
}