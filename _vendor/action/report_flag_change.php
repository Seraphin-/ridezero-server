<?php
class report_flag_change {
    function runAction($params) {
        UserFlagModel::update([PLAYER_ID, $params['flagKey'], $params['flagValue']]);
        return (object)[];
    }
}