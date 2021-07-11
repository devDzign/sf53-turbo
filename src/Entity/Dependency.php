<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Uid\UuidV5;

#[ApiResource (
    collectionOperations: ['get'],
    itemOperations: ['get'],
    paginationEnabled: false
)]
class Dependency
{
    #[ApiProperty(
        identifier: true
    )]
    private UuidV5 $uuid;

    #[ApiProperty(
        description: 'Nom de la dependence',
        openapiContext: [
            'example'=> 'Symfony/symfony'
        ]
    )]
    private string $name;

    #[ApiProperty(
        description: 'Version de la dependence',
        openapiContext: [
            'example'=> '5.3.*'
        ]
    )]
    private string $version;

    public function __construct(UuidV5 $uuid, string $name, string $version)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

}