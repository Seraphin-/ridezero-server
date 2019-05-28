<?php
class check_user_name_and_change_if_free {
    function runAction($params) {
        $userData = UserModel::getData([PLAYER_ID]);
        $userData->NameChangeCount++;
        $userData->name = $params['name'];
        UserModel::update([PLAYER_ID, NULL, NULL, $userData->name, NULL, NULL, NULL, NULL, $userData->NameChangeCount, NULL, NULL, NULL, NULL]);
        return (object)[
            'playerInfo' => $userData,
            'userNameCheckReturn' => 0 //exists = 7
        ];
    }
}