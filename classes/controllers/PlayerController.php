<?php

namespace SocymSlim\Monopoly\controllers;

use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use SocymSlim\Monopoly\entities\Player;
use SocymSlim\Monopoly\daos\PlayerDAO;
use SocymSlim\Monopoly\daos\PropertyDAO;
use SocymSlim\Monopoly\exceptions\DataAccessException;

class PlayerController
{

    // コンテナインスタンス
    private $container;

    public function __construct(ContainerInterface $container)
    {
        // 引数のコンテナインスタンスをプロパティに格納
        $this->container = $container;
    }

    // プレイヤー情報登録画面を表示する
    public function goPlayerAdd(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface

    {
        // Twigインスタンスをコンテナから取得
        $twig = $this->container->get("view");

        // レスポンスオブジェクトの作成
        $response = $twig->render($response, "playerAdd.html");

        return $response;
    }

    // プレイヤー情報を登録するメソッド
    public function playerAdd(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {

        // リダイレクトするかどうかのフラグ
        $isRedirect = false;

        // リクエストパラメータを取得
        $postParams = $request->getParsedBody();
        $addName = $postParams["addname"];

        $addName = trim($addName);

        // リクエストパラメータをエンティティに格納する
        $player = new Player();
        $player->setName($addName);

        try {
            // PDOインスタンスをコンテナから取得
            $db = $this->container->get("db");
            $playerDao = new PlayerDAO($db);

            // データ登録
            $playerId = $playerDao->insert($player);

            //SQLが成功した場合
            if ($playerId !== -1) {

                // 成功メッセージを作成
                $content = "ID " . $playerId . "で登録が完了しました";
                $isRedirect =true;

            } else {
                // 失敗メッセージを作成
                throw new DataAccessException("登録に失敗しました。");
            }
        } catch (PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("データベース処理中に障害が発生しました。", $exCode, $ex);
        } finally {
            // DB切断
            $db = null;
        }

        if ($isRedirect) {
            // リスト表示ヘリダイレクト
            $response = $response->withHeader("Location", "/showPlayerList");
            $response = $response->withStatus(302);
        } else {
            // 表示メッセージをレスポンスオブジェクトに格納
            $responseBody = $response->getBody();
            $responseBody->write($content);
        }
        
        return $response;

    }

    // プレイヤー情報一覧表示
    public function showPlayerList(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // テンプレート変数を格納する連想配列
        $assign = [];

        try {
            // PDOインスタンスをコンテナから取得
            $db = $this->container->get("db");

            $playerDao = new PlayerDAO($db);
            $playerList = $playerDao->findAll();
        } catch (PDOException $ex) {
            $assign["msg"] = "障害が発生しました。";
            var_dump($ex);
        } finally {

            // DB切断
            $db = null;
        }
        // テンプレート変数として会員情報リストを格納
        $assign["playerList"] = $playerList;

        // Twigインタスタンスをコンテナから取得
        $twig = $this->container->get("view");
        $response = $twig->render($response, "playerList.html", $assign);

        return $response;
    }
}
