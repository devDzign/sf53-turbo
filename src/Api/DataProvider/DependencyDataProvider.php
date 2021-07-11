<?php


namespace App\Api\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV5;

class DependencyDataProvider implements ContextAwareCollectionDataProviderInterface,ItemDataProviderInterface, RestrictedDataProviderInterface
{

    /**
     * DependencyDataProvider constructor.
     * @param DependencyRepository $repository
     */
    public function __construct(private DependencyRepository $repository)
    {
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->repository->findDependencyWithUuid($id);
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        return $this->repository->getDependencies();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Dependency::class === $resourceClass;
    }


}