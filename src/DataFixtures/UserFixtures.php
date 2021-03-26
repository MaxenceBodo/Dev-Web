<?php 

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    /**
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager) : void 
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

        $manager->flush();

        $this->addReference('user1',$user1);
        $this->addReference('user2',$user2);
        $this->addReference('user3',$user2);

    }

    
}