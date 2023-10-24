<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Forecast;
use App\Entity\City;

class ForecastFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Tworzenie przykładowych prognoz pogody
        $forecast1 = new Forecast();
        $forecast1->setDate(new \DateTime('2023-10-25'));
        $forecast1->setTemperature(20.5);
        $forecast1->setRainfall(10);
        $forecast1->setHumidity(75);
        $forecast1->setWind('Umiarkowany wiatr');

        $forecast2 = new Forecast();
        $forecast2->setDate(new \DateTime('2023-10-26'));
        $forecast2->setTemperature(18.0);
        $forecast2->setRainfall(5);
        $forecast2->setHumidity(80);
        $forecast2->setWind('Brak wiatru');

        $forecast3 = new Forecast();
        $forecast3->setDate(new \DateTime('2023-10-27'));
        $forecast3->setTemperature(20.0);
        $forecast3->setRainfall(5);
        $forecast3->setHumidity(80);
        $forecast3->setWind('Silny wiatr');

        $forecast4 = new Forecast();
        $forecast4->setDate(new \DateTime('2023-10-28'));
        $forecast4->setTemperature(17.0);
        $forecast4->setRainfall(5);
        $forecast4->setHumidity(80);
        $forecast4->setWind('Brak wiatru');

        // Pobieranie miast z bazy danych
        $city1 = $manager->getRepository(City::class)->findOneBy(['CityName' => 'Szczecin']);
        $city2 = $manager->getRepository(City::class)->findOneBy(['CityName' => 'Stargard']);

        // Przypisanie prognoz do miast
        $forecast1->setCity($city1); // Przypisanie prognozy do miasta Szczecin
        $forecast2->setCity($city1); // Przypisanie prognozy do miasta Szczecin
        $forecast3->setCity($city2); // Przypisanie prognozy do miasta Stargard
        $forecast4->setCity($city2); // Przypisanie prognozy do miasta Stargard

        // Dodawanie prognoz do bazy danych
        $manager->persist($forecast1);
        $manager->persist($forecast2);
        $manager->persist($forecast3);
        $manager->persist($forecast4);

        // Zapisanie zmian w bazie danych
        $manager->flush();
    }
}
