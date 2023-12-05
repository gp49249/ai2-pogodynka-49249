<?php

namespace App\Command;

use App\Service\WeatherUtil;
use App\Repository\CityRepository; // Importuje repozytorium City
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WeatherCityCommand extends Command
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
            ->setName('weather:city')
            ->setDescription('Get weather forecast for a city.')
            ->addArgument('id', InputArgument::REQUIRED, 'City ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('id');

        $location = $this->cityRepository->find($locationId);

        if (!$location) {
            $io->error('City not found.');
            return Command::FAILURE;
        }

        $forecasts = $this->weatherUtil->getWeatherForLocation($location);

        $io->writeln(sprintf('Location: %s', $location->getCityName()));

        foreach ($forecasts as $forecast) {
            $io->writeln(sprintf("\t%s: %s",
                $forecast->getDate()->format('Y-m-d'),
                $forecast->getTemperature()
            ));
        }

        return Command::SUCCESS;
    }
}
