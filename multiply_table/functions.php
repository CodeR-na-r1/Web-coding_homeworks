<?php
  function create_table($height=10, $width=10) : array
  {
    $table = [];
    for ($i=0; $i <= $height; $i++) {
      $row = [];
      for ($j=0; $j <= $width; $j++) {
        if ($i==0 && $j==0)
        {
          $row[$j] =  '<td style="background: red;"> </td>';
        }
        else if (($i==0 && $j) || ($i && $j==0))
        {
          $row[$j] = '<td style="background: orange;">' . $i + $j . ' </td>';
        }
        else if ($i==$j)
        {
          $row[$j] = '<td class="diagonal">' . ($i * $j) . '</td>';
        }
        else
        {
          $row[$j] = '<td>' . ($i * $j) . '</td>';
        }
      }
      $table[$i]=$row;
    }

    return $table;
  }

  function Show_table($table, $height=10, $width=10)
  {
    echo '<table>';

    for ($i=0; $i <= $height; $i++)
    {
      echo '<tr>';
      for ($j=0; $j <= $width; $j++)
      {
        echo $table[$i][$j];
      }
      echo '</tr>';
    }

    echo '</table>';
  }
?>
