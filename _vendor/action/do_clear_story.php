<?php
class do_clear_story extends SubmitScoreBase {
    function runAction($params) {
        global $config;
        $userData = UserModel::getData([PLAYER_ID]);
        if (($userResultData = UserResultModel::getDataByInfo([PLAYER_ID, $params['result']['musicNo'], $params['result']['patternNo']]))) {
            $newScore = $params['result']['score'];
            if ($userResultData->score > $newScore) {
                $newScore = $userResultData->score;
                $params['result']['score'] = $userResultData->score;
                $params['result']['judgeTable'] = $userResultData->judgeTable;
            }
            if ($userResultData->maxCombo > $params['result']['maxCombo']) {
                $params['result']['maxCombo'] = $userResultData->maxCombo;
            }
            if ($userResultData->isCleared) {
                $params['result']['isCleared'] = $userResultData->isCleared;
            }
            if ($userResultData->rankIndex > $params['result']['rankIndex']) {
                $params['result']['rankIndex'] = $userResultData->rankIndex;
            }
            $params['result']['acquiredMedalIds'] = array_unique(array_merge($params['result']['acquiredMedalIds'], $userResultData->acquiredMedalIds));
            UserResultModel::update([PLAYER_ID, $params['result']['musicNo'], $params['result']['patternNo'], $newScore, serialize($params['result'])]);
        } else {
            UserResultModel::add([PLAYER_ID, $params['result']['musicNo'], $params['result']['patternNo'], $params['result']['score'], serialize($params['result'])]);
        }
        $newItemList = [];
        if ($params['result']['isCleared']) {
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Story.json'));
            $storyIdMatch = [];
            for ($i = 0; $i < count($tableList); $i++) {
                $storyIdMatch['musicId'.$tableList[$i]->MusicNo] = $tableList[$i]->StoryNo;
            }
            $currentStoryId = $storyIdMatch['musicId'.$params['result']['musicNo']];
            if (($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, 'Story_Card_'.$currentStoryId]))) {
                UserItemModel::update([PLAYER_ID, 'Story_Card_'.$currentStoryId, 0]);
                if ($currentStoryId + 1 <= 10) {
                    UserItemModel::add([PLAYER_ID, 'Story_Card_'.($currentStoryId + 1), 1]);
                }
            }
            if ($currentStoryId > $userData->ClearStoryNo) {
                UserStoryModel::update([PLAYER_ID, 1, $currentStoryId, false, true]);
                if ($currentStoryId < 10) {
                    UserStoryModel::add([PLAYER_ID, 1, $currentStoryId + 1, false, false]);
                }
                $openStoryId = ($currentStoryId + 1 > 10 ? 10 : $currentStoryId + 1);
                UserModel::update([PLAYER_ID, NULL, NULL, NULL, $currentStoryId, NULL, NULL, NULL, NULL, $openStoryId, NULL, NULL, NULL]);
                $userData->ClearStoryNo = $currentStoryId;
                $userData->OpenStoryNo = $openStoryId;
            }
            $newItemList = UserItemModel::judgeItem($params);
        }
        $newSupport = UserSupportModel::judgeSupporter();
        $userSupportData = UserSupportModel::getListByUserId([PLAYER_ID]);
        $userItemData = UserItemModel::getListByUserId([PLAYER_ID]);
        $result = (object)[
            'isGetSuppoterCard' => !!count($newSupport),
            'ItemList' => $userItemData,
            'PlayerAchievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
            'playerInfo' => $userData,
            'PlayerQuest' => UserQuestModel::getListByUserId([PLAYER_ID]),
            'ResponseData' => [
                'noticeMessage' => null,
                'player_Achievement' => null,
                'player_AchievementReward' => null,
                'player_ChaoticMission' => null,
                'player_ChaoticStage' => [],
                'player_Episode' => null,
                'player_Flag' => null,
                'player_Item' => [],
                'player_MailBox' => null,
                'player_MetaResult_SavePeople' => [],
                'player_Quest' => UserQuestModel::getListByUserId([PLAYER_ID]),
                'player_Statistics' => null,
                'player_Support' => null,
                'player_UserValue' => null,
                'playerData_ArcadeStage' => null,
                'playerData_Shop_Package' => null,
                'playerData_Story' => null,
                'playerInfo' => null
            ],
            'ResultRewards' => [
                'AchivementPointLp' => 0,
                'BasicRewards' => $this->newItemResult($newItemList),
                'DesigLp' => 0,
                'Lp' => 0,
                'StageClearLp' => 0,
                'SupporterLp' => 0,
                'SupporterLpDesigFactors' => null,
                'SupportRewards' => []
             ],
            'StageList' => UserArcadeStageModel::get(),
            'SupportList' => $userSupportData
        ];
        if (!!count($newSupport)) {
            $result->DoSupportGachaResult = [
                'isValidRequest' => true,
                'items' => $userItemData,
                'noticeMessages' => [],
                'playerInfo' => $userData,
                'resultSupporter' => $newSupport,
                'support' => $userSupportData
            ];
        }
        return $result;
    }
}