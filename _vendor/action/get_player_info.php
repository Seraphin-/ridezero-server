<?php
class get_player_info {
    function runAction($params) {
        return (object)[
            'player_info' => UserModel::getData([PLAYER_ID])
        ];
    }
}