<?php

namespace App\DataFixtures;


use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        UserFactory::new(['email' => 'chabour.mourad87@gmail.com', 'username'=> 'mchab'])
            ->createAdminUser()
            ->createMany(1)
        ;

        UserFactory::new()->createMany(20);
    }

}
