<?php
class get_game_result {
    function runAction($params) {
        return (object)[
            'gameResults' => UserResultModel::getListByUserId([PLAYER_ID])
        ];
    }
}