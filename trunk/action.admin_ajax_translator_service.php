<?php

    if (!isset($gCms)) exit;

    if (isAjax())
        Translation::update($_POST);

    exit;

?>