<?php

namespace App\Entity;

use App\Repository\ForecastRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForecastRepository::class)]
class Forecast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'forecasts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $Temperature = null;

    #[ORM\Column]
    private ?int $Rainfall = null;

    #[ORM\Column]
    private ?int $Humidity = null;

    #[ORM\Column(length: 255)]
    private ?string $Wind = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?city
    {
        return $this->city;
    }

    public function setCity(?city $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->Temperature;
    }

    public function setTemperature(string $Temperature): static
    {
        $this->Temperature = $Temperature;

        return $this;
    }

    public function getRainfall(): ?int
    {
        return $this->Rainfall;
    }

    public function setRainfall(int $Rainfall): static
    {
        $this->Rainfall = $Rainfall;

        return $this;
    }

    public function getHumidity(): ?int
    {
        return $this->Humidity;
    }

    public function setHumidity(int $Humidity): static
    {
        $this->Humidity = $Humidity;

        return $this;
    }

    public function getWind(): ?string
    {
        return $this->Wind;
    }

    public function setWind(string $Wind): static
    {
        $this->Wind = $Wind;

        return $this;
    }
}
