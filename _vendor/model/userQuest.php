<?php
class UserQuestModel {
    static function getListByUserId($args) {
        try {
            return [];
            $statement = connectDB()->prepare('SELECT playerId, questId, isClear, isReward, performCount FROM users_quests WHERE playerId = ?');
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

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'QuestID' => (int)$object->questId,
            'IsClear' => !!$object->isClear,
            'IsReward' => !!$object->isReward,
            'PerformCount' => (int)$object->performCount,
            'LastClearDate' => '2017-11-17T03:15:31',
            'StartDate' => '2017-11-05T22:17:23'
        ];
    }
}