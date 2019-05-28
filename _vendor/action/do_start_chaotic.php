<?php
class do_start_chaotic {
    function runAction($params) {
        $result = (object)[
            'ItemList' => UserItemModel::getListByUserId([PLAYER_ID])
        ];
        return $result;
    }
}