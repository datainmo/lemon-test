<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Intl\Intl;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $countries = Intl::getRegionBundle()->getCountryNames();
        for($i = 0; $i < 100; $i++){
            $person = new Person();
            $person->setLastName($faker->lastName())
                ->setFirstName($faker->firstName($gender = 'male'|'female'))
                ->setNationality(array_rand($countries, 1))
                ->setEmail($faker->email())
                ->setBirthDate(new \DateTime())
                ->setGender($faker->numberBetween(0,count(Person::GENDER)-1))
                ->setJobTitle($faker->numberBetween(0,count(Person::JOB)-1))
;
            $manager->persist($person);
            $manager->flush();
        }
    }
}
