<?php

namespace App\Command;

use App\Service\WeatherUtil;
use App\Repository\CityRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WeatherCityCountryCommand extends Command
{
    private WeatherUtil $weatherUtil;
    private CityRepository $cityRepository;

    public function __construct(WeatherUtil $weatherUtil, CityRepository $cityRepository)
    {
        parent::__construct();

        $this->weatherUtil = $weatherUtil;
        $this->cityRepository = $cityRepository;
    }

    protected function configure(): void
    {
        $this
            ->setName('weather:city-country')
            ->setDescription('Get weather forecast for a city in a specific country.')
            ->addArgument('countryCode', InputArgument::REQUIRED, 'Country code (e.g., PL)')
            ->addArgument('cityName', InputArgument::REQUIRED, 'City name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('countryCode');
        $cityName = $input->getArgument('cityName');

        $location = $this->cityRepository->findOneBy(['CountryCode' => $countryCode, 'CityName' => $cityName]);

        if (!$location) {
            $io->error('Location not found.');
            return Command::FAILURE;
        }

        $forecasts = $this->weatherUtil->getWeatherForLocation($location);

        $io->writeln(sprintf('Location: %s, %s', $location->getCityName(), $location->getCountryCode()));

        foreach ($forecasts as $forecast) {
            $io->writeln(sprintf("\t%s: %s",
                $forecast->getDate()->format('Y-m-d'),
                $forecast->getTemperature()
            ));
        }

        return Command::SUCCESS;
    }
}
