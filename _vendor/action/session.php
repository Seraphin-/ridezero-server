<?php
class session {
    function runAction($params) {
        return (object)[
           'success' => true,
           'title' => 'SYSTEM_SESSION',
           'reason' => 'SYSTEM_DISABLE_SESSION'
        ];
    }
}