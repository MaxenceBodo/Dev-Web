<?php 

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager) : void 
    {
        $user1=new User();
        $date2 = "22-04-2022";
        $roles1[]='ROLE_ADMIN';
        $user1->setEmail('email1@hotmail.fr')
        ->setRoles($roles1)
        ->setPassword('@Role1')
        ->setNom('Nom1')
        ->setPrenom('Prenom1')
        ->setDateNaissance(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setTelephone('0612764845');
        $manager->persist($user1);

        $user2=new User();
        $roles2[]='ROLE_USER';
        $user2->setEmail('email2@hotmail.fr')
        ->setRoles($roles2)
        ->setPassword('@Role2')
        ->setNom('Nom2')
        ->setPrenom('Prenom2')
        ->setDateNaissance(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setTelephone('5645135287');
        $manager->persist($user2);

        $user3=new User();
        $user3->setEmail('email3@hotmail.fr')
        ->setRoles($roles2)
        ->setPassword('@Role3')
        ->setNom('Nom3')
        ->setPrenom('Prenom3')
        ->setDateNaissance(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setTelephone('0745162698');
        $manager->persist($user3);

        $manager->flush();
    }

    
}