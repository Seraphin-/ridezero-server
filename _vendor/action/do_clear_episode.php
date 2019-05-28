<?php
class do_clear_episode extends SubmitScoreBase {
    function runAction($params) {
        global $config;
        $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Episode_Char.json'));
        $charCodeList = [];
        for ($i = 0; $i < count($tableList); $i++) {
            array_push($charCodeList, $tableList[$i]->CharCode);
        }
        $newItemList = [];
        if (in_array($params['charCode'], $charCodeList)) {
            if ($params['stageNo'] === 1) {
                UserEpisodeModel::add([PLAYER_ID, $params['charCode'], 1]);
            } else {
                UserEpisodeModel::update([PLAYER_ID, $params['charCode'], $params['stageNo']]);
            }
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Episode.json'));
            $episodeItemList = [];
            for ($i = 0; $i < count($tableList); $i++) {
                if ($params['charCode'] !== $tableList[$i]->CharCode) {
                    continue;
                }
                $episodeItemList[$tableList[$i]->StageNo - 1] = [$tableList[$i]->RewardItemCode, $tableList[$i]->RewardItemCount];
            }
            $newItemData = $episodeItemList[$params['stageNo'] - 1];
            array_unshift($newItemData, PLAYER_ID);
            if (($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, $newItemData[1]]))) {
                UserItemModel::update([PLAYER_ID, $newItemData[1], $userItemData->Quantity + $newItemData[2]]);
            } else {
                UserItemModel::add($newItemData);
            }
            array_push($newItemList, UserItemModel::toModel((object)[
                'playerId' => PLAYER_ID,
                'itemCode' => $newItemData[1],
                'quantity' => 0
            ]));
        }
        return (object)[
            'ItemList' => UserItemModel::getListByUserId([PLAYER_ID]),
            'Player_Episode' => UserEpisodeModel::getListByUserId([PLAYER_ID]),
            'PlayerAchievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
            'PlayerInfo' => UserModel::getData([PLAYER_ID]),
            'PlayerQuest' => UserQuestModel::getListByUserId([PLAYER_ID]),
            'ResponseData' => [  
                'noticeMessage' => null,
                'player_Achievement' => null,
                'player_AchievementReward' => null,
                'player_ChaoticMission' => null,
                'player_ChaoticStage' => [],
                'player_Episode' => null,
                'player_Flag' => null,
                'player_Item' => $newItemList,
                'player_MailBox' => null,
                'player_MetaResult_SavePeople' => null,
                'player_Quest' => null,
                'player_Statistics' => null,
                'player_Support' => null,
                'player_UserValue' => null,
                'playerData_ArcadeStage' => null,
                'playerData_Shop_Package' => null,
                'playerData_Story' => null,
                'playerInfo' => null
             ]
        ];
    }
}