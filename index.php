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
 
            $tag_xml = array("</w:p>", "<w:br/>");
            $tag = "<br />";
 
            
            $textForPront = str_replace($tag_xml, $tag, $string);
 
         
            return $textForPront;
        }
        $zip->close();
    }
    
    return "";
}
 $text = docx2text("texttest.docx.docx"); 
 echo $text;
 $result_array = preg_match_all("/\d{1,2}.\d{1,2} – \d{1,2}.\d{1,2}/",$text,$matches);
   
   echo "<pre>";
   echo "//---------------------------1111111111111--------------------------+++++++++++++<br>";
   $countMathes =  count($matches2);
		$date = array();
		for($i=0;$i<=$countMathes;$i++){
			$date = $matches[$i];
		}
		//print_r($matches);
		echo "</pre>";
		echo $date[1];
		$result_array = preg_match_all("/\d{1,2}.\d{1,2} – \d{1,2}.\d{1,2}(.*br.*br)/U",$text,$matches2);
   echo "<pre>";
   echo "//---------------------------222222222222----------------------------++++++++++++<br>";
     $countMathes =  count($matches2);
	 
       // print_r($matches2);
	   $location = array();
	   for($i=0;$i<=$countMathes;$i++){
		$a = $matches2[0][$i];
		//echo $a;
		$result_array = preg_match("/<w:t>.*<\/w:t>/",$a,$matchesa);
			//print_r($matchesa);
				
					$location[$i] = $matchesa[0];
				
	   }
	   
		//print_r($matchesa);
		echo $location[2];
	      
		 
       // print_r($matches2);
		
		//print_r($matchesa);
		echo "</pre>";
		
		$result_array = preg_match_all("/\d{1,2}.\d{1,2} – \d{1,2}.\d{1,2}(.*br.*br.*br)/U",$text,$matches3);
		
   echo "<pre>";
   echo "//---------------------------3333333333333---------------------------------------<br>";
   
       // echo $matches2[0];
		print_r($matches3);
		echo "</pre>";
		$result_array = preg_match_all("/<w:t xml:space=\"preserve\"><\/w:t>/U",$text,$matches4);
		
   echo "<pre>";
   echo "//---------------------------4444444444444444444444444--------------++++++++++++<br>";
       // echo $matches2[0]; $a= strip_tags ($matches4[0][1]);
	    
		$content = array();
			for($i=0;$i<=$countMathes;$i++){
		//print_r($matches4);
		$textForContent = $matches4[0][$i];
		//echo $test;
		$result_array = preg_match("/<w:t>.*<\/w:t>/",$textForContent,$matcheslast);
		//print_r($matcheslast);
		
		$textForContentLast = $matcheslast[0];
		//echo $test;
		$result_array = preg_match("/.br.*/",$textForContentLast,$matcheslast1);
		$content[$i] = $matcheslast1[0];
			}
			echo $content[2];
		echo "</pre>";
