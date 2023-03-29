<?php


//sort the version numbers

//create an array to store the version numbers and their matching colors
$versionNumberColors = array();
if (count($versionNumbers) >1) {
    sort($versionNumbers);
    $numberOfVersions = count($versionNumbers);

//find the maximum and minimum version numbers
$maxVersionNumber = max($versionNumbers);
$minVersionNumber = min($versionNumbers);

//assign the maximum and minimum version numbers opposite colors in the color spectrum
$maxVersionNumberColor = "rgb(255,0,0)";
$minVersionNumberColor = "rgb(0,0,255)";



//assign the maximum and minimum version numbers to the array
$versionNumberColors[$maxVersionNumber] = $maxVersionNumberColor;
$versionNumberColors[$minVersionNumber] = $minVersionNumberColor;

//calculate the amount of hues to increment by so each version number is assigned a unique color
$hueIncrement = (255/($numberOfVersions-1));
$hueValue = 0;

//loop through the version numbers
for($i=1; $i<$numberOfVersions-1; $i++){
    
    //calculate the hue value for the color
    $hueValue += $hueIncrement;
    
    //assign the hue value to the version number
    $versionNumberColors[$versionNumbers[$i]] = "rgb(".$hueValue.",0,".(255-$hueValue).")";
    
}

//output the version number and their associated colors
ksort($versionNumberColors);
}elseif(count($versionNumbers) == 1){
    $versionNumberColors[$versionNumbers[0]] = "rgb(255,0,0)";

}




?>