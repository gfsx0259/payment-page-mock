<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use App\Stub\Entity\Callback;
use App\Stub\Repository\CallbackRepository;
use App\Stub\Repository\StubRepository;
use Cycle\ORM\Select\Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Safe\Exceptions\ArrayException;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

use function Safe\array_flip;

final class CallbackController extends EntityController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private CallbackRepository $callbackRepository,
        private StubRepository $stubRepository,
    ) {}

    protected function getRepository(): Repository
    {
        return $this->callbackRepository;
    }

    protected function getCollection(CurrentRoute $route): ArrayCollection
    {
        return $this->stubRepository->findByPK((int)$route->getArgument('stubId'))->getCallbacks();
    }

    /**
     * @throws Throwable
     */
    public function update(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());

        if (isset($data->id)) {
            $callback = $this->callbackRepository->findByPK($data->id);
            $callback->setBody((array)$data->callback);
        } else {
            $stub = $this->stubRepository->findByPK((int)$data->stubId);
            $index = $stub->getCallbacks()->count();
            $callback = new Callback($stub->getId(), json_encode($data->callback), $index);
        }

        $entityWriter->write([$callback]);

        return $this->responseFactory
            ->createResponse($callback->toArray());
    }

    /**
     * @throws Throwable
     * @throws ArrayException
     */
    public function changeOrder(
        CurrentRoute $route,
        ServerRequestInterface $request,
        EntityWriter $entityWriter,
        WebControllerService $webControllerService
    ): ResponseInterface
    {
        $orderMap = array_flip(json_decode($request->getBody()->getContents()));

        $stub = $this->stubRepository->findByPK((int)$route->getArgument('stubId'));
        $callbacks = $stub->getCallbacks();

        foreach ($callbacks as $callback) {
            $callback->setOrder($orderMap[$callback->getId()]);
        }

        $entityWriter->write($callbacks);

        return $webControllerService->getEmptySuccessResponse();
    }
}
