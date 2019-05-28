<?php
class UserArcadeStageModel {
    static function get() {
        $astages = connectDb()->query('SELECT MusicNo FROM songs')->fetchAll(PDO::FETCH_CLASS);
        $returnList = [];
        for ($i=0; $i < count($astages); $i++) {
            array_push($returnList, self::toModel($astages[$i]));
        }
        return $returnList;
    }

    static function toModel($object) {
        return (object)[
            'pid' => PLAYER_ID,
            'AddBy' => 'BuyPackage',
            'insertDate' => '2017-01-01T00:00:00',
            'updateDate' => '2017-01-01T00:00:00',
            'MusicNo' => (int)$object->MusicNo
        ];
    }
}