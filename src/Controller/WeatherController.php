<?php

namespace App\Controller;

use App\Entity\City;
use App\Service\WeatherUtil;
use App\Repository\CityRepository; // Dodaj to

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    private CityRepository $cityRepository; // Dodaj to

    public function __construct(CityRepository $cityRepository) // Dodaj to
    {
        $this->cityRepository = $cityRepository;
    }

    #[Route('/weather/{cityName}', name: 'app_weather')]
    public function city(string $cityName, WeatherUtil $util): Response
    {
        $city = $this->cityRepository->findOneBy(['CityName' => $cityName]);
        $forecasts = $util->getWeatherForLocation($city);

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'forecasts' => $forecasts,
        ]);
    }
}
