<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Colors;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ColorFixtures extends Fixture
{   
    //liste des couleurs utilisables pour les fixtures
    public const COLOR_REFERENCES = [
        'Rouge' => 'red',
        'Vert' => 'green',
        'Bleu' => 'blue',
        'Jaune' => 'yellow',
        'Blanc' => 'white',
        'Noir' => 'black',
        'Orange' => 'orange',
        'Violet' => 'purple',
        'Rose' => 'Pink'
    ];

    //fonction pour ajouter les fixtures liées à la relation MtM entre Colors et Plants.
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        foreach (self::COLOR_REFERENCES as $name => $reference) {
            $color = new Colors();
            $color->setName($name);
            $manager->persist($color);

            $this->addReference($reference, $color);
        }

        $manager->flush();
    }
}