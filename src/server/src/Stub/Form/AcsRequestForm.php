<?php

declare(strict_types=1);

namespace App\Stub\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;

class AcsRequestForm extends FormModel
{
    private string $PaReq;
    private string $MD;
    private string $TermUrl;

    /**
     * @return string
     */
    public function getPaReq(): string
    {
        return $this->PaReq;
    }

    /**
     * @return string
     */
    public function getMD(): string
    {
        return $this->MD;
    }

    /**
     * @return string
     */
    public function getTermUrl(): string
    {
        return $this->TermUrl;
    }

    public function getFormName(): string
    {
        return '';
    }

    public function getRules(): array
    {
        return [
            'PaReq' => [new Required()],
            'MD' => [new Required()],
            'TermUrl' => [new Required()],
        ];
    }
}
