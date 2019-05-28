<?php
class buy_arcade {
    function runAction($params) {
        $userQuestList = UserQuestModel::getListByUserId([PLAYER_ID]);
        return (object)[
            'buyArcadeResult' => (object) [
                'ArcadeStageNo' => $params['arcadeStageNo'],
                'isValidRequest' => true,
                'items' => UserItemModel::getListByUserId([PLAYER_ID]),
                'playerArcadeList' => UserArcadeStageModel::get(),
                'playerInfo' => UserModel::getData([PLAYER_ID]),
                'playerQuestList' => $userQuestList,
                'playerStoryList' => UserStoryModel::getListByUserId([PLAYER_ID]),
                'userValueList' => UserValueModel::getListByUserId([PLAYER_ID])
            ],
            'PlayerAchievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
            'PlayerQuest' => $userQuestList
        ];
    }
}