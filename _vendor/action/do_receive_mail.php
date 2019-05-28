<?php
class do_receive_mail {
    function runAction($params) {
        return (object)[
            'player_info' => UserModel::getData([PLAYER_ID]),
            'userItemAndShop_Datainfo' => [
                'items' => UserItemModel::getListByUserId([PLAYER_ID]),
                'shopPackages' => [],
                'support' => UserSupportModel::getListByUserId([PLAYER_ID])
            ]
        ];
    }
}