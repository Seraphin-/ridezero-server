<?php
class UserSupportModel {
    static function getListByUserId($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, supportId, grade, level, quantity, nextRequireQuantity FROM users_supports WHERE playerId = ?');
            $statement->execute($args);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            $returnList = [];
            for ($i = 0; $i < count($resultList); $i++) {
                array_push($returnList, self::toModel($resultList[$i]));
            }
            return $returnList;
        } catch (\Exception $e) {
            return false;
        }
    }

    static function getDataByInfo($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, supportId, grade, level, quantity, nextRequireQuantity FROM users_supports WHERE playerId = ? AND supportId = ?');
            $statement->execute($args);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            $returnList = [];
            for ($i = 0; $i < count($resultList); $i++) {
                return self::toModel($resultList[$i]);
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    } 

    static function addList($playerId, $list) {
        $args = [];
        for ($i = 0; $i < count($list); $i++) {
            array_unshift($list[$i], $playerId);
            self::add($list[$i]);
        }
        return true;
    }

    static function add($args) {
        try {
            return connectDB()->prepare('INSERT INTO users_supports (playerId, supportId, grade, level, quantity, nextRequireQuantity) VALUES ('.substr(str_repeat(', ?', count($args)), 2).')')->execute($args);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function gemLevelUp($userSupportData, $eatList) {
        global $config;
        $addExp = 0;
        $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Support_Grade.json'));
        for ($i = 0; $i < count($eatList); $i++) {
            if (($eatSupportData = UserSupportModel::getDataByInfo([PLAYER_ID, $eatList[$i]['supportID']]))) {
                for ($j = 0; $j < count($tableList); $j++) {
                    if ($tableList[$j]->Grade === $eatSupportData->Grade && $tableList[$j]->Level === $eatSupportData->Level) {
                        $addExp += $tableList[$j]->CardExp * $eatList[$i]['count'];
                        break;
                    }
                }
                $lastCount = $eatSupportData->Quantity - $eatList[$i]['count'];
                self::update([PLAYER_ID, $eatSupportData->SupportID, $eatSupportData->Grade, $eatSupportData->Level, $lastCount < 0 ? 0 : $lastCount, $eatSupportData->NextRequireQuantity]);
            }
        }
        $levelNeedExpList = [];
        for ($i = 0; $i < count($tableList); $i++) {
            if ($tableList[$i]->Grade === $userSupportData->Grade) {
                $levelNeedExpList[$tableList[$i]->Level] = $tableList[$i]->NeedGemExp;
            }
        }
        if (count($levelNeedExpList) > $userSupportData->Level) {
            $userSupportData->Quantity += $addExp;
            for ($i = $userSupportData->Level; $i < count($levelNeedExpList); $i++) {
                if ($userSupportData->Quantity > $levelNeedExpList[$i]) {
                    $userSupportData->Quantity -= $levelNeedExpList[$i];
                    $userSupportData->Level = $i + 1;
                    if ($userSupportData->Level >= 13) {
                        $userSupportData->Level = 1;
                        $userSupportData->Grade++;
                        if ($userSupportData->Grade > 5) {
                            $userSupportData->Grade = 5;
                            $userSupportData->Level = 12;
                            $userSupportData->Quantity = $levelNeedExpList[count($levelNeedExpList) - 1];
                        }
                    }
                }
            }
            self::update([PLAYER_ID, $userSupportData->SupportID, $userSupportData->Grade, $userSupportData->Level, $userSupportData->Quantity, $userSupportData->NextRequireQuantity]);
        }
    }

    static function levelUp($userSupportData, $minusCount) {
        $lastCount = $userSupportData->Quantity - $minusCount;
        $lastLevel = $userSupportData->Level + 1;
        self::update([PLAYER_ID, $userSupportData->SupportID, $userSupportData->Grade, $lastLevel > 12 ? 12 : $lastLevel, $lastCount < 0 ? 0 : $lastCount, $userSupportData->NextRequireQuantity]);
    }

    static function judgeSupporter($mustNeedCount = 0, $minLevel = 0, $maxLevel = 0) {
        global $config;
        $newSupport = [];
        if ($mustNeedCount > 0 || !!(rand(0, 100) > $config->ITEM->SUPPORT_RATIO)) {
            $supportList = [];
            $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Support.json'));
            for ($i = 0; $i < count($tableList); $i++) {
                if ($minLevel === 0 || ($tableList[$i]->Grade - 1 >= $minLevel && $tableList[$i]->Grade - 1 <= $maxLevel)) {
                    if (!in_array($tableList[$i]->SupportID, ['ZCB01', 'ZCG01', 'ZCR01', 'ZCY01'])) {
                        array_push($supportList, $tableList[$i]);
                    }
                }
            }
            if ($mustNeedCount === 0) {
                $mustNeedCount = 1;
            }
            for ($i = 0; $i < $mustNeedCount; $i++) {
                $randomIndex = rand(0, count($supportList) - 1);
                if (count($supportList) > 0 && isset($supportList[$randomIndex]) && $supportList[$randomIndex] !== NULL) {
                    array_push($newSupport, $supportList[$randomIndex]);
                    if (($userSupportData = self::getDataByInfo([PLAYER_ID, $supportList[$randomIndex]->SupportID]))) {
                        self::update([PLAYER_ID, $userSupportData->SupportID, $userSupportData->Grade, $userSupportData->Level, $userSupportData->Quantity + 1, $userSupportData->NextRequireQuantity]);
                    } else {
                        self::add([PLAYER_ID, $supportList[$randomIndex]->SupportID, $supportList[$randomIndex]->Grade, 1, 1, 1]);
                    }
                }
            }
            return $newSupport;
        }
        return [];
    }

    static function update($args) {
        try {
            return connectDB()->prepare('UPDATE users_supports SET grade = ?, level = ?, quantity = ?, nextRequireQuantity = ? WHERE playerId = ? AND supportId = ?')->execute([$args[2], $args[3], $args[4], $args[5], $args[0], $args[1]]);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
            'pid' => (int)$object->playerId,
            'SupportID' => $object->supportId,
            'Grade' => (int)$object->grade,
            'Level' => (int)$object->level,
            'Quantity' => (int)$object->quantity,
            'NextRequireQuantity' => (int)$object->nextRequireQuantity,
            'InsertDate' => '2017-11-05T22:46:08',
            'UpdateDate' => '0001-01-01T00:00:00',
            'LastUseDate' => '0001-01-01T00:00:00'
        ];
    }
}