<?php

$i= 40.443504;
$j = -79.941571;
$t=1351897677;
for($x=0;$x<100;$x++){

  echo ($i + $x/10000).",".  ($j + $x/10000). ","."GHC ".(4000 + $x*35).",".($t + $x*60*60).",".($t + ($x+1)*60*60);
  echo "\n";
}
  
  ?>
