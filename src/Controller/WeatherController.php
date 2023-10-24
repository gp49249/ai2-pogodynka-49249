<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CityRepository;
use App\Repository\ForecastRepository;

class WeatherController extends AbstractController
{
    #[Route('/weather/{cityName}', name: 'app_weather')]
    public function city(string $cityName, CityRepository $cityRepository, ForecastRepository $repository): Response
    {
        $city = $cityRepository->findOneBy(['CityName' => $cityName]);
        $forecasts = $repository->findByCity($city);

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'forecast' => $forecasts,
        ]);
    }
}

