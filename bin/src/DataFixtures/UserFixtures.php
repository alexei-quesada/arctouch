<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public const REGULAR_USER_REFERENCE_1 = 'regular-user-1';
    public const REGULAR_USER_REFERENCE_2 = 'regular-user-2';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // creates an Admin
        $adminUser = new User();
        $adminUser->setName('Administrator')
            ->setEmail('admin@email.com')
            ->setPassword($this->passwordEncoder->encodePassword($adminUser,'admin'))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($adminUser);
        $manager->flush();

        // create a regular users
        $regularUser1 = new User();
        $regularUser1->setName('Alexei')
            ->setEmail('alexei@email.com')
            ->setPassword($this->passwordEncoder->encodePassword($regularUser1, 'alexei'));

        $manager->persist($regularUser1);
        $manager->flush();
        $this->addReference(self::REGULAR_USER_REFERENCE_1, $regularUser1);

        // create a regular users
        $regularUser2 = new User();
        $regularUser2->setName('Ana')
            ->setEmail('ana@email.com')
            ->setPassword($this->passwordEncoder->encodePassword($regularUser2, 'ana'));

        $manager->persist($regularUser2);
        $manager->flush();
        $this->addReference(self::REGULAR_USER_REFERENCE_2, $regularUser2);
    }
}