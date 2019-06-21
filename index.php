<?php
$number_of_rolls=750;

if(isset($_GET["sides"]) && isset($_GET["advantage"]) && isset($_GET["how_many"]) && is_numeric($_GET["sides"]) && is_numeric($_GET["advantage"]) && is_numeric($_GET["how_many"])){
    $sides = $_GET["sides"];
    $advantage = $_GET["advantage"];
    $how_many = $_GET["how_many"];
}else{
    $sides = 6;
    $advantage = 0;
    $how_many = 25;
}


echo '<table border="1" style="float: left;"><tr><th colspan="2">Rolls</th></tr><tr><th>Roll Number</th><th>Roll Value</th></tr>';
for($i=1;$i<=$how_many;$i++){
    $value=roll2($sides,$advantage);
    $rolls[$value]++;
    echo "<tr><td>$i</td><td>$value</td></tr>";

}
ksort($rolls);

echo '</table><table border="1" style="float: left; margin-left:25px;"><tr><th colspan="4">Stats</th></tr><tr><th>Number</th><th>Count of Rolls</th><th>Percentage</th><th>Difference from Fair ('.round((1/$sides)*100,1).'%)</th></tr>';
foreach ($rolls as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td><td>". round(($value*100)/$how_many,1)."%</td><td>". round((($value*100)/$how_many)-((1/$sides)*100),1)."%</td></tr>";
}
echo '</table>';

/*for($i=0;$i<$number_of_rolls;$i++){
    $value=roll();
    $normal[$value]++;
}
ksort($normal);

for($i=0;$i<$number_of_rolls;$i++){
    $value=roll(6,5);
    $crooked[$value]++;
}
ksort($crooked);


echo '<table border="1">';
foreach ($normal as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td><td>". round(($value*100)/$number_of_rolls,1)."%</td></tr>";
}
echo '</table><hr>';


echo '<table border="1">';
foreach ($crooked as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td><td>". round(($value*100)/$number_of_rolls,1)."%</td></tr>";
}
echo '</table>';
*/



    function roll($sides=6,$favor_high=0){ 
        $max_rand=10000;
  
        $random = random_int (1,$max_rand);
        $normal_dice_percent=(100-$favor_high)/$sides;
        $width_of_normal_dice=($normal_dice_percent*$max_rand)/100;
        $width_of_normal_dice_counter=$width_of_normal_dice;

        for($j=1;$j<=$sides;$j++){
            if($random<$width_of_normal_dice_counter){
                return($j);
            }else{
                $width_of_normal_dice_counter+=$width_of_normal_dice;
            }
        }
        return($sides);
    }



    function roll2($sides=6,$favor_high=0){ 
        $chance_normal = 100/$sides;
        $chance_normal_parition=(($sides-1)*$chance_normal)*1000;
        $chance_crooked_partition=($chance_normal+$favor_high)*1000;
        $random = random_int (1,$chance_normal_parition+$chance_crooked_partition);
        if($random<=$chance_normal_parition){
            return(random_int(1,$sides-1));
        }else{
            return($sides);
        }
    }


?>