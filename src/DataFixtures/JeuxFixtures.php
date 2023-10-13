<?php

namespace App\DataFixtures;

use App\Entity\Jeux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class JeuxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<6;$i++){
            $jeux = new Jeux();

            $jeux->setNomJeux("Mario $i")
            ->setGenre("plateform")
            ->setDescription("jeu de plateforme pour les petits")
            ->setImgCouverture("https://picsum.photos/23$i/300/")
            ->setNoteMoyenne(rand(10,20))
            ->setRealisedAt(new \DateTime());
            if($i % 2 === 0){
                $jeux->settype("location");  
            }else{
                $jeux->settype("vente");
            }
            $manager->persist($jeux);
        }

        $manager->flush();
    }
}
