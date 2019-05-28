<?php
class do_receive_mail_all {
    function runAction($params) {
        return (object)[
            'mailList' => [],
            'player_info' => UserModel::getData([PLAYER_ID]),
            'receiveList' => [],
            'userItemAndShop_Datainfo' => [
                'items' => UserItemModel::getListByUserId([PLAYER_ID]),
                'shopPackages' => [],
                'support' => UserSupportModel::getListByUserId([PLAYER_ID])
            ]
        ];
    }
}