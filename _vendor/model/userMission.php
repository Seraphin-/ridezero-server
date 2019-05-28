<?php
class UserMissionModel {
    static function getListByUserId($args) {
        try {
            global $config;
            $returnList = [];
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Chaotic_Mission.json'));
            for ($i = 0; $i < count($tableList); $i++) {
                array_push($returnList, self::toModel((object)[
                    'playerId' => PLAYER_ID,
                    'missionId' => $tableList[$i]->MissionId,
                    'clear' => true,
                    'mission1Value' => $tableList[$i]->Mission1Value,
                    'mission2Value' => $tableList[$i]->Mission2Value,
                    'mission3Value' => $tableList[$i]->Mission3Value
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
            'MissionId' => (int)$object->missionId,
            'Clear' => !!$object->clear,
            'Mission1Value' => (int)$object->mission1Value,
            'Mission2Value' => (int)$object->mission2Value,
            'Mission3Value' => (int)$object->mission3Value
        ];
    }
}