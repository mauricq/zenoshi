<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $person = new Person();
        $person->setName('Admin');
        $person->setLastName('Admin');
        $person->setMobile('+1 999999999');
        $manager->persist($person);
        $manager->flush();


        $user = new User();
        $user->setEmail('admin@zenoshi.com');
        $user->setUsername('admin');
        $user->setPlainPassword('S>hh1:[3YQ)1Tq#');
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword() ));
        $user->setRoles(array('ROLE_USER'));
        $user->setAppKey('2RS4nDl7OgoNFIXTLssbYIEtm72rfktC');
        $user->setCreatedAt(date_create());
        $user->setUpdatedAt(date_create());
        $user->setUniqueId($user->getAppKey());
        $user->setIdPerson($person);

        $manager->persist($user);
        $manager->flush();
    }
}
