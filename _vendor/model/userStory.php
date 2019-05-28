<?php
class UserStoryModel {
    static function getListByUserId($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, groupNo, storyNo, isBlock, isClear FROM users_storys WHERE playerId = ?');
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
            $list[$i][2] = $list[$i][2] ? 1 : 0;
            $list[$i][3] = $list[$i][3] ? 1 : 0;
            array_unshift($list[$i], $playerId);
            self::add($list[$i]);
        }
        return true;
    }

    static function add($args) {
        try {
            $args[3] = $args[3] ? 1 : 0;
            $args[4] = $args[4] ? 1 : 0;
            return connectDB()->prepare('INSERT INTO users_storys (playerId, groupNo, storyNo, isBlock, isClear) VALUES ('.substr(str_repeat(', ?', count($args)), 2).')')->execute($args);
        } catch (\Exception $e) {
            return false;
        }
    }
    
    static function update($args) {
        try {
            $args[3] = $args[3] ? 1 : 0;
            $args[4] = $args[4] ? 1 : 0;
            return connectDB()->prepare('UPDATE users_storys SET isBlock = ?, isClear = ? WHERE playerId = ? AND groupNo = ? AND storyNo = ?')->execute([$args[3], $args[4], $args[0], $args[1], $args[2]]);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'GroupNo' => (int)$object->groupNo,
            'StoryNo' => (int)$object->storyNo,
            'isBlock' => !!$object->isBlock,
            'isClear' => !!$object->isClear,
            'insertDate' => '2017-11-05T22:17:19',
            'updateDate' => '0001-01-01T00:00:00'
        ];
    }
}