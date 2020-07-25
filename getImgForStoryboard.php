<?php

include 'genWord.php';
$keywords = "";
function getImg() {
    global $keywords, $textSplit, $punctuations, $stopWords;
    $keywords = generateWord($textSplit, $punctuations, $stopWords);

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
