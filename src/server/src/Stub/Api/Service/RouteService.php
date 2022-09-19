<?php

declare(strict_types=1);

namespace App\Stub\Api\Service;

use App\Stub\Api\Form\RouteForm;
use App\Stub\Entity\Route;
use Exception;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class RouteService
{
    public function __construct(
        private EntityWriter $entityWriter,
        private ImageUploader $imageUploader,
    ) {
        $this->imageUploader->setUploadPath('route/');
    }

    public function save(Route $route, RouteForm $form)
    {
        $route->setRoute($form->getPath());
        $route->setTitle($form->getDescription());
        $route->setType($form->getType());
        try {
            $route->setLogo($this->imageUploader->handle($form->getLogo(), $this->getLogoFilename($form->getPath())));
        } catch (Exception) {

        }

        $this->entityWriter->write([$route]);
    }

    /**
     * Make logo filename from route path
     *
     * @param string $route
     * @return string
     */
    private function getLogoFilename(string $route): string
    {
        $routeParts = explode('/', $route);

        if ($routeParts > 1) {
            array_pop($routeParts);
        }

        return implode('-', $routeParts);
    }
}
