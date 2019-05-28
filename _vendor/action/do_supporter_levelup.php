<?php
class do_supporter_levelup {
    function runAction($params) {
        global $config;
        if (($userSupportData = UserSupportModel::getDataByInfo([PLAYER_ID, $params['supportID']]))) {
            $needItemList = [];
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Support_Grade.json'));
            $minusCount = 0;
            for ($i = 0; $i < count($tableList); $i++) {
                if ($tableList[$i]->Grade === $userSupportData->Grade && $tableList[$i]->Level === $userSupportData->Level) {
                    $minusCount = $tableList[$i]->NeedCardCount;
                    if ($tableList[$i]->NeedGold !== 0) {
                        array_push($needItemList, ['GOLD', $tableList[$i]->NeedGold]);
                    }
                    if ($tableList[$i]->NeedItemCode1 !== '' && $tableList[$i]->NeedItemCount1 !== 0) {
                        array_push($needItemList, [$tableList[$i]->NeedItemCode1, $tableList[$i]->NeedItemCount1]);
                    }
                    if ($tableList[$i]->NeedItemCode2 !== '' && $tableList[$i]->NeedItemCount2 !== 0) {
                        array_push($needItemList, [$tableList[$i]->NeedItemCode2, $tableList[$i]->NeedItemCount2]);
                    }
                    break;
                }
            }
            for ($i = 0; $i < count($needItemList); $i++) {
                if (($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, $needItemList[$i][0]]))) {
                    $lastCount = $userItemData->Quantity - $needItemList[$i][1];
                    UserItemModel::update([PLAYER_ID, $needItemList[$i][0], $lastCount < 0 ? 0 : $lastCount]);
                }
            }
            UserSupportModel::levelUp($userSupportData, $minusCount);
        }
        $userQuestData = UserQuestModel::getListByUserId([PLAYER_ID]);
        return (object)[
            'ItemList' => UserItemModel::getListByUserId([PLAYER_ID]),
            'player_info' => UserModel::getData([PLAYER_ID]),
            'PlayerQuest' => $userQuestData,
            'SupportList' => UserSupportModel::getListByUserId([PLAYER_ID]),
            'UserStatusDataInfo' => [
                'ChaoticMission' => UserMissionModel::getListByUserId([PLAYER_ID]),
                'noticeMessages' => [],
                'Player_Achievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
                'Player_AchievementReward' => UserAchievementRewardModel::getListByUserId([PLAYER_ID]),
                'Player_Episode' => UserEpisodeModel::getListByUserId([PLAYER_ID]),
                'Player_MetaResult_SavePeople' => UserPeopleModel::getListByUserId([PLAYER_ID]),
                'Player_Quest' => $userQuestData,
                'Player_Statistics' => UserStatisticsModel::getListByUserId([PLAYER_ID]),
                'playerArcadeList' => UserArcadeStageModel::get(),
                'playerStoryList' => UserStoryModel::getListByUserId([PLAYER_ID]),
                'userFlagList' => UserFlagModel::getListByUserId([PLAYER_ID]),
                'userValueList' => UserValueModel::getListByUserId([PLAYER_ID])
            ]
        ];
    }
}