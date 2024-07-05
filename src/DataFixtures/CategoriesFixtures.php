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
        'Plante d\'intérieur' => 'houseplant',
        'Plante d\'extérieur' => 'outsideplant',
        'Plante en serre' => 'greenhouse',
        'Plante exotique' => 'exotic',
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