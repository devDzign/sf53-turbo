<?php

namespace App\Repository;

use App\Entity\Dependency;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV5;


class DependencyRepository
{
    public function __construct(private string $path)
    {
    }

    private function getDependencyArray(): array
    {
        $json = json_decode(file_get_contents($this->path . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
        return $json['require'];
    }


    /**
     * @return array<Dependency>
     */
    public function getDependencies(): array
    {
        $items = [];
        foreach ($this->getDependencyArray() as $name => $version) {
            $items[] = new Dependency($name, $version);
        }

        return $items;
    }

    /**
     * @return Dependency|null
     */
    public function findDependencyWithUuid(string $uuid): ?Dependency
    {
        foreach ($this->getDependencyArray() as $name => $version) {
            $uuidGenerate = UuidV5::v5(new Uuid(UuidV5::NAMESPACE_URL), $name);

            if($uuid === $uuidGenerate->toRfc4122()){
                return new Dependency($name, $version);
            }
        }

        return null;
    }
}
