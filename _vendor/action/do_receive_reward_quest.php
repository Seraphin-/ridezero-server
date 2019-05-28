<?php
class do_receive_reward_quest {
    function runAction($params) {
        return (object)[
            'IsReceived' => true,
            'PlayerAchievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
            'PlayerItem' => UserItemModel::getListByUserId([PLAYER_ID]),
            'PlayerQuest' => UserQuestModel::getListByUserId([PLAYER_ID])
        ];
    }
}