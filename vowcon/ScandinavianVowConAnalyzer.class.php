<?php

require_once('VowCon.php');

class ScandinavianVowConAnalyzer extends VowConAnalyzer {
  function ScandinavianVowConAnalyzer($MaxAvgScore=2.5,$MaxWordScore=5.0,$MaxBadPercent=20.0,$BadWordLimit=3.5) {
    parent::VowConAnalyzer($MaxAvgScore,$MaxWordScore,$MaxBadPercent,$BadWordLimit);
    $this->AddVowels('זרוֶ״ֵ'); # norwegian/danish
  }
}

?>