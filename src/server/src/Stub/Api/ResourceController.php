<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use App\Stub\Entity\Resource;
use App\Stub\Entity\Stub;
use App\Stub\Repository\ResourceRepository;
use Cycle\ORM\Select\Repository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class ResourceController extends EntityController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private ResourceRepository $resourceRepository,
        private WebControllerService $controllerService,
    ) {}

    protected function getRepository(): Repository
    {
        return $this->resourceRepository;
    }

    public function index(): ResponseInterface
    {
        $resources = [];

        /** @var Resource $resource  */
        foreach ($this->resourceRepository->findAll() as $resource) {
            $resources[] = [
                'id' => $resource->getId(),
                'content_type' => $resource->getContentType(),
                'content' => $resource->getContent(),
                'path' => $resource->getPath(),
                'alias' => $resource->getAlias(),
                'description' => $resource->getDescription(),
            ];
        }

        return $this->responseFactory
            ->createResponse($resources);
    }

    public function create(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());
        $resource = new Resource(
            $data->path,
            $data->alias,
            $data->description,
            $data->content_type,
            $data->content,
        );

        $entityWriter->write([$resource]);

        return $this->responseFactory
            ->createResponse(['success' => $data]);
    }

    public function update(ServerRequestInterface $request, EntityWriter $entityWriter,): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());
        $resource = $this->resourceRepository->findByPK($data->id);

        if (!$resource) {
            return $this->controllerService->getNotFoundResponse();
        }

        $resource->setPath($data->path);
        $resource->setAlias($data->alias);
        $resource->setDescription($data->description);
        $resource->setContentType($data->content_type);
        $resource->setContent($data->content);

        $entityWriter->write([$resource]);

        return $this->responseFactory
            ->createResponse(['success' => $data]);
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
