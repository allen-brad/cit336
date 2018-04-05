<?php

/* 
 * created by Brad R. Allen
 */
function averageStarRating($reviews){
  If(isset($reviews)){
//    $totalStars = 0;
//    foreach ($reviews as $review) {
//      $totalStars += $review['reviewRating'];
//    }
//$averageStars = $totalStars/count($reviews);

    $totalStars = $reviews;
    $whole = floor($totalStars);
    $fraction = $totalStars - $whole;
    $starRating = "";
    $half = FALSE;
    for($i=0;$i<5; $i++ ){
      if($i<=$totalStars-1){
        $starRating .= '<span class="star-icon full">☆</span>';
      } else {
        if($fraction >=.5 & $half ==FALSE){
          $starRating .= '<span class="star-icon half">☆</span>';
          $half = TRUE;
        } else {
          $starRating .= '<span class="star-icon">☆</span>';
        }
      }
    }
  return $starRating;
  }
}

$n = 4.25;
$whole = floor($n);      // whole number
$fraction = $n - $whole; // fraction
echo $n ."<br>";
echo $whole ."<br>";
echo $fraction ."<br>";

$starRating = averageStarRating(3.5);
echo $starRating;