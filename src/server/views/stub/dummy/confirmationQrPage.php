<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var string $completeUrl
 * @var string $uniqueKey
 */

use Yiisoft\Form\Field;
use Yiisoft\Html\Tag\Form;
use Yiisoft\Html\Tag\Input;
use Yiisoft\View\WebView;

$this->setTitle('Aps page');
?>

<h2>Emulation page of confirmation via QR Code</h2>
<div class="col-12 col-md-6 col-lg-6 col-xl-8">
    <?= Form::tag()
        ->post($completeUrl)
        ->id('form-aps-page')
        ->open()
    ?>
    <?= Input::hidden('uniqueKey', $uniqueKey)->render(); ?>

    <?= Field::submitButton('Подтвердить') ?>
    <?= Form::tag()->close() ?>
</div>
