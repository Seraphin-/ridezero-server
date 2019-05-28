<?php
class do_start_episode {
    function runAction($params) {
        global $config;
        $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Episode_Char.json'));
        $charCodeList = [];
        for ($i = 0; $i < count($tableList); $i++) {
            array_push($charCodeList, $tableList[$i]->CharCode);
        }
        if (in_array($params['charCode'], $charCodeList)) {
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Episode.json'));
            $episodeItemList = [];
            for ($i = 0; $i < count($tableList); $i++) {
                if ($params['charCode'] !== $tableList[$i]->CharCode) {
                    continue;
                }
                $newItem = [['GOLD', $tableList[$i]->NeedGold]];
                if ($tableList[$i]->NeedItemCode1 !== '') {
                    array_push($newItem, [$tableList[$i]->NeedItemCode1, $tableList[$i]->NeedItemCount1]);
                }
                if ($tableList[$i]->NeedItemCode2 !== '') {
                    array_push($newItem, [$tableList[$i]->NeedItemCode2, $tableList[$i]->NeedItemCount2]);
                }
                $episodeItemList[$tableList[$i]->StageNo - 1] = $newItem;
            }
            $needItemList = $episodeItemList[$params['stageNo'] - 1];
            for ($i = 0; $i < count($needItemList); $i++) {
                if (($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, $needItemList[$i][0]]))) {
                    $lastCount = $userItemData->Quantity - $needItemList[$i][1];
                    UserItemModel::update([PLAYER_ID, $needItemList[$i][0], $lastCount < 0 ? 0 : $lastCount]);
                }
            }
        }
        return (object)[
            'ItemList' => UserItemModel::getListByUserId([PLAYER_ID]),
            'PlayerInfo' => UserModel::getData([PLAYER_ID])
        ];
    }
}