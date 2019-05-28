<?php
class UserValueModel {
    static function getListByUserId($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, valueKey, intValue, stringValue FROM users_values WHERE playerId = ?');
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
            return connectDB()->prepare('INSERT INTO users_values (playerId, valueKey, intValue, stringValue) VALUES ('.substr(str_repeat(', ?', count($args)), 2).')')->execute($args);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function update($args) {
        try {
            return connectDB()->prepare('UPDATE users_values SET intValue = ?, stringValue = ? WHERE playerId = ? AND valueKey = ?')->execute([$args[2], $args[3], $args[0], $args[1]]);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'ValueKey' => $object->valueKey,
            'intValue' => (int)$object->intValue,
            'stringValue' => $object->stringValue
        ];
    }
}