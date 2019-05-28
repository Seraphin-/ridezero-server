<?php
class get_user_item_shop_info {
    function runAction($params) {
        return (object)[
            'responseData' => [
                'noticeMessage' => null,
                'player_Achievement' => null,
                'player_AchievementReward' => null,
                'player_ChaoticMission' => null,
                'player_ChaoticStage' => null,
                'player_Episode' => null,
                'player_Flag' => null,
                'player_Item' => UserItemModel::getListByUserId([PLAYER_ID]),
                'player_MailBox' => null,
                'player_MetaResult_SavePeople' => null,
                'player_Quest' => null,
                'player_Statistics' => null,
                'player_Support' => UserSupportModel::getListByUserId([PLAYER_ID]),
                'player_UserValue' => null,
                'playerData_ArcadeStage' => null,
                'playerData_Shop_Package' => [],
                'playerData_Story' => null,
                'playerInfo' => null
            ]
        ];
    }
}