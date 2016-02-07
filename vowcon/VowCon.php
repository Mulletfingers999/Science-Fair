<?php
/* VowCon.php
   Vowel/Consonant analysis, PHP4 and PHP5 compatible 

Author: Roger Baklund <roger@baklund.no> 
License: LGPL 
Version: 1.0 rb27122013

*/ 

class VowConAnalyzer extends VowConStats {
  function VowConAnalyzer($MaxAvgScore=2.5,$MaxWordScore=5.0,$MaxBadPercent=20.0,$BadWordLimit=3.5) {
    parent::VowConStats();
    $this->AddVowels('öÖäÄüÜéÉèÈôÔáÁ');  # diacritics
    $this->MaxAvgScore = $MaxAvgScore;
    $this->MaxWordScore = $MaxWordScore;
    $this->MaxBadPercent = $MaxBadPercent;
    $this->BadWordLimit = $BadWordLimit;
    $this->words = array();
    $this->consonants = array(); # for word splitting
  }
  function Split($text) {
    if(is_array($text)) 
      $words = array_filter($text);  # remove blanks
    else {
      preg_match_all('/[a-zA-Z'.
        implode('',$this->vowels).
        implode('',$this->consonants).']+/',$text,$m);
      $words = $m[0];
    }
    return $words;
  }
  function AddVowels($vowels) {
    if(is_string($vowels))
      $vowels = str_split($vowels);
    $this->vowels = array_merge($this->vowels,$vowels);
  }
  function AddConsonants($consonants) {
    if(is_string($consonants))
      $consonants = str_split($consonants);
    $this->consonants = array_merge($this->consonants,$consonants);
  }
  function LoadText($text) {
    $this->words = $this->Split($text);
    $this->ResetStats();
  }
  function AppendText($text) {
    $this->words = array_merge($this->words,$this->Split($text));
    $this->ResetStats();    
  }
  function ResetStats() {
    unset($this->TextStats);
  }
  function CalcTextStats() {
    $wordCount = 0;
    $maxScore = 0;
    $totScore = 0;
    $badCount = 0;  
    foreach($this->words as $word) {
      if(is_numeric($word)) continue;
      if(!trim($word)) continue;
      $score = $this->GetWordScore($word);
      $totScore+=$score;
      $wordCount++;
      if($score > $this->BadWordLimit) 
        $badCount++;
      if($score > $maxScore)
        $maxScore = $score;  
    }
    $this->TextStats = $wordCount ? (object) array(
        'MaxScore' => $maxScore,
        'AvgScore' => $totScore/$wordCount,
        'BadPercent' => ($badCount/$wordCount)*100) : false;
    return $this->TextStats;
  }  
  #
  function WordIsValid($word) {
    return ($this->GetWordScore($word) <= $this->BadWordLimit);
  }
  function GetWordScore($word) {
    if(is_numeric($word)) return 0;
    if(!trim($word)) return 0;
    $stats = $this->Stats($word);
    return $stats->score;
  }
  function GetWordStatus($word,$fmt='%.2f') {
    $score = $this->GetWordScore($word);
    $scoreStr = sprintf($fmt,$score);
    if($score > $this->MaxWordScore) 
      return 'Invalid: Above max word score ('.$scoreStr.' > '.
              sprintf($fmt,$this->MaxWordScore).')';
    elseif($score > $this->BadWordLimit) 
      return 'Invalid: Above bad word limit ('.$scoreStr.' > '.
              sprintf($fmt,$this->BadWordLimit).')';
    elseif($score > $this->MaxAvgScore) 
      return 'Maybe: Above max average score ('.$scoreStr.' > '.
              sprintf($fmt,$this->MaxAvgScore).')';
    else
      return 'Valid';
  } 
  function TextIsValid() {
    if(!isset($this->TextStats))
      $this->CalcTextStats();
    if(!$this->TextStats) return true; # empty input, not invalid
    if($this->TextStats->AvgScore > $this->MaxAvgScore)
      return false;
    if($this->TextStats->MaxScore > $this->MaxWordScore)
      return false;
    if($this->TextStats->BadPercent > $this->MaxBadPercent)
      return false;
    return true;
  }
  function GetTextStatus() {
    if(!isset($this->TextStats))
      $this->CalcTextStats();
    if(!$this->TextStats) return 'Empty';
    if($this->TextStats->AvgScore > $this->MaxAvgScore)
      return 'Invalid: Average score too high '.
        sprintf('(%.2f > %.2f)',
          $this->TextStats->AvgScore,$this->MaxAvgScore);
    if($this->TextStats->MaxScore > $this->MaxWordScore)
      return 'Invalid: Max score too high '.
        sprintf('(%.2f > %.2f)',
          $this->TextStats->MaxScore,$this->MaxWordScore);
    if($this->TextStats->BadPercent > $this->MaxBadPercent)
      return 'Invalid: Too many bad words '.
        sprintf('(%.2f%% > %.2f%%)',
          $this->TextStats->BadPercent,$this->MaxBadPercent);
    return 'Valid';  
  }  
}

class VowConStats {
  function VowConStats($vowels='aeiouy') {
    if(is_string($vowels))
      $vowels = str_split($vowels);
    $this->vowels = $vowels;
  }
  function Stats($word) {
    $was = false;
    $vow_count = 0;
    $con_count = 0;
    $vow_max = 0;
    $con_max = 0;
    $groupCount = 0;
    $groupSum = 0;
    $distinct = array();
    $groupSumSq = 0;
    for($i=0; $i < strlen($word); $i++) {
      $letter = strtolower($word[$i]);
      if(!in_array($letter,$distinct))
        $distinct[] = $letter;
      if(in_array($letter,$this->vowels)) {
        if($was == 'con') {
          if($con_count > $con_max)
            $con_max = $con_count;
          $groupCount++;
          $groupSum+=$con_count;
          $groupSumSq+=pow($con_count,2);
          $con_count = 0;
        }
        $vow_count++;
        $was = 'vow';
      } else {
        if($was == 'vow') {
          if($vow_count > $vow_max)
            $vow_max = $vow_count;
          $groupCount++;
          $groupSum+=$vow_count;
          $groupSumSq+=pow($vow_count,2);
          $vow_count = 0;
        }
        $con_count++;
        $was = 'con';
      }
    }
    # add final data:
    $groupCount++;
    if($was == 'vow') {
      if($vow_count > $vow_max)
        $vow_max = $vow_count;
      $groupSum+=$vow_count;
      $groupSumSq+=pow($vow_count,2);
    } else {
      if($con_count > $con_max)
        $con_max = $con_count;
      $groupSum+=$con_count;
      $groupSumSq+=pow($con_count,2);
    }
    $distinct = count($distinct);
    return (object) array(
      'word'=>$word,
      'groupCount'=>$groupCount,
      'groupSum' => $groupSum,
      'groupSumSq' => $groupSumSq,
      'groupMaxSize' => max($con_max,$vow_max),
      'con_max' => $con_max,
      'vow_max' => $vow_max,
      'distinct' => $distinct,
      'score' => $groupSumSq / strlen($word) + ((strlen($word) / $distinct) - 1)
    );
  }
}

?>