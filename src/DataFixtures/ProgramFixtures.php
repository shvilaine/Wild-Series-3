<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const NB_PROGRAMS = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (CategoryFixtures::CATEGORIES as $categoryName) {
            for ($i = 1; $i <= (self::NB_PROGRAMS); $i++) {
                $program = new Program();
                $program->setTitle('program' . $categoryName . $i);
                $program->setSynopsis($faker->paragraphs(2, true));
                $program->setCategory($this->getReference('category_' . $categoryName));
                $this->addReference('category_' . $categoryName . '_program_' . $i, $program);
                $manager->persist($program);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
