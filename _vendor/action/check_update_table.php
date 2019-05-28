<?php
class check_update_table {
    function runAction($params) {
        global $config;
        $userData = UserModel::getWebuiInfo([PLAYER_ID])['webuiSecret'];
        $textString = file_get_contents($config->SAMPLE_FOlDER.'cms_TEXT_String.json');
        $textString = str_replace('{{PLAYER_ID}}', PLAYER_ID, $textString);
        $textString = str_replace('{{PLAYER_KEY}}', $userData, $textString);
        return (object)['TableList' => (object)[
            'cms_Achievement' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Achievement.json')),
            'cms_AchievementReward' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_AchievementReward.json')),
            'cms_AttendanceReward' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_AttendanceReward.json')),
            'cms_ConfigData' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_ConfigData.json')),
            'cms_Designation' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Designation.json')),
            'cms_Guide' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Guide.json')),
            'cms_Item' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Item.json')),
            'cms_KeynumLib' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_KeynumLib.json')),
            'cms_KeynumLib_Tutor' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_KeynumLib_Tutor.json')),
            'cms_LaneNoteType' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_LaneNoteType.json')),
            'cms_LoadingTip' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_LoadingTip.json')),
            'cms_MasterValue' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_MasterValue.json')),
            'cms_Mode_Chaotic' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Chaotic.json')),
            'cms_Mode_Chaotic_Group' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Chaotic_Group.json')),
            'cms_Mode_Chaotic_GroupList' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Chaotic_GroupList.json')),
            'cms_Mode_Chaotic_Mission' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Chaotic_Mission.json')),
            'cms_Mode_Episode' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Episode.json')),
            'cms_Mode_Episode_Char' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Episode_Char.json')),
            'cms_Mode_Standard' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Standard.json')),
            'cms_Mode_Standard_Group' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Standard_Group.json')),
            'cms_Mode_Standard_GroupList' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Standard_GroupList.json')),
            'cms_Mode_Story' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Mode_Story.json')),
            'cms_Music' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Music.json')),
            'cms_Music_Pattern' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Music_Pattern.json')),
            'cms_Notice' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Notice.json')),
            'cms_Quest' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Quest.json')),
            'cms_Shop_BuyGold' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Shop_BuyGold.json')),
            'cms_Shop_Package' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Shop_Package.json')),
            'cms_Shop_PackageDetail' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Shop_PackageDetail.json')),
            'cms_Support' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Support.json')),
            'cms_Support_Grade' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Support_Grade.json')),
            'cms_Support_StageSet' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Support_StageSet.json')),
            'cms_Support_Value' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Support_Value.json')),
            'cms_Table_Update' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Table_Update.json')),
            'cms_TEXT_String' => json_decode($textString),
            'cms_UI_String' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_UI_String.json')),
            'cms_Unlock_Condition' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_Unlock_Condition.json')),
            'cms_UserLevel' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_UserLevel.json')),
            'cms_WeeklyRankingReward' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_WeeklyRankingReward.json')),
            'cms_WeeklyRankingTier' => json_decode(file_get_contents($config->SAMPLE_FOlDER.'cms_WeeklyRankingTier.json')),
            'isUpdate' => true
        ]];
    }
}