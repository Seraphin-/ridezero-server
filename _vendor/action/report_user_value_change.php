<?php
class report_user_value_change {
    function runAction($params) {
        UserValueModel::update([PLAYER_ID, $params['valueKey'], $params['intValue'], $params['isString'] === 1 ? $params['strValue'] : NULL]);
        return (object)[];
    }
}