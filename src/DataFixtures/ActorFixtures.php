<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public const NB_ACTORS = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= (self::NB_ACTORS); $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());

            for ($j = 1; $j <= 3; $j++) {
                $actor->addProgram($this->getReference('program_' . $faker->numberBetween(1, 3)));
                $this->addReference('actor_' . $i, $actor);
                $manager->persist($actor);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ActorFixtures::class,
            ProgramFixtures::class,
        ];
    }
}
