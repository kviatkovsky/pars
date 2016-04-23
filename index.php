<?php 
$filename=$_FILES["filename"]["tmp_name"];
function docx2text($filename) {
    return getTextFromZippedXML($filename, "word/document.xml");
}
function getTextFromZippedXML($archiveFile, $contentFile) {
    // Создаёт "реинкарнацию" zip-архива...
    $zip = new ZipArchive;
    // И пытаемся открыть переданный zip-файл
    if ($zip->open($archiveFile)) {
        // В случае успеха ищем в архиве файл с данными
        if (($index = $zip->locateName($contentFile)) !== false) {
            // Если находим, то читаем его в строку
            $content = $zip->getFromIndex($index);
            // Закрываем zip-архив, он нам больше не нужен
            $zip->close();
 
            // После этого подгружаем все entity и по возможности include'ы других файлов
            // Проглатываем ошибки и предупреждения
            $xml = DOMDocument::loadXML($content, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
 
            $string = iconv("UTF-8", "Windows-1251", $xml->saveXML());
 
            $perenos_xml = array("</w:t>", "</w:p>", "<w:br/>");
            $perenos_norm = "<br />";
 
            //то ругается на эту строчку ниже с ошибкой
            //Object of class DOMDocument could not be converted to string
            //(Объект класса DOMDocument не может быть преобразован в строку)
            $new_perenos = str_replace($perenos_xml, $perenos_norm, $string);
 
 
            // После чего возвращаем данные без XML-тегов форматирования 
            return strip_tags($xml->saveXML(), "<br />");
        }
        $zip->close();
    }
    // Если что-то пошло не так, возвращаем пустую строку
    return '';

}

 $a = docx2text("text.docx"); // Save this contents to file
 var_dump ($a);
 $result_array = preg_match_all("/\d{1,2}.\d{1,2} – \d{1,2}.\d{1,2}/",$a,$matches);
   
   echo "<pre>";
		print_r($matches);
		echo "</pre>";