<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var string $actionUrl
 */

use Yiisoft\View\WebView;

$this->setTitle('Acs callback page');
?>

<h2>Emulation of waiting acs callback</h2>
<form id="3dsmethodrecall" name="3dsmethodrecall" action="<?= $actionUrl ?>" method="post">
    <input type="hidden" name="threeDSServerTransID" value="db6ac3e0-b9ed-5d75-8000-000000001042">
    <input type="hidden" name="threeDSMethodData" value="eyJ0aHJlZURTU2VydmVyVHJhbnNJRCI6ImRiNmFjM2UwLWI5ZWQtNWQ3NS04MDAwLTAwMDAwMDAwMTA0MiJ9">
</form>
<script type="text/javascript">
    var timer = setTimeout("document.getElementById('3dsmethodrecall').submit();", 1250);
</script>
