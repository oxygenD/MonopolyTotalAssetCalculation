<?php
use SocymSlim\Monopoly\exceptions\CustomErrorRenderer;
// 環境変数DATABASE_URLを取得
$displayErrorDetails = getenv("DEV_MODE");
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails,true,true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->registerErrorRenderer("text/html",CustomErrorRenderer::class);