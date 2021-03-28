<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
/**
 * Permet d'indiquer l'ordre d'exécution des fixtures
 * En effet l'event utilisant un user en clé étrangère
 * Et le commentaire utilisant un user et un event en clé étrangère
 * Il faut que les données s'insèrent dans un ordre précis
 */
class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            EventFixtures::class,
            CommentaireFixtures::class
        ];
    }
}
