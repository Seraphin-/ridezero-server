<?php
class UserStatisticsModel {
    static function getListByUserId($args) {
        try {
            return [];
        } catch (\Exception $e) {
            return false;
        }
    }
    
    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'Leaderboard' => $object->leaderboard,
            'Day' => (int)$object->_day,
            'Week' => (int)$object->_week,
            'Month' => (int)$object->_month,
            'Total' => (int)$object->total,
            'LastUpdateDate' => '2017-11-05T22:22:41',
            'FirstUpdateDate' => '2017-11-05T22:22:41'
        ];
    }
}