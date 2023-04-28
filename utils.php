<?php
namespace utilities;
function logString($log_data) {
  $log = date('Y-m-d H:i:s') . ' > ' .$log_data;
  $now = date('Y-m-d');
  file_put_contents(__DIR__ . '/site2_'.$now.'.log', $log . PHP_EOL, FILE_APPEND);
}

function response($state = 'Ok') {
  global $login, $email, $country;
  // Формируем массив для JSON ответа
    $result = array(
      'login' => $login,
      'email' => $email,
      'country' => $country,
      'state' => $state
    );
    // Переводим массив в JSON
    echo json_encode($result);
    logString('JSON: '.json_encode($result));
}

function search_response($state = 'Ok') {
  global $search_result;
  // Формируем массив для JSON ответа
    $result = array(
      'search_result' => $search_result,
      'state' => $state
    );
    // Переводим массив в JSON
    echo json_encode($result);
    logString('Search JSON: '.json_encode($result));
}









# Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
?>
