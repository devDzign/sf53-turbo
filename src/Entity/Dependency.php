<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV5;

#[ApiResource (
    collectionOperations: [
        'get',
        'post'
    ],
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

    public function __construct( string $name, string $version)
    {
        $this->uuid = UuidV5::v5(new Uuid(UuidV5::NAMESPACE_URL), $name);
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