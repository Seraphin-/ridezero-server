<?php
class UserModel {
    static function getData($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, platform, loginId, name, clearStoryNo, isRating, language, musicByGoldCount, nameChangeCount, openStoryNo, supportByGoldCount, tutorialNo FROM users WHERE playerId = ?');
            $statement->execute($args);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            for ($i = 0; $i < count($resultList); $i++) {
                return self::toModel($resultList[$i]);
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    static function getWebuiInfo($args) {
        try {
            $statement = connectDB()->prepare('SELECT webuiSecret FROM users WHERE playerId = ?');
            $statement->execute($args);
            return $statement->fetch();
        } catch (\Exception $e) {
            return false;
        }
    }

    static function getDataByPlatform($args) {
        try {
            $statement = connectDB()->prepare('SELECT playerId, platform, loginId, name, clearStoryNo, isRating, language, musicByGoldCount, nameChangeCount, openStoryNo, supportByGoldCount, tutorialNo FROM users WHERE platform = ? AND loginId = ?');
            $statement->execute($args);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            $returnList = [];
            for ($i = 0; $i < count($resultList); $i++) {
                return self::toModel($resultList[$i], true);
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    static function update($args) {
        try {
            $argsList = [];
            for ($i = 1; $i < count($args); $i++) {
                array_push($argsList, $args[$i]);
                array_push($argsList, $args[$i]);
            }
            array_push($argsList, $args[0]);
            return connectDB()->prepare('UPDATE users SET platform = CASE WHEN ? IS NOT NULL THEN ? ELSE platform END, loginId = CASE WHEN ? IS NOT NULL THEN ? ELSE loginId END, name = CASE WHEN ? IS NOT NULL THEN ? ELSE name END, clearStoryNo = CASE WHEN ? IS NOT NULL THEN ? ELSE clearStoryNo END, isRating = CASE WHEN ? IS NOT NULL THEN ? ELSE isRating END, language = CASE WHEN ? IS NOT NULL THEN ? ELSE language END, musicByGoldCount = CASE WHEN ? IS NOT NULL THEN ? ELSE musicByGoldCount END, nameChangeCount = CASE WHEN ? IS NOT NULL THEN ? ELSE nameChangeCount END, openStoryNo = CASE WHEN ? IS NOT NULL THEN ? ELSE openStoryNo END, supportByGoldCount = CASE WHEN ? IS NOT NULL THEN ? ELSE supportByGoldCount END, tutorialNo = CASE WHEN ? IS NOT NULL THEN ? ELSE tutorialNo END, webuiSecret = CASE WHEN ? IS NOT NULL THEN ? ELSE webuiSecret END WHERE playerId = ?')->execute($argsList);
        } catch (\Exception $e) {
            return false;
        }
    }

    static function add($args) {
        try {
            $db = connectDB();
            $db->prepare('INSERT INTO users (platform, loginId, name, clearStoryNo, isRating, language, musicByGoldCount, nameChangeCount, openStoryNo, supportByGoldCount, tutorialNo, webuiSecret) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')->execute($args);
            $statement = $db->prepare('SELECT last_insert_rowid() AS playerId');
            $statement->execute([]);
            $resultList = $statement->fetchAll(PDO::FETCH_CLASS);
            return (int)$resultList[0]->playerId;
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object, $needPlayerId = false) {
        global $config;
        $totalAchievementScore = 0;
        $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Achievement.json'));
        for ($i = 0; $i < count($tableList); $i++) {
            $totalAchievementScore += $tableList[$i]->AchievementScore;
        }
        $maxUserLevel = 1;
        $maxExp = 0;
        $tableList = json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_UserLevel.json'));
        for ($i = 0; $i < count($tableList); $i++) {
            if ($tableList[$i]->Level  > $maxUserLevel) {
                $maxUserLevel = $tableList[$i]->Level;
            }
            if ($tableList[$i]->TotalNeedExp > $maxExp) {
                $maxExp = $tableList[$i]->TotalNeedExp;
            }
        }
        $goldCount = 0;
        if (DEFINED('PLAYER_ID') && ($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, 'GOLD']))) {
            $goldCount = $userItemData->Quantity;
        }
        $jewelCount = 0;
        if (DEFINED('PLAYER_ID') && ($userItemData = UserItemModel::getDataByInfo([PLAYER_ID, 'StarCube']))) {
            $jewelCount = $userItemData->Quantity;
        }
        $result = (object)[
            'AchievementScore' => $totalAchievementScore,
            'ClearStoryNo' => (int)$object->clearStoryNo,
            'CreateDate' => '2017-11-05T22:17:19',
            'exp' => $maxExp,
            'gold' => $goldCount,
            'IsRating' => (int)$object->isRating,
            'jewel' => $jewelCount,
            'Language' => $object->language,
            'LastActionDate' => '2017-11-17T02:47:09',
            'level' => $maxUserLevel,
            'MusicByGoldCount' => (int)$object->musicByGoldCount,
            'name' => $object->name,
            'NameChangeCount' => (int)$object->nameChangeCount,
            'NextResetDaily' => '2017-11-18T04:00:00',
            'NextResetMonthly' => '2017-12-01T04:00:00',
            'NextResetWeekly' => '2017-11-20T04:00:00',
            'OpenStoryNo' => (int)$object->openStoryNo,
            'SupportByGoldCount' => (int)$object->supportByGoldCount,
            'SupportByGoldTime' => '2017-11-17T03:28:09',
            'TutorialNo' => (int)$object->tutorialNo
        ];
        if ($needPlayerId) {
            $result->playerId = $object->playerId;
        }
        return $result;
    }
}