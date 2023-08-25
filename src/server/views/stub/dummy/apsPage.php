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

<h2>APS emulation page</h2>
<div class="col-12 col-md-6 col-lg-6 col-xl-8">
    <form action="<?= $completeUrl ?>" method="post">
        <input type="hidden" name="<?= 'uniqueKey' ?>" value="<?= $uniqueKey ?>">
        <input type="submit" value="Отправить">
    </form>
</div>
