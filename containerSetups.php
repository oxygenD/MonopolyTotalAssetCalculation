<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Flash;
use Slim\Views\Twig;


$container = new Container();

$container->set(
    "view",
    function () {
        $twig = Twig::create($_SERVER["DOCUMENT_ROOT"] . "/../templates");
        return $twig;
    }
);

// フラッシュメッセージ
$container->set(
    "flash",
    function () {
        $flashMessage = new Flash\Messages();
        return $flashMessage;
    }
);

// PDOインスタンスを生成する処理
$container->set(
    "db",
    function () {

        // SocymSlimMonopolyプロジェクトのDB接続情報変更

        // 環境変数DATABASE_URLを取得する
        $databaseuri = getenv("DATABASE_URL");
        // DATABASE_URLを解析
        $parsedDatabaseUri = parse_url($databaseuri);
        // ホスト部分を取得
        $host = $parsedDatabaseUri["host"];
        // ポート部分を取得
        $port = $parsedDatabaseUri["port"];
        // ユーザ部分を取得
        $dbUsername = $parsedDatabaseUri["user"];
        // パスワード部分を取得
        $dbPassword = $parsedDatabaseUri["pass"];
        // パス部分を取得した上で先頭の/を削除
        $dbname = ltrim($parsedDatabaseUri["path"],"/");
        // DNS文字列を生成
        $dbDns = "pgsql:dbname=".$dbname.";host=".$host.";port=".$port;

        // PDOインスタンスの作成とDB接続
        $db = new PDO($dbDns, $dbUsername, $dbPassword);
        // PDOのエラー表示モードを例外モードに設定
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // プリペアードステートメントを有効に設定
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // フェッチモードをカラム名のみの結果セットに設定する
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $db;
    }
);


AppFactory::setContainer($container);
