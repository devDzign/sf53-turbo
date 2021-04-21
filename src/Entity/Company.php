<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"archived"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"archived"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=LegalCategories::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"archived"})
     */
    private $legalCategory;

    /**
     * @ORM\Column(type="string", length=14)
     * @Assert\Length(min=14,  max=14)
     * @Groups({"archived"})
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"archived"})
     */
    private $cityOfRegistration;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $dateOfRegistration;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive()
     * @Groups({"archived"})
     */
    private $capital;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="company", cascade={"persist"}, orphanRemoval=true)
     * @Groups({"archived"})
     */
    private $localizations;

    public function __construct()
    {
        $this->dateOfRegistration = new \DateTimeImmutable();
        $this->localizations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLegalCategory(): ?LegalCategories
    {
        return $this->legalCategory;
    }

    public function setLegalCategory(?LegalCategories $legalCategory): self
    {
        $this->legalCategory = $legalCategory;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getCityOfRegistration(): ?string
    {
        return $this->cityOfRegistration;
    }

    public function setCityOfRegistration(string $cityOfRegistration): self
    {
        $this->cityOfRegistration = $cityOfRegistration;

        return $this;
    }

    public function getDateOfRegistration(): ?\DateTimeImmutable
    {
        return $this->dateOfRegistration;
    }

    public function setDateOfRegistration(\DateTimeImmutable $dateOfRegistration): self
    {
        $this->dateOfRegistration = $dateOfRegistration;

        return $this;
    }

    public function getCapital(): ?int
    {
        return $this->capital;
    }

    public function setCapital(int $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getLocalizations(): Collection
    {
        return $this->localizations;
    }

    /**
     * @return Collection|Address[]
     */
    public function setLocalizations(ArrayCollection $addresses): Collection
    {
        return $this->localizations = $addresses;
    }

    public function addLocalization(Address $localization): self
    {
        if (!$this->localizations->contains($localization)) {
            $this->localizations[] = $localization;
            $localization->setCompany($this);
        }

        return $this;
    }

    public function removeLocalization(Address $localization): self
    {
        if ($this->localizations->removeElement($localization)) {
            // set the owning side to null (unless already changed)
            if ($localization->getCompany() === $this) {
                $localization->setCompany(null);
            }
        }

        return $this;
    }
}
