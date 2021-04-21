<?php

namespace App\Entity;

use App\Repository\LegalCategoriesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LegalCategoriesRepository::class)
 */
class LegalCategories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"archived"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     * @Groups({"archived"})
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"archived"})
     */
    private $wording;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getWording(): ?string
    {
        return $this->wording;
    }

    public function setWording(string $wording): self
    {
        $this->wording = $wording;

        return $this;
    }
}
