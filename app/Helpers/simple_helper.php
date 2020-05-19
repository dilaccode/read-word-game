<?php
/// add by Di Lac

/// type: Param=data1_data2_data3
function GETDataUrlToArray($Param){
    $ArrayResult = array();
    if(!empty($_GET[$Param])){
            $StrValue = $_GET[$Param];
            $ArrayResult = explode("_",$StrValue);
    }
    return $ArrayResult; 
}
/// result: array[0]_array[1]...
function ArrayToGETDataUrl($Param,$Array){
    $Value = count($Array)>0 ? implode("_",$Array) : "";
    return "$Param=$Value";
}

/// game zone === >>>
// return array objects (level map)
//  Index = level
//  Exp = amount level exp
//  TotalExp = total exp for complete this level
function GetGameLevels($TotalLevel = 0){
    $LEVEL_RATE = 300;
    $Levels = array();
    $TotalExp = 0;
    for($Level = 0; $Level <= $TotalLevel; $Level++){
        $LevelExp = $Level * $LEVEL_RATE;
        $TotalExp += $LevelExp;
        array_push($Levels, (object)array(
            "Exp" => $LevelExp,
            "TotalExp" => $TotalExp,
        ));
    }
    return $Levels;
}


