<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture
{   
    //liste des couleurs utilisables pour les fixtures
    public const CATEGORIES_REFERENCES = [
        null => null,
        'houseplant' => 'Plante d\'intérieur',
        'outsideplant' => 'Plante d\'extérieur',
        'greenhousePlante en serre' => 'Plante en serre',
        'exotic' => 'Plante exotique',
    ];

    //fonction pour ajouter les fixtures liées à la relation MtM entre Colors et Plants.
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        foreach (self::CATEGORIES_REFERENCES as $name => $reference) {
            $cleanName = str_replace('-', '', $name);

            $categorie = new Categories();
            $categorie->setName($name);
            $manager->persist($categorie);

            $this->addReference($reference, $categorie);
        }

        $manager->flush();
    }
}