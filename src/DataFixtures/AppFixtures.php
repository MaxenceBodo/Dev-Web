<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Commentaire;
use App\Entity\User;
use App\Entity\Event;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Permet d'indiquer l'ordre d'exécution des fixtures
 * En effet l'event utilisant un user en clé étrangère
 * Et le commentaire utilisant un user et un event en clé étrangère
 * Il faut que les données s'insèrent dans un ordre précis
 */
class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user1=new User();
        $date1 = "10-09-1999";
        $roles1[]='ROLE_ADMIN';
        $password1 = $this->encoder->encodePassword($user1,'@admin1');
        $user1->setEmail('admin@hotmail.fr')
        ->setRoles($roles1)
        ->setPassword($password1)
        ->setNom('Nom1')
        ->setPrenom('Prenom1')
        ->setDateNaissance(\DateTime::createFromFormat('d-m-Y',$date1))
        ->setTelephone('0612764845');
        $manager->persist($user1);

        $user2=new User();
        $date2 = "26-07-1973";
        $roles2[]='ROLE_USER';
        $password2 = $this->encoder->encodePassword($user2,'@user1');
        $user2->setEmail('user1@hotmail.fr')
        ->setRoles($roles2)
        ->setPassword($password2)
        ->setNom('Nom2')
        ->setPrenom('Prenom2')
        ->setDateNaissance(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setTelephone('5645135287');
        $manager->persist($user2);

        $user3=new User();
        $date3 = "24-06-1971";
        $password3 = $this->encoder->encodePassword($user3,'@user2');
        $user3->setEmail('user2@hotmail.fr')
        ->setRoles($roles2)
        ->setPassword($password3)
        ->setNom('Nom3')
        ->setPrenom('Prenom3')
        ->setDateNaissance(\DateTime::createFromFormat('d-m-Y',$date3))
        ->setTelephone('0745162698');
        $manager->persist($user3);

        $Event1=new Event();
        $date1 = "23-04-2022";
        $Event1->setNom('Sortie Shutter Island')
        ->setType('Cinema')
        ->setLieux('Nantes')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date1))
        ->setDescription('Sortie cinema pour la sortie de ce chef d oeuvre')
        ->setCreateur($user1);
        $manager->persist($Event1);

        $Event2=new Event();
        $date2 = "22-04-2022";
        $Event2->setNom('Sortie Inception')
        ->setType('Cinema')
        ->setLieux('Pornic')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setCreateur($user1)
        ->setDescription('re edition de ce classique avec Di Caprio');
        $manager->persist($Event2);

        $Event3=new Event();
        $date3 = "22-04-2022";
        $Event3->setNom('Marathon De paris')
        ->setType('Sport')
        ->setLieux('Paris')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date3))
        ->setCreateur($user3)
        ->setDescription('Ramenez vos basket et votre energie !');
        $manager->persist($Event3);

        $Event4=new Event();
        $date4 = "12-04-2023";
        $Event4->setNom('Session escalade')
        ->setType('Sport')
        ->setLieux('Nantes')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date4))
        ->setCreateur($user3)
        ->setDescription('Ramenez vos harnais et votre energie !');
        $manager->persist($Event4);

        $Event5=new Event();
        $date5 = "30-02-2022";
        $Event5->setNom('Session de ski')
        ->setType('Sortie en montagne')
        ->setLieux('Chamonix')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date5))
        ->setCreateur($user2)
        ->setDescription('Ramenez vos skis et vos platres!');
        $manager->persist($Event5);

        $Event6=new Event();
        $date6 = "22-04-2022";
        $Event6->setNom('Marathon De paris')
        ->setType('Sport')
        ->setLieux('Paris')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date6))
        ->setCreateur($user1)
        ->setDescription('Ramenez vos basket et votre energie !');
        $manager->persist($Event6);

        $Event7=new Event();
        $date7 = "10-09-2021";
        $Event7->setNom('Anniversaire Maxence')
        ->setType('autre')
        ->setLieux('Pornic')
        ->setDate(\DateTime::createFromFormat('d-m-Y',$date7))
        ->setCreateur($user2)
        ->setDescription('Ramenez plein de cadeau !');
        $manager->persist($Event7);

        $comment1=new Commentaire();
        $date2 = "22-04-2022";
        $roles[]='ROLE_ADMIN';
        $comment1->setEmail('email1@hotmail.fr')
        ->setContenu('Super event')
        ->setActif('1')
        ->setcreated_at(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setEvent($Event1);
        $manager->persist($comment1);

        $comment2=new Commentaire();
        $date2 = "22-04-2022";
        $roles[]='ROLE_ADMIN';
        $comment2->setEmail('email2@hotmail.fr')
        ->setContenu('Super event')
        ->setActif('0')
        ->setcreated_at(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setEvent($Event1);
        $manager->persist($comment2);

        $comment3=new Commentaire();
        $date2 = "22-04-2022";
        $roles[]='ROLE_ADMIN';
        $comment3->setEmail('email3@hotmail.fr')
        ->setContenu('Super event')
        ->setActif('1')
        ->setcreated_at(\DateTime::createFromFormat('d-m-Y',$date2))
        ->setEvent($Event3);
        $manager->persist($comment3);

        $manager->flush();
    }
}
