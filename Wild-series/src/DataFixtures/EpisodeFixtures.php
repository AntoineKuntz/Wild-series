<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Episode;
USe App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i ++) {
            $episode = new Episode();
            $slug = $this->slugify->generate('Episode' . $i);
            $episode->setSlug($slug);
            $episode->setNumber($i + 1);
            $episode->setTitle('Episode ' . ($i + 1));
            $episode->setSynopsis('Episode ...');
            $episode->setSeason($this->getReference('season_0'));
            $manager->persist($episode);
        }

        for($i = 0; $i < 8; $i ++) {
            $episode = new Episode();
            $slug = $this->slugify->generate('Episode' . $i);
            $episode->setSlug($slug);
            $episode->setNumber($i + 1);
            $episode->setTitle('Episode ' . ($i + 1));
            $episode->setSynopsis('Episode...');
            $episode->setSeason($this->getReference('season_1'));
            $manager->persist($episode);
        }
        for($i = 0; $i < 12; $i ++) {
            $episode = new Episode();
            $slug = $this->slugify->generate('Episode' . $i);
            $episode->setSlug($slug);
            $episode->setNumber($i + 1);
            $episode->setTitle('Episode ' . ($i + 1));
            $episode->setSynopsis('Episode...');
            $episode->setSeason($this->getReference('season_2'));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          SeasonFixtures::class,
        ];
    }
}