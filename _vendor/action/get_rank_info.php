<?php
class get_rank_info {
    function runAction($params) {
        return (object)[
            'MyRank' => 1,
            'RankList' => []
        ];
    }
}