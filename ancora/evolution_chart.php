<?php 
$addListSigner1 = (object) null;
$addListSigner1->{"01-2022"} = array(
    "cdi" => 1500,
    "law_smart" => 1600
);
$addListSigner1->{"02-2022"} = array(
    "cdi" => 1500,
    "law_smart" => 1600
);
// $addListSigner1->cdi = (object) array(
//     "01-2022" => 1500,
//     "02-2022" => 1600,
//     "03-2022" => 1700,
//     "04-2022" => 1800,
//     "05-2022" => 1900
// );
// $addListSigner1->law_smart = (object) array(
//     "01-2022" => 2500,
//     "02-2022" => 2600,
//     "03-2022" => 2700,
//     "04-2022" => 2800,
//     "05-2022" => 2900
// );
$addListBody = json_encode($addListSigner1, JSON_UNESCAPED_SLASHES);
echo $addListBody;

?>