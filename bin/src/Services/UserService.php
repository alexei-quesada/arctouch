<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $userRepository;
    private $passwordEncoder;
    private $em;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $em
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $em;
    }

    /**
     * @param $userData
     */
    public function createUser($userData){
        $user = new User();
        $user->setName($userData['name'])
            ->setEmail($userData['email'])
            ->setPassword(
                $this->passwordEncoder->encodePassword($user,$userData['password'])
            );
        if(isset($userData['roles'])){
            $user->setRoles($userData['roles']);
        }
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param $orderBy
     * @return User[]
     */
    public function findAllOrderBy($orderBy){
        return $this->userRepository->findBy([], $orderBy);
    }
}