<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Users;
use App\Entity\Plants;
use App\Entity\Species;
use App\Entity\Weather;
use App\Entity\Diseases;
use App\Entity\Families;
use App\Entity\Warnings;
use App\Entity\Watering;
use App\Entity\UserInfos;
use App\Entity\UserPlants;
use App\Entity\HealthStatus;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CategoriesFixtures;
use App\Validator\Constraints\Uppercase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Providers\PlantsProvider;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        PlantsProvider $plantsProvider // Injection du provider
    ) {
        $this->faker = Factory::create('fr_FR');
        $this->plantsProvider = $plantsProvider; // Initialisation du provider
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
        $manager->persist($user);
        
        $userInfos = (new UserInfos)
            ->setFirstName('Remy')
            ->setLastName('Ansar')
            ->setLevel('Débutant');

        $user->setUserInfos($userInfos);
        $userInfos->setUsers($user);

        $manager->persist($userInfos);

        // // Fixture pour les utilisateurs
        // for ($i = 0; $i < 10; $i++) {
        //     $user = (new Users)
        //         ->setEmail($this->faker->unique()->email())
        //         ->setPassword(
        //             $this->hasher->hashPassword(new Users(), 'Test1234!')
        //         )
        //         ->setRoles(
        //             $this->faker->randomElements(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_EDITOR'], 1)
        //         )
        //         ->setCGU(true);
           
        //     $manager->persist($user);

        //     $userInfos = (new UserInfos)
        //         ->setFirstName($this->faker->firstName())
        //         ->setLastName($this->faker->lastName())
        //         ->setLevel($this->faker->randomElement(['Débutant', 'Intermédiaire', 'Expert']));

        //     $user->setUserInfos($userInfos);
        //     $userInfos->setUsers($user);

        //     $manager->persist($userInfos);
        // }

  // Fixtures pour Families
  $families = [];
  $familyNames = [
      'APIACEAE', 'ASTÉRACEAE', 'BRASSICACEAE', 'CARYOPHYLLACEAE',
      'CYPERACEAE', 'FABACEAE', 'LAMIACEAE', 'POACEAE',
      'RENONCULACEAE', 'ROSACEAE', 'ACTINIDIACEAE', 'ADOXACEAE',
      'AGAVACEAE', 'AIZOACEAE', 'AKANIACEAE', 'ALOACEAE',
      'AMARANTHEACEAE', 'BROMELIACEAE', 'CACTACEAE', 'CUCURBITACEAE',
      'GINKGOAACEAE', 'LILIACEAE', 'LAMIACEAE', 'ORCHIDACEAE', 'PASSIFLORACEAE',
      'POACEAE', 'RUTACEAE', 'SOLANACEAE', 'IRIDACEAE', 'ASPARAGACEAE', 'RANUNCULACEAE',
      'ACANATHACEAE', 'CAMPANULACEAE', 'PRIMULACEAE', 'HYDRANGEACEAE', 'NYCTAGINACEAE','TROPAEOLACEAE',
      'PAPAVERACEAE','BIGNONIACEAE', 'NYMPHAEACEAE', 'ONAGRAECEA', 'CAPRIFOLIACEAE', 'PAEONIACEAE', 'AMARYLLIDACEAE'  ];
  
  foreach ($familyNames as $familyName) {
      $family = (new Families())
          ->setName(strtoupper ($familyName));
      $manager->persist($family);
      $families[] = $family;
  }

  // Fixtures pour Species
  $species = [];
  $speciesNames = [
      'Amaranthe', 'Anémone', 'Achilée', 'Choux',
      'Hélianthème', 'Jonc', 'Lys', 'Rose',
      'Valériane', 'Sauge', 'Cumin', 'Origan',
      'Calendula', 'Violette', 'Thym', 'Houx',
      'Luzerne', 'Chanvre', 'Menthe', 'Dipledenia',
      'Astrolomère', 'If', 'Chène', 'Nymphea', 'Mimosa',
      'Jasmin', 'Taraxacum', 'Mauve', 'Héllébore', 'Charme',
      'Marguerite', 'Belle-de-Nuit', 'Platane', 'Badiane',
      'Romarin', 'Marjolaine', 'Basilic', 'Carotte', 'Tournesol',
      'Camomille', 'Valeriane', ''
  ];

  foreach ($speciesNames as $speciesName) {
      $specie = (new Species())
          ->setName($speciesName);
      $manager->persist($specie);
      $species[] = $specie;
  }

  // Fixtures pour Diseases
  $diseases = [];
  $diseasesNames = [
      'Alternariose', 'Mildiou', 'Rouille', 'Acariens',
      'Feu bactérien', 'Marsonia', 'Botrytis', 'Tavelure',
      'Carence en fer'
  ];
  
  $diseaseDescriptions = [
    'Alternariose' => 'Maladie fongique provoquant une scénescence précoce des plantes. Se caractérise par des tâches nécrotiques brunes sur les feuilles.',
    'Mildiou' => 'Maladie cryptogamique. Apparition de plages décolorées et jaunâtres sur la face supérieure. Ainsi que d\'un duvet blanc sur la face inférieure.',
    'Rouille' => 'La rouille est une maladie fongique se caractérisant par des tâches orangées sur la face supérieure.',
    'Acariens' => 'Provoquent une dépigmentation et un affaiblissement général de la plante.',
    'Feu bactérien' => 'La feuille subit un brunissement depuis l\'intérieur. Maladie grave provoquant le plus souvent la mort de la plante.',
    'Marsonia' => 'Maladie cryptogamique. Provoque l\'apparition de tâches circulaires noires sur la feuille.',
    'Botrytis' => 'Maladie fongique provoquant le pourrissement et la boursoufflure des rameaux.',
    'Tavelure' => 'Laisse des tâches foncées avec un aspect velouté et une déformation de la feuille.',
    'Carence en fer' => 'Se caractérise par une décoloration des feuilles, leurs donnant un teint jaune. Causé souvent par la présence de calcaire dans le sol.'
];

foreach ($diseasesNames as $diseasesName) {
    $disease = (new Diseases())
        ->setName($diseasesName)
        ->setDescription($diseaseDescriptions[$diseasesName]); // Ajout de la description
    $manager->persist($disease);
    $diseases[] = $disease;
}
  
    // Fixtures pour HealthStatus
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

$plantNames = [
    'Lys Zephyr ou lys de pluie', 
    'Croix de Jerusalem', 
    'banana cream', 
    'Cosmos chocolat', 
    'Montbrétia', 
    'Rudbeckia pourpre', 
    'White feather', 
    'T-rex', 
    'Marguerite du Cap', 
    'Mystery Day', 
    'Oeillet Chianti', 
    'Oeillet de Poète', 
    'Glaïeul d’Abyssinie', 
    'Pied d’Alouette bleu', 
    'Galahad', 
    'Suzanne-aux-yeux-noirs', 
    'Platycodon', 
    'Astra White', 
    'Nigelle d’Espagne - African Bride', 
    'Cyclamen de Naples', 
    'Cyclamen de Cos', 
    'Seringat Virginal', 
    'Lys Royal', 
    'Belle de Nuit', 
    'Capucine', 
    'Pavot de Californie', 
    'Bignonne à grandes fleurs', 
    'Croix de Malte', 
    'Alaska', 
    'Aurora', 
    'Godétia à fleurs de satin', 
    'Chèvrefeuille - american beauty', 
    'Corail du Mexique', 
    'Pavot Oriental', 
    'Belle of Barmera', 
    'Oeillet Scarlet red', 
    'Pivoine - Big Ben', 
    'Rosier Black Baccarat', 
    'Lis des blés', 
    'Jonquille', 
    'Narcisse des poètes'
];

foreach ($plantNames as $plantName) {
    $plante = new Plants();
    $plante->setName($plantName);
    // Configure les autres propriétés ici, si nécessaire
    $manager->persist($plante);
}


$manager->flush();

            // Création des fixtures pour Weather
            $weatherConditions = [];
            foreach (Weather::getAvailableWeatherConditions() as $condition) {
                $weather = (new Weather())
                    ->setName($condition)
                    ->setDescription($this->faker->sentence());
                $manager->persist($weather);
                $weatherConditions[] = $weather;
            }
    
            // Création des fixtures pour Warnings
            $warningsList = [];
            for ($i = 0; $i < 5; $i++) {
                $warning = (new Warnings())
                    ->setName($this->faker->sentence(3))
                    ->setDescription($this->faker->paragraph())
                    ->setEnable(true)
                    ->setWeather($this->faker->randomElement($weatherConditions));
    
                $manager->persist($warning);
                $warningsList[] = $warning;
            }
    
            // Création des fixtures pour Watering
            $wateringList = [];
            for ($i = 0; $i < 50; $i++) {
                $watering = (new Watering())
                    ->setNote($this->faker->sentence())
                    ->setFrequency($this->faker->numberBetween(1, 7))
                    ->setQuantity($this->faker->randomFloat(2, 0.5, 5))
                    ->setWarnings($this->faker->randomElement($warningsList));
    
                $manager->persist($watering);
                $wateringList[] = $watering;
            }
            

        // Fixture pour ajouter des plantes avec les autres entitées reliées.
        for ($i = 0; $i < 50; $i++) {
            $image = $this->plantsProvider->uploadImage();

            $plant = (new Plants)
                ->setName($this->faker->word())
                ->setDescription($this->faker->sentence(20, true))
                ->setEnable($this->faker->boolean())
                ->setWatering($this->faker->randomElement($wateringList))
                ->setImage($image);
                // ->setHealthStatus($healthStatuses[0]);
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

}