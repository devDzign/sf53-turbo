<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
#[ApiResource(
    denormalizationContext: ["groups" => ["address:write", "company:write"]]
)]
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["company:read", "archived"])]
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(["company:read", "archived", "address:write", "company:write"])]
    private $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["company:read", "archived", "address:write", "company:write"])]
    private $streetType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["company:read", "archived", "address:write", "company:write"])]
    private $streetName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["company:read", "archived", "address:write", "company:write"])]
    private $city;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Regex(pattern="/^[A-Za-z0-9]{5}$/", message="Code postal invalide.")
     */
    #[Groups(["company:read", "archived", "address:write", "company:write"])]
    private $zipCode;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="localizations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(["address:write"]), Assert\Valid()]
    private $company;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreetType(): ?string
    {
        return $this->streetType;
    }

    public function setStreetType(string $streetType): self
    {
        $this->streetType = $streetType;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    #[SerializedName("address_complete")]
    #[Groups(["company:read"])]
    public function getCompleteAddress()
    {
        return (string) ($this->getStreetNumber() . ', ' .
            $this->getStreetType() . ' ' .
            $this->getStreetName() . ',' .
            $this->getZipCode() . ' ' .
            $this->getCity());
    }

    public function __toString()
    {
        return (string) ($this->getStreetNumber() . ', ' .
            $this->getStreetType() . ' ' .
            $this->getStreetName() . ',' .
            $this->getZipCode() . ' ' .
            $this->getCity());
    }
}
