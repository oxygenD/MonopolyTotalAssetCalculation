<?php

namespace SocymSlim\Monopoly\controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;


class PlayerController
{

    // コンテナインスタンス
    private $container;

    public function __construct(ContainerInterface $container)
    {
        // 引数のコンテナインスタンスをプロパティに格納
        $this->container = $container;
    }

    // 会員情報登録画面を表示する
    public function goPlayerAdd(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface

    {
        // Twigインスタンスをコンテナから取得
        $twig = $this->container->get("view");

        // レスポンスオブジェクトの作成
        $response = $twig->render($response, "playerAdd.html");

        return $response;
    }
}
