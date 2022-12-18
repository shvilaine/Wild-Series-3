<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i < 11; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());

            for ($j = 1; $j <= 3; $j++) {
                $actor->addProgram($this->getReference('category_' . CategoryFixtures::CATEGORIES[$faker->numberBetween(1, 7)] . '_program_' . $faker->numberBetween(1, 3)));
            }
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
