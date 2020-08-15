<?php
use SocymSlim\Monopoly\controllers\PlayerController;

$app->any("/goPlayerAdd", PlayerController::class.":goPlayerAdd");
$app->any("/playerAdd", PlayerController::class.":playerAdd");
