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
 
            $string = iconv("UTF-8", "Windows-1251", $xml->saveXML());
 
            $perenos_xml = array("</w:t>", "</w:p>", "<w:br/>");
            $perenos_norm = "<br />";
 
            
            $new_perenos = str_replace($perenos_xml, $perenos_norm, $string);
 
 
            
            return strip_tags($xml->saveXML(), "<br />");
        }
        $zip->close();
    }
    
    return '';

}

 $a = docx2text("text.docx"); 
 var_dump ($a);
 $result_array = preg_match_all("/\d{1,2}.\d{1,2} – \d{1,2}.\d{1,2}/",$a,$matches);
   
   echo "<pre>";
		print_r($matches);
		echo "</pre>";
