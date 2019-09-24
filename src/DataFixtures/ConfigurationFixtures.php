<?php

namespace App\DataFixtures;

use App\Entity\Configuration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ConfigurationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $configuration = new Configuration();
        $configuration->setName('email_administrateur');
        $configuration->setValue('mmecabih@datainmotion.fr');
        $manager->persist($configuration);

        $manager->flush();
    }
}
