<?php
class login {
    function runAction($params) {
        if (strlen(PLAYER_ID) >=16 && ($userData = UserModel::getDataByPlatform(['ACC', PLAYER_ID])) === false) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 5; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $playerId = UserModel::add(['ACC', PLAYER_ID, 'Player', 3, 3, NULL, 0, 0, 3, 0, 2, $randomString], true);
            UserStoryModel::addList($playerId, [
                [1, 1, false, true],
                [1, 2, false, true],
                [1, 3, false, true],
                [1, 4, false, false]
            ]);
            UserValueModel::addList($playerId, [
                ['ArcadeClear_Count', 0, NULL],
                ['BuyArcade_ByGold_Count', 1, NULL],
                ['Current_QuestID', 0, NULL],
                ['FingerTutor_Step', 5, NULL],
                ['FirstChapter_Order_No', 1, NULL],
                ['MusicGacha_Count', 0, NULL],
                ['Language', 0, 'JP']
            ]);
            UserItemModel::addList($playerId, [
                ['Ranking_Medal', 1],
                ['ResultSkin_Gold', 1],
                ['ResultSkin_Platinum', 1],
                ['ResultSkin_Start', 1],
                ['Story_Card_4', 1],
                ['GOLD', 99999999],
                ['StarCube', 99999],

            ]);
            UserFlagModel::addList($playerId, [
                ['isArcadeOpen', 0],
                ['isBaseIntroduced', 1],
                ['isCommunityOpen', 0],
                ['isGetSpiny', 0],
                ['isGetV', 0],
                ['isGuideStart', 1],
                ['isMenuOpen', 0],
                ['isMissionOpen', 0],
                ['isNotCali', 0],
                ['isNotFirstPlay', 1],
                ['isNoticeOpen', 0],
                ['isShopOpen', 0],
                ['isStoryOpen', 0]
            ]);
            UserSupportModel::addList($playerId, [
                ['ZCB01', 2, 1, 1, 1],
                ['ZCG01', 2, 1, 1, 1],
                ['ZCR01', 2, 1, 1, 1],
                ['ZCY01', 2, 1, 1, 1]
            ]);
        }
        return (object)[];
    }
}