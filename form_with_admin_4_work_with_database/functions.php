<?php

function __clear($value='')
{
   return htmlspecialchars($value);
 }

function detect_index($find_value, $cont) : int
 {
   $counter = 0;
  foreach ($cont as $key => $value) {
    if (strcmp($find_value, $value) == 0)
    {
      break;
    }
    else {
      $counter += 1;
    }
  }

  return $counter;
 }

 ?>
