<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Api\Filter\RegexpFilter;
use App\Controller\Api\CompanyCountController;
use App\Controller\Api\CompanyPublishController;
use App\Repository\CompanyRepository;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        "GET",
        "POST",
        "count" =>
            [
            "method" => "GET",
            "path"=> "/companies/count",
            "controller" => CompanyCountController::class,
            "read" => false,
            "write" => false,
            'pagination_enabled'=> false,
            "filters" => [

            ],
            "openapi_context" => [
                "summary"=> "Recupére le nombre totale des companies",
                 "parameters"=> [
                     [
                         "in" =>  "query",
                         "name"=> "isPublished",
                         "schema"=> [
                             "type"=> "integer",
                             "maximum" => 1,
                             "minimum" => 0
                         ],
                         "description" => "filtre les companies en ligne"
                     ]
                 ],
                 "responses" => [
                     '200' => [
                         "description" => "OK",
                         "content" => [
                             "application/json" => [
                                 "schema" => [
                                     "type" => "integer",
                                     "example" => 3
                                 ]
                             ]
                         ]
                     ]
                 ]
            ]
        ]
    ],
    itemOperations: [
        "GET"=> [
            "normalization_context"=> [
                "groups"=> ["company:item:read", "company:read"],
                "openapi_definition_name"=>"Detail"
            ]
        ],
        "PUT",
        "publish" => [
            "method" => "POST",
            "path" => "/companies/{id}/publish",
            "controller" => CompanyPublishController::class,
            "normalization_context"=> [
                "groups"=> ["company:update:read"],
                "openapi_definition_name"=>"UpdateRead"
            ],
            "denormalization_context" => [
                "groups"=> ["company:update"],
                "openapi_definition_name"=>"UpdateWrite"
            ],
            "openapi_context" => [
                "summary"=> "Permet de publier une companie",
                "request_body" => [
                    "content" => [
                        'application/json' => [
                            "schema"=> []
                        ]
                    ]
                ]
            ]
        ]
    ],
    shortName: "companies",
    denormalizationContext: [
        "groups" => ["company:write"],
        "swagger_definition_name" => "Write"
    ],
    normalizationContext: [
        "groups" => ["company:read"],
        "swagger_definition_name" => "Read"
    ],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 3,
    paginationMaximumItemsPerPage: 3
)
]
#[ApiFilter(SearchFilter::class, properties: ["name" => "partial", "id"=> "exact"])]
#[ApiFilter(RangeFilter::class, properties: ["capital"])]
#[ApiFilter(RegexpFilter::class, properties: ["name"])]
class Company
{

    /**
     * Id de la companie
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["company:read", "archived"])]
    private $id;

    /**
     * ajouter la description que tu veux
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"archived"})
     */
    #[Groups(["company:read","company:write"])]
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=LegalCategories::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(["company:write", "archived", "company:read"])]
    private $legalCategory;

    /**
     * @ORM\Column(type="string", length=14)
     */
    #[
        Groups(["company:read", "archived" , "company:write"]),
        Assert\Length(min: 14,  max: 14),
    ]
    private $siren;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["company:read", "archived", "company:write"])]
    private $cityOfRegistration;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(["company:read"])]
    private $dateOfRegistration;

    /**
     * @ORM\Column(type="integer")
     */
    #[
        Groups(["company:read", "company:write", "archived"]),
        Assert\NotBlank(),
        Assert\Positive(),
        Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')
    ]
    private $capital;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="company", cascade={"persist"}, orphanRemoval=true)
     */
    #[
        Groups(["company:read", "archived", "company:write"]),
        Assert\Valid()
    ]
    private $localizations;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    #[
        Groups(["company:read", "company:update:read"]),
        ApiProperty(
            openapiContext: [
                "type" => "boolean",
                "description" => "Mise en ligne"
            ]
        )
    ]
    private $isPublished;

    public function __construct()
    {
        $this->dateOfRegistration = new \DateTimeImmutable();
        $this->localizations = new ArrayCollection();
        $this->isPublished = false;
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

    /**
     * How long ago in text that this cheese listing was added.
     */
    #[Groups(["company:item:read"])]
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getDateOfRegistration())->diffForHumans();
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
                $localization->setCompany( );
            }
        }

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
