<?php

namespace SocymSlim\Monopoly\controllers;

use PDO;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use SocymSlim\Monopoly\entities\Player;
use SocymSlim\Monopoly\daos\PlayerDAO;
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

        // リクエストパラメータを取得
        $postParams = $request->getParsedBody();
        $addPlayerName = $postParams["addplayerName"];

        $addPlayerName = trim($addPlayerName);

        // リクエストパラメータをエンティティに格納する
        $player = new Player();
        $player->setPlayerName($addPlayerName);

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
            // 表示メッセージをレスポンスオブジェクトに格納
            $responseBody = $response->getBody();
            $responseBody->write($content);
        
        return $response;

    }
}
