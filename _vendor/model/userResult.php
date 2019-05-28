<?php
class UserResultModel {
    static function getListByUserId($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, musicNo, patternNo, score, content FROM users_results WHERE playerId = ?');
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
            array_push($args, $playerId);
            for ($j = 0; $j < count($list[$i]); $j++) {
                array_push($args, $list[$i][$j]);
            }
        }
        return self::add($args);
    }

    static function getDataByInfo($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, musicNo, patternNo, score, content FROM users_results WHERE playerId = ? AND musicNo = ? AND patternNo = ?');
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

    static function add($args) {
        try {
            return connectDB()->prepare('INSERT INTO users_results (playerId, musicNo, patternNo, score, content) VALUES ('.substr(str_repeat(', ?', count($args)), 2).')')->execute($args);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function update($args) {
        try {
            return connectDB()->prepare('UPDATE users_results SET score = ?, content = ? WHERE playerId = ? AND musicNo = ? AND patternNo = ?')->execute([$args[3], $args[4], $args[0], $args[1], $args[2]]);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        @$object->content = (object)unserialize($object->content);
        return (object)[
           'musicNo' => (int)$object->musicNo,
           'patternNo' => (int)$object->patternNo,
           'score' => (int)$object->score,
           'maxCombo' => $object->content->maxCombo,
           'judgeTable' => $object->content->judgeTable,
           'enemyBreakCount' => $object->content->enemyBreakCount,
           'isCleared' => $object->content->isCleared,
           'rankIndex' => $object->content->rankIndex,
           'rating' => $object->content->rating,
           'enemyRating' => 0.0,
           'leftHealth' => 0.0,
           'feverCount' => 0.0,
           'mineTouchCount' => 0.0,
           'playCount' => $object->content->playCount,
           'acquiredMedalIds' => $object->content->acquiredMedalIds,
           'AllNotes' => $object->content->judgeTable[0] + $object->content->judgeTable[1] + $object->content->judgeTable[2],
           'Perfect' => $object->content->judgeTable[0],
           'Good' => $object->content->judgeTable[1],
           'Miss' => $object->content->judgeTable[2]
        ];
    }
}