<?php

namespace App\Service;

use App\Entity\City;
use App\Entity\Forecast;
use App\Repository\CityRepository;
use App\Repository\ForecastRepository;

class WeatherUtil
{
    public function __construct(
        private CityRepository $cityRepository,
        private ForecastRepository $forecastRepository
    ) {
    }

    public function getWeatherForLocation(City $city): array
    {
        return $this->forecastRepository->findByCity($city);
    }

    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $city = $this->cityRepository->findOneBy([
            'CountryCode' => $countryCode,
            'CityName' => $city,
        ]);

        return $this->getWeatherForLocation($city);
    }
}
