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
        $date1 = "23-04-2022";
        $Event1->setNom('Sortie Shutter Island')
        ->setType('Cinema')
        ->setLieux('Nantes')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date1))
        ->setDescription('Sortie cinema pour la sortie de ce chef d oeuvre');
        $manager->persist($Event1);

        $Event2=new Event();
        $date2 = "22-04-2022";
        $Event2->setNom('Sortie Inception')
        ->setType('Cinema')
        ->setLieux('Pornic')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setDescription('re edition de ce classique avec Di Caprio');
        $manager->persist($Event2);

        $Event3=new Event();
        $date3 = "22-04-2022";
        $Event3->setNom('Marathon De paris')
        ->setType('Sport')
        ->setLieux('Paris')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date3))
        ->setDescription('Ramenez vos basket et votre energie !');
        $manager->persist($Event3);

        $Event4=new Event();
        $date4 = "12-04-2023";
        $Event4->setNom('Session escalade')
        ->setType('Sport')
        ->setLieux('Nantes')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date4))
        ->setDescription('Ramenez vos harnais et votre energie !');
        $manager->persist($Event4);

        $Event5=new Event();
        $date5 = "30-02-2022";
        $Event5->setNom('Session de ski')
        ->setType('Sortie en montagne')
        ->setLieux('Chamonix')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date5))
        ->setDescription('Ramenez vos skis et vos platres!');
        $manager->persist($Event5);

        $Event6=new Event();
        $date6 = "22-04-2022";
        $Event6->setNom('Marathon De paris')
        ->setType('Sport')
        ->setLieux('Paris')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date6))
        ->setDescription('Ramenez vos basket et votre energie !');
        $manager->persist($Event6);

        $Event7=new Event();
        $date7 = "10-09-2021";
        $Event7->setNom('Anniversaire Maxence')
        ->setType('autre')
        ->setLieux('Pornic')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date7))
        ->setDescription('Ramenez plein de cadeau !');
        $manager->persist($Event7);

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