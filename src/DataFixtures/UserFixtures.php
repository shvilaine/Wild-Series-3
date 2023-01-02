<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) 
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('anotheruser@monsite.com');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'userpassword'

        );
        $user->setPassword($hashedPassword);
        $user->setRoles(array($user['role']));
        $this->addReference('user_' . self::class, $user);
        $manager->persist($user);

        $contributor = new User();
        $contributor->setEmail('anothercontributor@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'contributorpassword'

        );
        $contributor->setPassword($hashedPassword);
        $contributor->setRoles(array($contributor['role']));
        $this->addReference('user_' . self::class, $contributor);
        $manager->persist($contributor);

        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminpassword'
        );
        $admin->setPassword($hashedPassword);
        $admin->setRoles(array($admin['role']));
        $this->addReference('admin_' . self::class, $admin);
        $manager->persist($admin);

        $manager->flush();
    }
}
