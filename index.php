<?php 
$filename=$_FILES["filename"]["tmp_name"];
function docx2text($filename) {
    return getTextFromZippedXML($filename, "word/document.xml");
}
function getTextFromZippedXML($archiveFile, $contentFile) {
   
    $zip = new ZipArchive;
   
    if ($zip->open($archiveFile)) {
     
        if (($index = $zip->locateName($contentFile)) !== false) {
           
            $content = $zip->getFromIndex($index);
         
            $zip->close();
 
           
            $xml = DOMDocument::loadXML($content, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
 
            $string = $xml->saveXML();
 
            $perenos_xml = array("</w:p>", "<w:br/>", "<w:i/>");
            $perenos_norm = "<br />";
 
            
            $new_perenos = str_replace($perenos_xml, $perenos_norm, $string);
 
         
            return $new_perenos;
        }
        $zip->close();
    }
    
    return "";
}

 $text = docx2text("texttest.docx.docx"); 
 echo $text;
 $result_array = preg_match_all("/\d{1,2}.\d{1,2} – \d{1,2}.\d{1,2}/",$text,$matches);
   
   echo "<pre>";
		print_r($matches);
		echo "</pre>";
		$result_array = preg_match_all("/<w:t>.*<\/w:t>/U",$text,$matches2);
   echo "<pre>";
		print_r($matches2);
		echo "</pre>";
