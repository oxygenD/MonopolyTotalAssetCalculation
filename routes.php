<?php
use SocymSlim\Monopoly\controllers\PlayerController;

$app->any("/goPlayerAdd", PlayerController::class.":goPlayerAdd");
$app->any("/playerAdd", PlayerController::class.":playerAdd");
$app->any("/showPlayerList", PlayerController::class.":showPlayerList");
// プレイヤーの資産情報を登録する画面を表示する
$app->any("/goRegisterAssetInfo/{id}", PlayerController::class.":goRegisterAssetInfo");
// プレイヤーの資産情報を登録する
$app->any("/RegisterAssetInfo/{id}", PlayerController::class.":RegisterAssetInfo");