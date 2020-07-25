<?php
//Done: Choose a random integer in range of no.of images to choose the image
//Make a temp file to store the game data in (Image + Search string (replaced with spaces))
//The file is opened from the server for the respective people
include 'genWord.php';
$keywords = "";
function getImg() {
    global $keywords, $textSplit, $punctuations, $stopWords;
    $keywords = generateWord($textSplit, $punctuations, $stopWords);

  /*  function getWord() {

        global $keywords;
        //ob = Output Buffering
        ob_start(); // begin collecting output
        include 'genWord.php';
        $word = ob_get_clean();
        $keywords.=$word;
    }*/

    for ($i = 0; $i < 3; $i++) {
        $keywords.='+'.generateWord($textSplit, $punctuations, $stopWords);
    }    
    
    $doc = new \DOMDocument();
    $doc->loadHTMLFile('https://www.google.com/search?q='.$keywords.'&tbm=isch');
    $images = $doc->getElementsByTagName("img"); // DOMNodeList Object

    $i= mt_rand(1, count($images) - 1);
    $src =  $images[$i]->getAttribute("src");
    echo "<p>".$keywords."</p>";
    echo "<img src = '".$src."'>";
}

?>

<html>
    <body>
    <?php
    for ($x = 0; $x < 3; $x ++) {
        getImg();
    }        
    ?>
<?php
    

?>
    </body>

</html>