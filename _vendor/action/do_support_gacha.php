<?php
class do_support_gacha {
    function runAction($params) {
        $supportCount = 0;
        $supportMinLevel = 0;
        $supportMaxLevel = 0;
        if ($params['gachaWay'] === 'GOLD') {
            $userData = UserModel::getData([PLAYER_ID]);
            $needGoldList = [500, 1000, 2000, 3000, 5000, 10000, 20000, 30000, 50000];
            $supportCount = 1;
            $supportMinLevel = 1;
            $supportMaxLevel = 3;
            $needItemData = ['GOLD', $userData->SupportByGoldCount > 8 ? $needGoldList[count($needGoldList) - 1] : $needGoldList[$userData->SupportByGoldCount]];
            $userData = UserModel::getData([PLAYER_ID]);
            $userData->SupportByGoldCount++;
            UserModel::update([PLAYER_ID, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $userData->SupportByGoldCount, NULL, NULL]);
        } else if ($params['gachaWay'] === 'STARCUBE_ONE') {
            $supportCount = 1;
            $supportMinLevel = 2;
            $supportMaxLevel = 4;
            $needItemData = ['StarCube', 20];
            if (($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, 'Support_Ticket'])) && $userItemData->Quantity > 0) {
                $needItemData = ['Support_Ticket', 1];
            }
            
        } else if ($params['gachaWay'] === 'STARCUBE_TEN') {
            $supportCount = 11;
            $supportMinLevel = 2;
            $supportMaxLevel = 4;
            $needItemData = ['StarCube', 200];
        }
        if (($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, $needItemData[0]]))) {
            $lastCount = $userItemData->Quantity - $needItemData[1];
            UserItemModel::update([PLAYER_ID, $needItemData[0], $lastCount < 0 ? 0 : $lastCount]);
        }
        $newSupport = UserSupportModel::judgeSupporter($supportCount, $supportMinLevel, $supportMaxLevel);
        return (object)[
            'DoSupportGachaResult' => [
                'isValidRequest' => true,
                'items' => UserItemModel::getListByUserId([PLAYER_ID]),
                'noticeMessages' => [],
                'playerInfo' => UserModel::getData([PLAYER_ID]),
                'resultSupporter' => $newSupport,
                'support' => UserSupportModel::getListByUserId([PLAYER_ID])
            ],
            'PlayerAchievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
            'PlayerQuest' => UserQuestModel::getListByUserId([PLAYER_ID])
        ];
    }
}