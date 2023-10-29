<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CityName = null;

    #[ORM\Column(length: 2)]
    private ?string $CountryCode = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Longitude = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Forecast::class)]
    private Collection $forecasts;

    public function __construct()
    {
        $this->forecasts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityName(): ?string
    {
        return $this->CityName;
    }

    public function setCityName(string $CityName): static
    {
        $this->CityName = $CityName;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->CountryCode;
    }

    public function setCountryCode(string $CountryCode): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(string $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(string $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    /**
     * @return Collection<int, Forecast>
     */
    public function getForecasts(): Collection
    {
        return $this->forecasts;
    }

    public function addForecast(Forecast $forecast): static
    {
        if (!$this->forecasts->contains($forecast)) {
            $this->forecasts->add($forecast);
            $forecast->setCity($this);
        }

        return $this;
    }

    public function removeForecast(Forecast $forecast): static
    {
        if ($this->forecasts->removeElement($forecast)) {
            // set the owning side to null (unless already changed)
            if ($forecast->getCity() === $this) {
                $forecast->setCity(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getCityName() ?? '';
    }
}
