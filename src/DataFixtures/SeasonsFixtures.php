<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Seasons;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SeasonsFixtures extends Fixture
{   
    //liste des saisons utilisables pour les fixtures
    public const SEASONS_REFERENCES = [
        'Printemps' => 'spring',
        'Eté' => 'summer',
        'Automne' => 'autumn',
        'Hiver' => 'winter',
    ];

    //fonction pour ajouter les fixtures liées à la relation MtM entre Seasons et Plants.
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        foreach (self::SEASONS_REFERENCES as $name => $reference) {
            $season = new Seasons();
            $season->setName($name);
            $manager->persist($season);

            $this->addReference($reference, $season);
        }

        $manager->flush();
    }
}