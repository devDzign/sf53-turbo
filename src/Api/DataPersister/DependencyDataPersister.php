<?php


namespace App\Api\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;

class DependencyDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * DependencyDataProvider constructor.
     * @param DependencyRepository $repository
     */
    public function __construct(private DependencyRepository $repository)
    {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Dependency;
    }

    public function persist($data, array $context = [])
    {
        $this->repository->persist($data);
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}