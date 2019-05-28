<?php
class UserAchievementRewardModel {
    static function getListByUserId($args) {
        try {
            global $config;
            $returnList = [];
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_AchievementReward.json'));
            for ($i = 0; $i < count($tableList); $i++) {
                array_push($returnList, self::toModel((object)[
                    'playerId' => PLAYER_ID,
                    'score' => $tableList[$i]->Score,
                    'isReward' => true,
                    'performCount' => 1,
                ]));
            }
            return $returnList;
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'score' => (int)$object->score,
            'IsReward' => !!$object->isReward,
            'RewardDate' => '0001-01-01T00:00:00'
        ];
    }
}