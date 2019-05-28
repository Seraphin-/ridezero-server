<?php
class UserChaoticStageModel {
    static function get($args) {
        global $config;
        $returnList = [];
        $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Chaotic.json'));
        for ($i = 0; $i < count($tableList); $i++) {
            array_push($returnList, self::toModel((object)[
                'MusicNo' => $tableList[$i]->MusicNo,
                'PatternNo' => $tableList[$i]->PatternNo
            ]));
        }
        return $returnList;
    }

    static function toModel($object) {
        return (object)[
            'pid' => PLAYER_ID,
            'AddBy' => 'BuyPackage',
            'updateDate' => '2017-01-01T00:00:00',
            'MusicNo' => (int)$object->MusicNo,
            'PatternNo' => (int)$object->PatternNo
        ];
    }
}