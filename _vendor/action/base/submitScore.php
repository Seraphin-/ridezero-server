<?php
class SubmitScoreBase {
    function newItemResult($inputModelList) {
        $resultList = [];
        for ($i = 0; $i < count($inputModelList); $i++) {
            array_push($resultList, [
                'ItemCode' => $inputModelList[$i][1],
                'ItemCount' => $inputModelList[$i][2]
            ]);
        }
        return $resultList;
    }
}