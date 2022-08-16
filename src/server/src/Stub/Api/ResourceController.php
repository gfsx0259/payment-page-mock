<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Repository\ResourceRepository;
use Cycle\ORM\Select\Repository;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;

final class ResourceController extends EntityController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private ResourceRepository $resourceRepository,
    ) {}

    protected function getRepository(): Repository
    {
        return $this->resourceRepository;
    }

    public function getTemplateVariables(): ResponseInterface
    {
        $resources = $this->resourceRepository->findAll();
        $result = [];

        /** @var Resource $resource */
        foreach ($resources as $resource) {
            $result[] = [
                'name' => $resource->getTemplateVariable(),
                'description' => $resource->getDescription(),
            ];
        }

        return $this->responseFactory->createResponse($result);
    }
}
