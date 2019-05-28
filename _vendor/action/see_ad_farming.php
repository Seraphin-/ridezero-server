<?php
class see_ad_farming {
    function runAction($params) {
        return (object)[
            'adResult' => [
                'isDoubleSuccess' => true,
                'ItemList' => UserItemModel::getListByUserId([PLAYER_ID]),
                'player_info' => UserModel::getData([PLAYER_ID])
            ]
        ];
    }
}