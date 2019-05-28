<?php
class do_attendance {
    function runAction($params) {
        return (object)[
            'player_info' => UserModel::getData([PLAYER_ID]),
            'result' => (object)[
                'AttendanceList' => [],
                'IsAttendance' => false
            ],
            'userItemAndShop_Datainfo' => (object)[
                'items' => UserItemModel::getListByUserId([PLAYER_ID]),
                'shopPackages' => [],
                'support' => UserSupportModel::getListByUserId([PLAYER_ID])
            ]
        ];
    }
}