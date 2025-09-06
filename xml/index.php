<!-- <?php
$myXMLData =
"<?xml version='1.0' encoding='UTF-8'?>
<note>
<to>Toveee</to>
<from>Jani</from>
<heading>Reminder</heading>
<body>Don't forget me this weekend!</body>
</note>";

$xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
print_r($xml);
?> -->


<!-- <?php
$xml=simplexml_load_file("note.xml") or die("Error: Cannot create object");
print_r($xml);
?> -->


<!-- <?php
$xml=simplexml_load_file("books.xml") or die("Error: Cannot create object");
echo $xml->to . "<br>";
echo $xml->from . "<br>";
echo $xml->heading . "<br>";
echo $xml->body;
?> -->
<?php
$xml=simplexml_load_file("books.xml") or die("Error: Cannot create object");
echo $xml->book[0]->title . "<br>";
echo $xml->book[1]->title;
?>