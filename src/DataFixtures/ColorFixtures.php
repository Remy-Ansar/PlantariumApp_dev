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
        'red' => 'Rouge',
        'green' => 'Vert',
        'blue' => 'Bleu',
        'yellow' => 'Jaune',
        'white' => 'Blanc',
        'black' => 'Noir',
        'orange' => 'orange',
        'purple' => 'violet', 
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