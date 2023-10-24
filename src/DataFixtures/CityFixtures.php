<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\City; // Dodaj linię importu dla klasy City

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        dump('CityFixtures loaded!');

        // Tworzenie przykładowych miast
        $city1 = new City();
        $city1->setCityName('Szczecin');
        $city1->setCountryCode('PL');
        $city1->setLatitude(53.4289);
        $city1->setLongitude(14.553);

        $city2 = new City();
        $city2->setCityName('Stargard');
        $city2->setCountryCode('PL');
        $city2->setLatitude(53.336);
        $city2->setLongitude(15.05037710);

        // Dodawanie miast do bazy danych
        $manager->persist($city1);
        $manager->persist($city2);

        // Zapisanie zmian w bazie danych
        $manager->flush();
    }
}
