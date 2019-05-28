<?php
class do_clear_chaotic extends SubmitScoreBase {
    function runAction($params) {
        global $config;
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
            $newItemList = UserItemModel::judgeItem($params);
        }
        return (object)[
            'ItemList' => UserItemModel::getListByUserId([PLAYER_ID]),
            'MissionList' => UserMissionModel::getListByUserId([PLAYER_ID]),
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
                'player_Item' => [],
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
        ];
    }
}