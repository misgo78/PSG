<?php

namespace App\DataFixtures;

use App\Entity\Club;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        
        for($i = 1; $i <= 30; $i++)
        {
        $club = new Club();

        $nomClub = $faker->sentence();
        $adresseClub = $faker->countryCode();
        $telclub= $faker->phoneNumber();        

        $club->setnomClub($nomClub)
           ->setadresseClub($adresseClub)
           ->settelClub($telclub);


           for($j = 1; $j <= mt_rand(2, 5); $j++)
           {
               $image = new Image();
               $image->setUrl($faker->imageUrl())
                     ->setCaption($faker->sentence())
                     ->setClub($club);
                $manager->persist($image);
           }
           
        $manager->persist($club);
        }
        
        $manager->flush();
    }
}