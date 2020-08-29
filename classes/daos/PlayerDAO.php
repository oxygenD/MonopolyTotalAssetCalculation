<?php

namespace SocymSlim\Monopoly\daos;

use PDO;
use SocymSlim\Monopoly\entities\Player;

class PlayerDAO
{
    // PDOインスタンスを表すプロパティ
    private $db;

    // コンストラクタ
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // データ登録メソッド
    public function insert(Player $player)
    {
        // 登録用SQLを文字列で用意
        $sqlInsert = "INSERT INTO
        players(
            player_name,
            player_total_asset
        )
        VALUES
        (
            :player_name,
            :player_total_asset
        );";

        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlInsert);

        // 変数をバインド
        $stmt->bindValue(":player_name", $player->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":player_total_asset", $player->getTotalAsset(), PDO::PARAM_INT);

        // SQLの実行
        $result = $stmt->execute();

        // 戻り値となる連番主キーを初期値は－1とする
        $mbId = -1;

        if ($result) {
            //連番主キーを取得
            $mbId = $this->db->lastInsertId();
        }

        return $mbId;
    }

    // 全件検索
    public function findAll(): array
    {
        // プレイヤー情報リストを格納する
        $playerList = [];
        // データ取得用SQLを文字列で用意
        $sqlSelect = "SELECT * FROM players ORDER BY id";
        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlSelect);
        // SQLの実行
        $result = $stmt->execute();

        // SQL実行が成功したとき
        if ($result) {

            while ($row = $stmt->fetch()) {
                // 各カラムのデータ取得
                $id = $row["id"];
                $name = $row["player_name"];
                $totalAsset = $row["player_total_asset"];

                // Playerエンティティインスタンスを生成
                $player = new Player();

                $player->setId($id);
                $player->setName($name);
                $player->setTotalAsset($totalAsset);

                // Playerエンティティを会員情報リスト連想配列に格納
                $playerList[$id] = $player;
            }
        }
        return $playerList;
    }
}
