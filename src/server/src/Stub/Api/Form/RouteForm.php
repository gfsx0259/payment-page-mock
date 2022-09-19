<?php

declare(strict_types=1);

namespace App\Stub\Api\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;

final class RouteForm extends FormModel
{
    private string $path;
    private string $description;
    private string $logo;
    private int $type;

    public function getFormName(): string
    {
        return '';
    }

    public function getRules(): array
    {
        return [
            'path' => [new Required()],
            'type' => [new Number()],
        ];
    }


    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}
