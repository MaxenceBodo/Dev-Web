<?php 

namespace App\DataFixtures;

use App\Entity\Commentaire;
use App\Form\EventType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager) : void 
    {
        $comment1=new Commentaire();
        $date2 = "22-04-2022";
        $roles[]='ROLE_ADMIN';
        $comment1->setPseudo('Pseudo2')
        ->setEmail('email1@hotmail.fr')
        ->setContenu('Super event')
        ->setActif('1')
        ->setCreatedAt(\DateTime::createFromFormat('d-m-Y',$date2));
        $manager->persist($comment1);

        $comment2=new Commentaire();
        $date2 = "22-04-2022";
        $roles[]='ROLE_ADMIN';
        $comment2->setPseudo('Pseudo2')
        ->setEmail('email2@hotmail.fr')
        ->setContenu('Super event')
        ->setActif('0')
        ->setCreatedAt(\DateTime::createFromFormat('d-m-Y',$date2));
        $manager->persist($comment2);

        $comment3=new Commentaire();
        $date2 = "22-04-2022";
        $roles[]='ROLE_ADMIN';
        $comment3->setPseudo('Pseudo3')
        ->setEmail('email3@hotmail.fr')
        ->setContenu('Super event')
        ->setActif('1')
        ->setCreatedAt(\DateTime::createFromFormat('d-m-Y',$date2));
        $manager->persist($comment3);

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            EventType::class,
        ];
    }
       
    
}