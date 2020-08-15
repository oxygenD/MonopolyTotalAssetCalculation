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
            player_name
        )
        VALUES
        (
            :player_name
        );";

        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlInsert);

        // 変数をバインド
        $stmt->bindValue(":player_name", $player->getName(), PDO::PARAM_STR);

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
}
