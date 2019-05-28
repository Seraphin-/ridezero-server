<?php
class do_gemsupporter_levelup {
    function runAction($params) {
        if (($userSupportData = UserSupportModel::getDataByInfo([PLAYER_ID, $params['supportID']]))) {
            userSupportModel::gemLevelUp($userSupportData, $params['materialList']);
        }
        return (object)[
            'SupportList' => UserSupportModel::getListByUserId([PLAYER_ID])
        ];
    }
}