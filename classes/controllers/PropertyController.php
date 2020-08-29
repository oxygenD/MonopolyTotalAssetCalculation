<?php

namespace SocymSlim\Monopoly\controllers;

use PDO;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use SocymSlim\Monopoly\daos\PropertyDAO;
use SocymSlim\Monopoly\exceptions\DataAccessException;

class PropertyController
{

    // コンテナインスタンス
    private $container;

    public function __construct(ContainerInterface $container)
    {
        // 引数のコンテナインスタンスをプロパティに格納
        $this->container = $container;
    }

    // 資産登録画面を表示する。※条件付き物件一覧画面とも言える。現状、システムの規模が小さいので良いが。
    public function goUpdateAssetInfo(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        // 表示先テンプレートのファイルパス
        $templatePath = "AssetInfoUpdate.html";

        // テンプレート変数を格納する連想配列
        $assign = [];
        // URL中のパラメータを取得
        $playerId = $args["id"];

        try {
            // PDOインスタンスをコンテナから取得
            $db = $this->container->get("db");
            $propertyDAO = new PropertyDAO($db);

            $property = $propertyDAO->find($playerId);

            
            // データが存在する場合
            if (isset($property)) {

                // テンプレート変数としてMemberエンティティを格納
                $assign["propertyList"] = $property;
            } else {
                $assign["msg"] = "閲覧できる物件情報は存在しません。";
            }

        } catch(PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("データベース処理中に障害が発生しました。", $exCode, $ex);

        } finally {
            // DB切断
            $db = null;
        }

        // Twigインスタンスをコンテナから取得
        $twig = $this->container->get("view");
        // レスポンスオブジェクトの作成
        $response = $twig->render($response, $templatePath,$assign);

        return $response;
    }
}
