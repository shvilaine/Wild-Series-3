<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const NB_EPISODES = 10;
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (CategoryFixtures::CATEGORIES as $categoryName) {
            for ($i = 1; $i <= ProgramFixtures::NB_PROGRAMS; $i++) {
                for ($j = 1; $j <= SeasonFixtures::NB_SEASONS; $j++) {
                    for ($k = 1; $k <= self::NB_EPISODES; $k++) {
                        $episode = new Episode();
                        $episode->setNumber($k);
                        $episode->setTitle($faker->title());
                        $episode->setSynopsis($faker->paragraphs(2, true));
                        $episode->setSeason($this->getReference('category_' . $categoryName . '_program_' . $i . '_season_' . $j));
                        $episode->setSlug($this->slugger->slug($episode->getTitle()));
                        $this->addReference('category_' . $categoryName . '_program_' . $i . '_season_' . $j . '_episode_' . $k, $episode);

                        $manager->persist($episode);
                    }
                    $manager->flush();
                }
            }
        }
    }

    public function getDependencies(): array
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
