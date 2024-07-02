<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Faker\Factory;
use App\Entity\Colors;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture
{   
    //liste des couleurs utilisables pour les fixtures
    public const CATEGORIES_REFERENCES = [
        'housePlants' => 'Plante d\'intérieur',
        'outsidePlants' => 'Plante d\'extérieur',
        'greenhouse' => 'Plante en serre',
        'exotic' => 'Plante exotique',
    ];

    //fonction pour ajouter les fixtures liées à la relation MtM entre Colors et Plants.
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        foreach (self::CATEGORIES_REFERENCES as $name => $reference) {
            $categorie = new Categories();
            $categorie->setName($name);
            $manager->persist($categorie);

            $this->addReference($reference, $categorie);
        }

        $manager->flush();
    }
}