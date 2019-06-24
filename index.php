<?php
    //validate that items from the URL are set and numeric
    if (isset($_GET["sides"]) && isset($_GET["advantage"]) && isset($_GET["how_many"]) && is_numeric($_GET["sides"]) && is_numeric($_GET["advantage"]) && is_numeric($_GET["how_many"])) {
        $sides     = $_GET["sides"];
        $advantage = $_GET["advantage"];
        $how_many  = $_GET["how_many"];
    } else {//if items aren't valid, use some defaults.
        $sides     = 6;
        $advantage = 0;
        $how_many  = 25;
    }

    //build a table showing the rolls requested
    echo '<table border="1" style="float: left;"><tr><th colspan="2">Rolls</th></tr><tr><th>Roll Number</th><th>Roll Value</th></tr>';
    for ($i = 1; $i <= $how_many; $i++) {
        $value = roll($sides, $advantage); // do the actual roll
        $rolls[$value]++; //record the roll for stats 
        echo "<tr><td>$i</td><td>$value</td></tr>";
    }
    echo '</table>';

    ksort($rolls);//sort our stats.

    // build the stats table
    echo '<table border="1" style="float: left; margin-left:25px;"><tr><th colspan="4">Stats</th></tr><tr><th>Number</th><th>Count of Rolls</th><th>Percentage</th><th>Difference from Fair (' . round((1 / $sides) * 100, 1) . '%)</th></tr>';
    foreach ($rolls as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td><td>" . round(($value * 100) / $how_many, 1) . "%</td><td>" . round((($value * 100) / $how_many) - ((1 / $sides) * 100), 1) . "%</td></tr>";
    }
    echo '</table>';

    //roll a fair or unfair n-sided die. only the probablity of the highest number on the dice can be played with (ie 6 on a d6 or 20 on a d20)
    function roll($sides = 6, $favor_high = 0) {
        $chance_normal            = 100 / $sides;
        $chance_normal_parition   = (($sides - 1) * $chance_normal) * 1000;
        $chance_crooked_partition = ($chance_normal + $favor_high) * 1000;
        $random                   = best_rand(1, $chance_normal_parition + $chance_crooked_partition);
        if ($random <= $chance_normal_parition) {
            return (best_rand(1, $sides - 1));
        } else {
            return ($sides);
        }
    }

    function best_rand($low,$high){ // if random_int isn't available fall back to the older mt_rand
        if(function_exists(random_int)){
            return(random_int($low,$high));
        }else{
            return(mt_rand($low,$high));
        }
    }
?>