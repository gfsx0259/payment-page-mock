<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var string $completeUrl
 * @var string $uniqueKey
 */

use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Html\Tag\Input;
use Yiisoft\View\WebView;

$this->setTitle('Aps page');
?>

<h2>APS emulation page</h2>
<div class="col-12 col-md-6 col-lg-6 col-xl-8">
    <?= Form::widget()
        ->action($completeUrl)
        ->id('form-aps-page')
        ->begin()
    ?>
    <?= Input::hidden('uniqueKey', $uniqueKey)->render(); ?>

    <?= Field::widget()->submitButton([], ['class' => 'btn btn-primary']) ?>
</div>
