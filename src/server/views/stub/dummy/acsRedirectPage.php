<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var string $actionUrl
 * @var string $uniqueKey
 */

use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Html\Tag\Input;
use Yiisoft\View\WebView;

$this->setTitle('Acs by code page');
?>

<h2>ACS by code emulation page</h2>
<div class="col-12 col-md-6 col-lg-6 col-xl-8">
    <form id="redirectForm" name="redirectForm" action="<?= $actionUrl ?>" method="post">
        <input type="hidden" name="cres" value="{{res}}"/>
        <input type="hidden" name="threeDSSessionData" value="2275084971"/>
        <input id="submit" type="submit" value="Submit">
    </form>
</div>
<script type="text/javascript">
    document.getElementById('submit').addEventListener("click", function () {
        document.getElementById('redirectForm').submit();
    }, false);
</script>
