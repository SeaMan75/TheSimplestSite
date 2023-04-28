<?php
include 'utils.php';
use function \utilities\logString as logger;
use function \utilities\search_response as resp;

function search_file_by($pattern, $flags = 0) {
   
  // поиск по маске в папке
  $files = glob($pattern, $flags);
  foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
      // поиск в подпапках
      $files = array_merge($files, search_file_by($dir .'/'. basename($pattern), $flags));
  }
  return $files;  
}

logger("1_128");
  
if (isset($_POST["search_what"])){
  $search_what = trim(strip_tags($_POST["search_what"]));
//  logger(">>>>>>>> ".$search_what);
  $search_result = "";
  
  $files = search_file_by("*.html");
  $search_results = array();
  
  $search_result = '<div class="widget"> <h3 class="widget-title">Результаты поиска</h3>';
  foreach($files as $file){
    $contents = file_get_contents($file);
    preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $contents, $matches, PREG_SET_ORDER);
    foreach ($matches as $val) {
        $v = stripos($val[3], $search_what);
        if($v !== false ) {
          logger("Найдено в ". $file . "(".$search_what . ")");
          $search_result .= sprintf('<div> <a href="%s">Открыть</a><span>%s</span><br></div>', $file, $val[3] );
          logger("aaa".$search_result );
        }
    }
  }
  $search_result .= '</div>'; 
  logger($search_result);
  resp($search_result);
}
else {
  logger("Ошибка...");
}
  
?>