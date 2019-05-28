<?php
class UserItemModel {
    static function getListByUserId($args) {
        try {
            global $config;
            $statement = connectDB()->prepare('SELECT playerId, itemCode, quantity FROM users_items WHERE playerId = ?');
            $statement->execute($args);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            $returnList = [];
            for ($i = 0; $i < count($resultList); $i++) {
                if ($resultList[$i]->quantity) {
                    array_push($returnList, self::toModel($resultList[$i]));
                }
            }
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Designation.json'));
            for ($i = 0; $i < count($tableList); $i++) {
                array_push($returnList, self::toModel((object)[
                    'playerId' => PLAYER_ID,
                    'itemCode' => $tableList[$i]->ItemCode,
                    'quantity' => 1,
                ]));
            }
            return $returnList;
        } catch (\Exception $e) {
            return false;
        }
    }

    static function judgeItem($params, $onlyGold = false) {
        global $config;
        $newItemList = [
            [PLAYER_ID, 'GOLD', rand(1, $config->ITEM->GOLD_MAX_COUNT) * $config->ITEM->ITEM_COUNT_RATIO],
        ];
        $randomItemList = [
            'Mic_1',
            'Mic_1',
            'Mic_1',
            'Mic_2',
            'Mic_2',
            'Mic_3',
            'Fabric_1',
            'Fabric_1',
            'Fabric_1',
            'Fabric_2',
            'Fabric_2',
            'Fabric_3',
            'Steel_1',
            'Steel_1',
            'Steel_1',
            'Steel_2',
            'Steel_2',
            'Steel_3',
            'GOLD',
            'GOLD',
            'GOLD',
            'GOLD',
            'GOLD',
            'GOLD'
        ];
        if (!$onlyGold) {
            for ($i = 0; $i < $config->ITEM->MAX_EXTRA_ITEM_COUNT; $i++) {
                if (!!(rand(0, 100) > $config->ITEM->ITEM_RATIO[$i])) {
                    $randomItemId = $randomItemList[rand(0, count($randomItemList) - 1)];
                    array_push($newItemList, [PLAYER_ID, $randomItemId, rand(1, ($randomItemId === 'GOLD' ? $config->ITEM->GOLD_MAX_COUNT : $config->ITEM->ITEM_MAX_COUNT)) * $config->ITEM->ITEM_COUNT_RATIO]);
                }
            }
            for ($i = 0; $i < count($newItemList); $i++) {
                if (($userItemData = self::getDataByInfo([PLAYER_ID, $newItemList[$i][1]]))) {
                    self::update([PLAYER_ID, $newItemList[$i][1], $userItemData->Quantity + $newItemList[$i][2]]);
                } else {
                    self::add($newItemList[$i]);
                }
            }
        }
        return $newItemList;
    }

    static function getDataByInfo($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, itemCode, quantity FROM users_items WHERE playerId = ? AND itemCode = ?');
            $statement->execute($args);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            $returnList = [];
            for ($i = 0; $i < count($resultList); $i++) {
                return self::toModel($resultList[$i]);
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    } 

    static function addList($playerId, $list) {
        $args = [];
        for ($i = 0; $i < count($list); $i++) {
            array_unshift($list[$i], $playerId);
            self::add($list[$i]);
        }
        return true;
    }

    static function add($args) {
        try {
            return connectDB()->prepare('INSERT INTO users_items (playerId, itemCode, quantity) VALUES ('.substr(str_repeat(', ?', count($args)), 2).')')->execute($args);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function update($args) {
        try {
            return connectDB()->prepare('UPDATE users_items SET quantity = ? WHERE playerId = ? AND itemCode = ?')->execute([$args[2], $args[0], $args[1]]);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'ItemCode' => $object->itemCode,
            'Quantity' => (int)$object->quantity,
            'InsertDate' => '2017-11-17T03:25:49',
            'UpdateDate' => '0001-01-01T00:00:00'
        ];
    }
}