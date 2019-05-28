<?php
class get_weekly_ranking {
    function runAction($params) {
        $pRank = [
            'EndUtcTime' => '2099-01-01T00:00:00Z',
            'Percentage' => '1.0',
            'Ranking' => '1',
            'Score' => '1'
        ];
        return (object)[
            'PlayerRanking' => $pRank
        ];
    }
}