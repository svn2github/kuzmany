<?php

    if (!isset($gCms)) exit;

    Translation::setLanguages($this->getLangs());

    if (isAjax() && $_POST['aAction'] == 'update')
        Translation::update($_POST);

    if (isAjax() && $_POST['aAction'] == 'remove')
        Translation::remove($_POST['delKey']);

    exit;

?>