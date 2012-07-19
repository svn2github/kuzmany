<?php

if (!isset($gCms))
    exit;

if (!$this->CheckAccess('manage translator_mle')) {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
}

if (isAjax() && $_POST['aAction'] == 'update')
    Translation::update($_POST);

if (isAjax() && $_POST['aAction'] == 'remove')
    Translation::remove($_POST['delKey']);

exit;
?>