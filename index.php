<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/master.css" media="screen" title="no title" charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>Science Fair Project</title>
  </head>
  <body>
    <br>
    <h1>Analyze Articles</h1>
    <hr>
    <table>
      <thead>
        <tr>
          <th>
            Pick a Scientific Article
          </th>
          <th>

          </th>
          <th>
            Pick a Denying Article
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
        <span style='color:lime;'>Denying Article Text:</span>
        <?php
        if ($_POST['submit1'] && !empty($badtxt)) {
          echo "<span style='color:red;'>$badtxt</span>";
        }
        ?>
      </p>
      <br><br>
      <p id="a2-txt">
        <span style='color: lime;'>Scientific Article Text:</span>
        <?php
        if ($_POST['submit1'] && !empty($goodtxt)) {
          echo "<span style='color:lightblue;'>$goodtxt</span>";
        }
        ?>
      </p>
      <br><br><br>
      <strong style="color:lime;">Most Common Words:</strong>
      <ol>
        <?php
          #add the backend code here
        ?>
      </ol>
    </div>
    </body>
</html>
