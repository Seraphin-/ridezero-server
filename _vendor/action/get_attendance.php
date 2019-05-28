<?php
class get_attendance {
    function runAction($params) {
        return (object)[
            'player_info' => UserModel::getData([PLAYER_ID]),
            'result' => (object)[
                'Attendance' => [  
                   'AttendanceID' => 1,
                   'DayCount' => 10,
                   'IsActive' => 0,
                   'LastCheckDateTime' => '2017-12-09T02:53:55',
                   'LastDayNumber' => 1,
                   'pid' => PLAYER_ID
                ],
                'AttendanceList' => null,
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