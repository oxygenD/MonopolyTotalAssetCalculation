<?php
use SocymSlim\Monopoly\controllers\PlayerController;
use SocymSlim\Monopoly\controllers\PropertyController;

$app->any("/goPlayerAdd", PlayerController::class.":goPlayerAdd");
$app->any("/playerAdd", PlayerController::class.":playerAdd");
$app->any("/showPlayerList", PlayerController::class.":showPlayerList");
$app->any("/playerDelete/{id}", PlayerController::class.":playerDelete");
// プレイヤーの資産情報を登録する画面を表示する
$app->any("/goUpdateAssetInfo/{id}", PropertyController::class.":goUpdateAssetInfo");