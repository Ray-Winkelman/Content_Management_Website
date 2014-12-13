<?php


/* Explanation: Author; Gregory E. Hatt
 * Tutorial from http://www.tutorialspoint.com/jqueryui/jqueryui_autocomplete.htm
 * The auto-complete functions but generating a JSON result set from
 * a two dimensional array of possible results with a "label" and "value".
 * If a letter match is found (strpos) it adds it to the result set which
 * will be turned into a JSON object.
 */

include_once "../Business/Article.php"; // required to get all the articles

$term = $_GET[ "term" ]; // the jqueryUI uses this to get the input
$allArticles = Article::retrieveData(); // get all the articles
$articleCount = 1; // for the index of the drop down

$articles = array(); // will hold the relevant part of each article

foreach ($allArticles as $article){

    // Get the label to add to the result set
    $articleName = $article->getTitle();

    // Create the array or arrays used to check for matches
    $articleArray = array("label" => $articleName, "value" => $articleName);

    // Add the article
    array_push($articles, $articleArray);

    // Increment the count
    $articleCount++;
}

// Array to hold matches
$result = array();

// Check for matches and add them to the result
foreach ($articles as $singleArticle) {
    $articleLabel = $singleArticle[ "label" ];
    if ( strpos( strtoupper($articleLabel), strtoupper($term) )
        !== false ) {
        array_push( $result, $singleArticle );
    }
}

// Create a JSON object from the result and echo it
echo json_encode( $result );
