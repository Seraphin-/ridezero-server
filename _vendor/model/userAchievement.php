<?php
class UserAchievementModel {
    static function getListByUserId($args) {
        try {
            global $config;
            $returnList = [];
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Achievement.json'));
            for ($i = 0; $i < count($tableList); $i++) {
                array_push($returnList, self::toModel((object)[
                    'playerId' => PLAYER_ID,
                    'achievementId' => $tableList[$i]->AchievementId,
                    'isClear' => true,
                    'performCount' => 1,
                ]));
            }
            return $returnList;
        } catch (\Exception $e) {
            return false;
        }
    }

    static function getDataByInfo($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, achievementId, isClear, performCount FROM users_achievements WHERE playerId = ? AND achievementId = ?');
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
            $args[2] = $args[2] ? 1 : 0;
            return connectDB()->prepare('INSERT INTO users_achievements (playerId, achievementId, isClear, performCount) VALUES ('.substr(str_repeat(', ?', count($args)), 2).')')->execute($args);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function update($args) {
        try {
            $args[2] = $args[2] ? 1 : 0;
            return connectDB()->prepare('UPDATE users_achievements SET isClear = ?, performCount = ? WHERE playerId = ? AND achievementId = ?')->execute([$args[2], $args[3], $args[0], $args[1]]);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'AchievementId' => (int)$object->achievementId,
            'IsClear' => !!$object->isClear,
            'PerformCount' => (int)$object->performCount,
            'LastClearDate' => '0001-01-01T00:00:00'
        ];
    }
}