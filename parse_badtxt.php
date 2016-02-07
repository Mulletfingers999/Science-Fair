require_once('./vowcon/VowCon.php');
$v = new VowConAnalyzer();
//echo 'res: '.$v->WordIsValid('bugler');
$oldbgcolor="white";
foreach ($cmngoodwords as $key => $value) {
  if ($v->WordIsValid($key)) {
    if (strlen($key) != 1 && strlen($key) != 0) {
      /*$bgcolor = "white";
      echo "<tr>";
      if (strpos($badtxt, $key) && strpos($goodtxt, $key)) {
        $bgcolor = "yellow";
        echo "<td style=\"color:$bgcolor;\">$key -- $value</td>";
      } elseif (strpos($goodtxt, $key)) {
        $bgcolor = "lawngreen";
        echo "<td style=\"color:$bgcolor;\">$key -- $value</td>";
      } elseif (strpos($badtxt, $key)) {
        $bgcolor = "red";
        echo "<td style=\"color:$bgcolor;\">$key -- $value</td>";
      }
      $oldbgcolor = $bgcolor;
      echo "</tr>";*/
      //echo "<li value=\"$value\"><span style=\"color:$bgcolor;\">$key</span></li>";//"\n" . $value . " occurences of " . $key;
    }
  }
}
