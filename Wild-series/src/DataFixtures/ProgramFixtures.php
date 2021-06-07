<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $program = new Program();
        $program->setTitle('Walking dead');
        $program->setSummary('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_0'));
        //ici les acteurs sont insérés via une boucle pour être DRY mais ce n'est pas obligatoire
        for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program->addActor($this->getReference('actor_' . $i));
        }
    
        $program = new Program();
        $program->setTitle('Fear The Walking Dead');
        $program->setPoster('https://fr.web.img6.acsta.net/pictures/20/09/25/11/43/3207723.jpg');
        $program->setSummary('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_0'));
        $program->addActor($this->getReference('actor_1'));
        $program->addActor($this->getReference('actor_2'));
        $manager->persist($program);
        $this->addReference('program_1', $program);


        $program = new Program();
        $program->setTitle('My hero academia');
        $program->setPoster('https://image.animedigitalnetwork.fr/license/mha/tv/web/affiche_600x856.jpg');
        $program->setSummary("Dans un monde où 80 % de la population mondiale possède des super-pouvoirs, ici nommés « Alters » (個性, Kosei?), n'importe qui peut devenir un héros ou, s'il le souhaite, un criminel.");
        $program->setCategory($this->getReference('category_3'));
        $program->addActor($this->getReference('actor_4'));
        $manager->persist($program);
        $this->addReference('program_2', $program);


        $program = new Program();
        $program->setTitle('Sweeth tooth');
        $program->setPoster('https://images.critictoo.com/wp-content/uploads/2021/05/Sweet-Tooth-Saison-1-Poster.jpg');
        $program->setSummary("Dans un futur post-apocalyptique, les humains ont été décimés par un mystérieux virus, et une nouvelle race d'hybrides croisant l'homme et l'animal a émergé. ");
        $program->setCategory($this->getReference('category_0'));
        $program->addActor($this->getReference('actor_0'));
        $manager->persist($program);
        $this->addReference('program_3', $program);

        $program = new Program();
        $program->setTitle('Xtreme');
        $program->setPoster('https://www.heavenofhorror.com/wp-content/uploads/2021/06/xtreme-netflix-review.jpg');
        $program->setSummary("Deux ans après le meurtre de son fils et de son père, un ex-tueur à gages met à exécution un plan de vengeance finement orchestré contre le meurtrier : son propre frère.");
        $program->setCategory($this->getReference('category_3'));
        $program->addActor($this->getReference('actor_4'));
        $manager->persist($program);
        $this->addReference('program_4', $program);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }
}