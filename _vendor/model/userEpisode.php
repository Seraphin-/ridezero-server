<?php
class UserEpisodeModel {
    static function getListByUserId($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, charCode, clearStageNo FROM users_episodes WHERE playerId = ?');
            $statement->execute($args);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            $returnList = [];
            for ($i = 0; $i < count($resultList); $i++) {
                array_push($returnList, self::toModel($resultList[$i]));
            }
            return $returnList;
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
            return connectDB()->prepare('INSERT INTO users_episodes (playerId, charCode, clearStageNo) VALUES ('.substr(str_repeat(', ?', count($args)), 2).')')->execute($args);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function update($args) {
        try {
            return connectDB()->prepare('UPDATE users_episodes SET clearStageNo = ? WHERE playerId = ? AND charCode = ?')->execute([$args[2], $args[0], $args[1]]);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'CharCode' => $object->charCode,
            'ClearStageNo' => (int)$object->clearStageNo,
            'InsertDate' => '2017-11-17T03:37:38.5550026+09:00',
            'UpdateDate' => '2017-11-17T03:37:38.5550026+09:00'
        ];
    }
}