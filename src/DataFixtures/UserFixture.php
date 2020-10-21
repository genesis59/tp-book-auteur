<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixture constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUserName('toto')
            ->setRoles(['ROLE_ADMIN']);
            $user->setPassword(
                $this->passwordEncoder->encodePassword($user, '123')
            );

        $manager->persist($user);

        $user = new User();
        $user->setUserName('titi')
            ->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, '123')
        );
        $manager->persist($user);

        $user = new User();
        $user->setUserName('tata')
            ->setRoles(['ROLE_GOD']);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, '123')
        );
        $manager->persist($user);



        $manager->flush();
    }
}
