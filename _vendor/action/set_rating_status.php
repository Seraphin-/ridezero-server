<?php
class set_rating_status {
    function runAction($params) {
        return (object)[
            'player_info' => UserModel::getData([PLAYER_ID])
        ];
    }
}