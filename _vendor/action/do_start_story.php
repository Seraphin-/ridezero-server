<?php
class do_start_story {
    function runAction($params) {
        return (object)[
            'ItemList' => UserItemModel::getListByUserId([PLAYER_ID]),
            'PlayerInfo' => UserModel::getData([PLAYER_ID])
        ];
    }
}