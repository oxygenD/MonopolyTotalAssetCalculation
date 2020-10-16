<?php

namespace SocymSlim\Monopoly\daos;

use PDO;
use SocymSlim\Monopoly\entities\Property;

class PropertyDAO
{
    // PDOインスタンスを表すプロパティ
    private $db;

    // コンストラクタ
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    
    // プレイヤーが保有するか、或いは誰も保有していない物件を取得する。
    // 適切な命名を考えること
    public function findNotOwnedByOthers(int $id): array
    {
        // プレイヤーが所有しているか、もしくは売れていない物件リストを格納する
        $propertyList = [];
        // データ取得用SQLを文字列で用意。
        // 画面アクセスしたプレイヤーが所有しているか、誰も所有していない物件を条件とする。
        $sqlSelect = "SELECT * FROM properties WHERE player_id = $id or player_id IS null ORDER BY property_id ASC";
        // プリペアードステートメントインスタンスを取得
        $stmt = $this->db->prepare($sqlSelect);
        // SQLの実行
        $result = $stmt->execute();

        // SQL実行が成功したとき
        if ($result) {

            while ($row = $stmt->fetch()) {
                // 各カラムのデータ取得
                $id = $row["property_id"];
                $name = $row["property_name"];
                $basicPrice = $row["basic_price"];
                $playerId = $row["player_id"];
                
                // Propertyエンティティインスタンスを生成
                $property = new Property();

                $property->setPropertyId($id);
                $property->setName($name);
                $property->setBasicPrice($basicPrice);// データベースには必要だが、物件一覧で必要か？
                $property->setPlayerID($playerId);

                // propertyエンティティを物件リスト連想配列に格納
                $propertyList[$id] = $property;
            }
        }

        return $propertyList;
    }
}
