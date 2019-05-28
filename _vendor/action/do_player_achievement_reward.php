<?php
class do_player_achievement_reward {
    function runAction($params) {
        return (object)[
            'IsReceived' => true,
            'PlayerAchievement' => UserAchievementModel::getListByUserId([PLAYER_ID]),
            'PlayerAchievementReward' => UserAchievementRewardModel::getListByUserId([PLAYER_ID])
        ];
    }
}