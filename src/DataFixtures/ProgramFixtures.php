<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        [
            'title' => '1899',
            'synopsis' => 'Un voyage transatlantique sur un paquebot tourne au drame',
            'categorie' => 'Science-Fiction',
        ],
        [
            'title' => 'Game of Thrones',
            'synopsis' => 'Du sang, du sexe et des dragons',
            'categorie' => 'Fantastique',
        ],
        [
            'title' => 'La Chronique des Bridgerton',
            'synopsis' => 'Des nobles qui se font la cour',
            'categorie' => 'Romance',
        ],
        [
            'title' => 'The Office',
            'synopsis' => 'Les aventures d\'employés dans une entreprise de papier',
            'categorie' => 'Comédie',
        ],
        [
            'title' => 'Spy X Family',
            'synopsis' => 'Un père espion, une mère tueuse à gages, une enfant télépathe: la (fausse) famille parfaite!',
            'categorie' => 'Animation',
        ],
        [
            'title' => 'Twin Peaks',
            'synopsis' => 'Après l\'assassinat de Laura Palmer, une question se pose: qui était-elle vraiment?',
            'categorie' => 'Mystère',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $series) {
            $program = new Program();
            $program->setTitle($series['title']);
            $program->setSynopsis($series['synopsis']);
            $program->setCategory($this->getReference('categorie_' . $series['categorie']));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
