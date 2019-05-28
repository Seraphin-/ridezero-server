<?php
class get_user_status_info {
    function runAction($params) {
        return (object)[
            'responseData' => [
                'noticeMessage' => [],
                'player_Achievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
                'player_AchievementReward' => UserAchievementRewardModel::getListByUserId([PLAYER_ID]),
                'player_ChaoticMission' => UserMissionModel::getListByUserId([PLAYER_ID]),
                'player_ChaoticStage' => UserChaoticStageModel::get([PLAYER_ID]),
                'player_Episode' => UserEpisodeModel::getListByUserId([PLAYER_ID]),
                'player_Flag' => UserFlagModel::getListByUserId([PLAYER_ID]),
                'player_Item' => UserItemModel::getListByUserId([PLAYER_ID]),
                'player_MailBox' => [],
                'player_MetaResult_SavePeople' => UserPeopleModel::getListByUserId([PLAYER_ID]),
                'player_Quest' => UserQuestModel::getListByUserId([PLAYER_ID]),
                'player_Statistics' => UserStatisticsModel::getListByUserId([PLAYER_ID]),
                'player_Support' => UserSupportModel::getListByUserId([PLAYER_ID]),
                'player_UserValue' => UserValueModel::getListByUserId([PLAYER_ID]),
                'playerData_ArcadeStage' => UserArcadeStageModel::get(),
                'playerData_Shop_Package' => [],
                'playerData_Story' => UserStoryModel::getListByUserId([PLAYER_ID]),
                'playerInfo' => UserModel::getData([PLAYER_ID])
            ]
        ];
    }
}