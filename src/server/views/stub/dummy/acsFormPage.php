<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var string $actionUrl
 */

use Yiisoft\View\WebView;

$this->setTitle('ACS 3DS20 Emulation');
?>

<h2>ACS 3DS20 Emulation</h2>
<form id="redirectForm" name="redirectForm" action="<?= $actionUrl ?>" method="post">
    <input type="hidden" name="cres" value="{{res}}"/>
    <input type="hidden" name="threeDSSessionData" value="2275084971"/>
</form>
<script type="text/javascript">
    document.getElementById('redirectForm').submit();
</script>
