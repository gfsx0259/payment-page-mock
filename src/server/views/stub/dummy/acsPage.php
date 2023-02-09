<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var AcsRequestForm $form
 */

use App\Stub\Form\AcsRequestForm;
use Yiisoft\Form\Field;
use Yiisoft\Html\Tag\Form;
use Yiisoft\Html\Tag\Input;
use Yiisoft\View\WebView;

$this->setTitle('Acs page');
?>

<h2>ACS emulation page</h2>

<div class="col-12 col-md-6 col-lg-6 col-xl-8">
    <?= Form::tag()
        ->post($form->getTermUrl())
        ->id('form-acs-page')
        ->open()
    ?>

    <?= Field::hidden($form, 'MD') ?>
    <?= Input::hidden(
        'PaRes',
        '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'
    )->render(); ?>
    <?= Field::submitButton('Подтвердить') ?>
    <?= Form::tag()->close() ?>
</div>
