<?php


namespace App\Api\OpenApi;


use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\OpenApi;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public const HIDDEN_OPERATION = 'hidden';

    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        /** @var PathItem $path */
        foreach ($openApi->getPaths()->getPaths() as $key => $path){
           if($path?->getGet()?->getSummary() === self::HIDDEN_OPERATION){
               $openApi->getPaths()->addPath($key, $path->withGet(null));
               $path->withGet(null);
           }
       }

        $schemas = $openApi->getComponents()->getSecuritySchemes();
        $schemas['bearerAuth'] = new \ArrayObject([
            'type' => 'http',
            'scheme'=> 'bearer',
            'bearerFormat' => 'JWT'
        ]);

        return $openApi;
    }
}