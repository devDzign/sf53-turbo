<?php

namespace App\Twig;

use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SerializeExtension extends AbstractExtension
{
    /**
     * @var SerializerInterface $serializer
     */
    private SerializerInterface $serializer;

    /**
     * SerializeExtension constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('serialize', [$this, 'serialize']),
        ];
    }

    /**
     * @param        $data
     * @param string $format
     * @param array  $context
     *
     * @return string
     */
    public function serialize($data, string $format = 'json', array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }
}
