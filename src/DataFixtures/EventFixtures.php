<?php 

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager) : void 
    {
        $Event1=new Event();
        $date2 = "22-04-2022";
        $Event1->setNom('Activite1')
        ->setType('Cinema')
        ->setLieux('Nantes')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setDescription('Petite activite');
        $manager->persist($Event1);

        $Event2=new Event();
        $date2 = "22-04-2022";
        $Event2->setNom('Activite2')
        ->setType('Cinema')
        ->setLieux('Nantes')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setDescription('Petite activite');
        $manager->persist($Event2);

        $Event3=new Event();
        $date2 = "22-04-2022";
        $Event3->setNom('Activite3')
        ->setType('Sport')
        ->setLieux('Paris')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setDescription('Petite activite');
        $manager->persist($Event3);

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
    
}