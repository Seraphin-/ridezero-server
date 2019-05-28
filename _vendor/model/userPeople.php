<?php
class UserPeopleModel {
    static function getListByUserId($args) {
        try {
            return [];
        } catch (\Exception $e) {
            return false;
        }
    }

    static function toModel($object) {
        return (object)[
          'pid' => (int)$object->playerId,
          'ArcadeStageNo' => (int)$object->arcadeStageNo,
          'PackageMember' => (int)$object->packageMember,
          'support_Left' => $object->supportLeft,
          'support_Left_lv' => (int)$object->supportLeftLv,
          'support_LeftMid' =>  $object->supportLeftMid,
          'support_LeftMid_lv' => (int)$object->supportLeftMidLv,
          'support_RightMid' => $object->supportRightMid,
          'support_RightMid_lv' => (int)$object->supportRightMidLv,
          'support_Right' => $object->supportRight,
          'support_Right_lv' => (int)$object->supportRightLv,
          'SavePeopleCount' => (int)$object->savePeopleCount,
          'InsertDate' => '2017-11-05T22:43:30',
          'UpdateDate' => '0001-01-01T00:00:00'
        ];
    }
}