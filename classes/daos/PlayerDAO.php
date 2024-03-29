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
            player_total_asset,
            inheritance_tax
        )
        VALUES
        (
            :player_name,
            :player_total_asset,
            :inheritance_tax
        );";

        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlInsert);

        // 変数をバインド
        $stmt->bindValue(":player_name", $player->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":player_total_asset", $player->getTotalAsset(), PDO::PARAM_INT);
        $stmt->bindValue(":inheritance_tax", $player->getInheritanceTax(), PDO::PARAM_INT);

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
                $inheritanceTax = $row["inheritance_tax"];

                // Playerエンティティインスタンスを生成
                $player = new Player();

                $player->setId($id);
                $player->setName($name);
                $player->setTotalAsset($totalAsset);
                $player->setInheritanceTax($inheritanceTax);

                // Playerエンティティを会員情報リスト連想配列に格納
                $playerList[$id] = $player;
            }
        }
        return $playerList;
    }

    // 1件検索
    public function findByPk(int $id)
    {
        // データ取得用SQLを文字列で用意
        $sqlSelect = "SELECT * FROM players WHERE id = :id";
        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlSelect);
        // 変数をバインド
        $stmt->bindvalue(":id", $id, PDO::PARAM_INT);
        // SQLの実行
        $result = $stmt->execute();

        // SQL実行が成功したとき
        if ($result && $row = $stmt->fetch()) {

                // 各カラムのデータ取得
                $id = $row["id"];
                $name = $row["player_name"];
                $totalAsset = $row["player_total_asset"];
                $inheritanceTax = $row["inheritance_tax"];

                // Playerエンティティインスタンスを生成
                $player = new Player();

                $player->setId($id);
                $player->setName($name);
                $player->setTotalAsset($totalAsset);
                $player->setInheritanceTax($inheritanceTax);

            }
    
        return $player;
    }

    // 名前で検索
    public function findByName(string $name)
    {
        // データ取得用SQLを文字列で用意
        $sqlSelect = "SELECT * FROM players WHERE player_name = :player_name";
        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlSelect);
        // 変数をバインド
        $stmt->bindvalue(":player_name", $name, PDO::PARAM_STR);
        // SQLの実行
        $result = $stmt->execute();

        // SQL実行が成功したとき
        if ($result && $row = $stmt->fetch()) {

                // 各カラムのデータ取得
                $id = $row["id"];
                $name = $row["player_name"];
                $totalAsset = $row["player_total_asset"];
                $inheritanceTax = $row["inheritance_tax"];

                // Playerエンティティインスタンスを生成
                $player = new Player();

                $player->setId($id);
                $player->setName($name);
                $player->setTotalAsset($totalAsset);
                $player->setInheritanceTax($inheritanceTax);

            }
    
        return $player;
    }

    // データ削除メソッド
    public function deleteByPK(int $id)
    {

        // 削除SQLを文字列で用意
        $sqlDelete = "DELETE FROM
        players WHERE id = :id";

        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlDelete);
        // 変数をバインド
        $stmt->bindvalue(":id", $id, PDO::PARAM_INT);
        // SQLの実行
        $result = $stmt->execute();

        // 初期値は削除フラグをfalseとする
        $deleteFlg = false;

        if ($result) {
            $deleteFlg = true;
        }

        return $deleteFlg;
    }
}
