<!DOCTYPE html>
<html>
<!--http://codewelt.com/project/speak/speak1454819021766.mp3-->
<!--Does experienced bulk since between Kerry?-->
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/master.css" media="screen" title="no title" charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="./sorttable/sort.js" charset="utf-8"></script>
    <title>Science Fair Project</title>
  </head>
  <body>
    <br>
    <h1 style="color: yellow;">Analyze Articles</h1>
    <hr>
    <table>
      <thead>
        <tr>
          <th>
            Pick a Pro-Global Warming Article
          </th>
          <th>

          </th>
          <th>
            Pick a Anti-Global Warming Article
          </th>
        </tr>
      </thead>
      <form name="form1" class="" action="index.php" method="post">
        <tbody>
          <tr>
            <td>
              <select class="" name="bad" id="bad">
                <option disabled selected> [select] </option>
                <option>"Hannity Report"</option>
                <option>"Global Warming: So Dishonest It Makes Enron Look Like a Paragon of Integrity."</option>
                <option>"New Reports: There Is No Global Warming."</option>
                <option>"A Skeptic Guide to An Inconvenient Truth"</option>
                <option>[ compare all ]</option>
              </select>
              <br>
            </td>
            <td>
              <input type="submit" name="submit1" value="[ submit ]" class="tiny">
            </td>
            <td>
              <select class="" name="good" id="good">
                <option disabled selected> [select] </option>
                <option>"The Physical Science Basis: Summary for Policymakers"</option>
                <option>"An Inconvenient Truth: The Planetary Emergency of Global Warming and What We Can Do About It."</option>
                <option>"Fingerprints of Global Warming on Wild Animals and Plants"</option>
                <option>"Rice yields decline with higher night temperature from global warming"</option>
                <option>[ compare all ]</option>
              </select>
            </td>
          </tr>
        </tbody>
      </form>
    </table>
    <div style="display:none;">
      <?php
        if ($_POST['submit1']) {
          $bad = $_POST['bad'];
          $good = $_POST['good'];
          $badtxt = '';
          $goodtxt = '';

          switch ($bad) {
            case '"Hannity Report"':
              $badtxt = file_get_contents('./arct-insane/arct-1.txt');
              break;

            case '"Global Warming: So Dishonest It Makes Enron Look Like a Paragon of Integrity."':
              $badtxt = file_get_contents('./arct-insane/arct-2.txt');
              break;

            case '"New Reports: There Is No Global Warming."':
              $badtxt = file_get_contents('./arct-insane/arct-3.txt');
              break;

            case '"A Skeptic Guide to An Inconvenient Truth"':
              $badtxt = file_get_contents('./arct-insane/arct-4.txt');
              break;

            case '[ compare all ]':
              $badtxt = file_get_contents('./arct-insane/arct-1.txt').file_get_contents('./arct-insane/arct-2.txt').file_get_contents('./arct-insane/arct-3.txt').file_get_contents('./arct-insane/arct-4.txt');
              break;

            default:
              # code...
              break;
          }

          switch ($good) {
            case '"The Physical Science Basis: Summary for Policymakers"':
              $goodtxt = file_get_contents('./arct-sane/arct-1.txt');
              break;

            case '"An Inconvenient Truth: The Planetary Emergency of Global Warming and What We Can Do About It."':
              $goodtxt = file_get_contents('./arct-sane/arct-2.txt');
              break;

            case '"Fingerprints of Global Warming on Wild Animals and Plants"':
              $goodtxt = file_get_contents('./arct-sane/arct-3.txt');
              break;

            case '"Rice yields decline with higher night temperature from global warming"':
              $goodtxt = file_get_contents('./arct-sane/arct-4.txt');
              break;

            case '[ compare all ]':
              $goodtxt = file_get_contents('./arct-sane/arct-1.txt').file_get_contents('./arct-sane/arct-2.txt').file_get_contents('./arct-sane/arct-3.txt').file_get_contents('./arct-sane/arct-4.txt');
              break;

            default:
              # code...
              break;
          }

          echo "<script>\$(document).ready(function() {\$('#res').attr('style', '')})</script>";
        }
      ?>

    </div>
    <br><hr><br>
    <div id="res" style="display:none;">
      <h2>Results:</h2>
      <p id="a1-txt">
        <span style='color:lime;vertical-align:top;'>Anti Article Text:</span>
        <?php
        if ($_POST['submit1'] && !empty($badtxt)) {
          echo "<textarea style='color:red;border:2px solid red;' readonly>$badtxt</textarea>";
        }
        ?>
      </p>
      <br><br>
      <p id="a2-txt">
        <span style='color:lime;vertical-align:top;'>Pro Article Text:</span>
        <?php
        if ($_POST['submit1'] && !empty($goodtxt)) {
          echo "<textarea style='color:lightblue;border:2px solid lightblue;' readonly>$goodtxt</textarea>";
        }
        ?>
      </p>
      <br><br><br>
      <strong style="color:lime;font-size:1.3em;">Most Common Words:</strong>
      <br>
      <div class="edge" style="display:none;">
        <strong tyle="color:lime;font-size:1em;">Key:</strong>
        <table>
          <tr>
            <th>
              Char
            </th>
            <th>
              Example
            </th>
            <th>
              Definition
            </th>
          </tr>
          <tr>
            <td>
              *number*.
            </td>
            <td>
              18.
            </td>
            <td>
              Number of occurances of this string in this text
            </td>
          </tr>
          <tr>
            <td>
              *num*.
            </td>
            <td>
              18.
            </td>
            <td>
              Number of occurances of this string in this text
            </td>
          </tr>
        </table>
      </div>
      <table id="indextable">
        <thead>
          <tr>
            <th>
              <a id="a1" href="javascript:SortTable('a1', 0,'N');">Anti-Words [only]</a>
            </th>
            <th>
              <a id="a2" href="javascript:SortTable('a2',1,'N');">Anti-Words [both]</a>
            </th>
            <th>
              <a id="a3" href="javascript:SortTable('a3',2,'N');">[both] Count</a>
            </th>
            <th>
              <a id="a4" href="javascript:SortTable('a4',3,'N');">Pro-Words [both]</a>
            </th>
            <th>
              <a id="a5" href="javascript:SortTable('a5',4,'N');">Pro-Words [only]</a>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
            $smptxt = strtolower(preg_replace("/[^a-zA-Z\s]/", " ", $badtxt.$goodtxt));
            $articles = array(" the ", " an ", " or ", " of ", " to ", " as ", " are ", " and ", " in ", " a ", " the ", " of ", " to ", " and ", " in ", " that ", " from ", " is ", " now ", " you ", " by ", " for ", " have ", " has ", " than ", " on ", " these ", " more ", " was ", " our ", " know ", " out ", " had ", " we ", " or ", " an ", " me ", " its ", " c ");
            $smptxt = str_ireplace($articles, " ", $smptxt);
            $cmnwords = array_count_values(explode(' ', $smptxt));
            arsort($cmnwords);
            $badtxt = strtolower($badtxt);
            $goodtxt = strtolower($goodtxt);

            require_once('./vowcon/VowCon.php');
            $v = new VowConAnalyzer();
            //echo 'res: '.$v->WordIsValid('bugler');

            foreach ($cmnwords as $key => $value) {
              if ($v->WordIsValid($key)) {
                $blank = 0;
                if (strlen($key) != 1 && strlen($key) != 0) {
                  $bgcolor = "white";
                  echo "<tr>";
                  if (strpos($badtxt, $key) && (strpos($badtxt, $key) && strpos($goodtxt, $key)) == false) {
                    $bgcolor = "red";
                    echo "<td style=\"color:$bgcolor;\">$key ~ $value</td>";
                  } else {
                    $blank++;
                  }

                  if (strpos($badtxt, $key) && strpos($goodtxt, $key)) {
                    for ($i=0;$i<$blank;$i++) {
                      echo "<td>-1</td/>";
                    }
                    $bgcolor = "orange";
                    $add = substr_count($badtxt, " ".$key." ")+substr_count($goodtxt, " ".$key." ");
                    echo "<td style=\"color:$bgcolor;\">$key ~ ".substr_count($badtxt, " ".$key." ")."</td>";
                    echo "<td style=\"color:yellow;\">$key ~ $add</td>";
                    echo "<td style=\"color:yellowgreen;\">$key ~ ".substr_count($goodtxt, " ".$key." ")."</td>";
                  } else {
                    $blank=$blank+3;
                  }

                  if (strpos($goodtxt, $key) && (strpos($badtxt, $key) && strpos($goodtxt, $key)) == false) {
                    for ($i=0;$i<$blank;$i++) {
                      echo "<td>-1</td/>";
                    }
                    $bgcolor = "green";
                    echo "<td style=\"color:$bgcolor;\">$key ~ $value</td>";
                  } else {
                    $blank++;
                    for ($i=0;$i<$blank;$i++) {
                      echo "<td>-1</td/>";
                    }
                  }

                  echo "</tr>";
                  //echo "<li value=\"$value\"><span style=\"color:$bgcolor;\">$key</span></li>";//"\n" . $value . " occurences of " . $key;
                }
              }
            }
          ?>
        </tbody>
      </table>
    </div>
    </body>
</html>
