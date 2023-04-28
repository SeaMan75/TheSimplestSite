<?php
session_start();

include_once 'utils.php';
use function \utilities\logString as logger;
use function \utilities\response as resp;
use function \utilities\generateCode as genCode;
# Соединямся с БД

if (isset($_POST["login"]) && isset($_POST["password"])) 
{
  $login = trim(strip_tags($_POST["login"]));
  $password = trim(strip_tags($_POST["password"]));
  $link = mysqli_connect("localhost", "root", "root");
  if (mysqli_connect_errno()) 
  {
    $error_msg = 'Ошибка соединения с базой данных';
    logger($error_msg);
    mysqli_close($link);
    resp($error_msg);
    exit();
  }

if (empty($login) || empty($password)) 
{
  $error_msg = 'Не задан логин и/или пароль!';
  logger($error_msg);
  mysqli_close($link);
  resp($error_msg);
  exit();
}
        
logger('логин/пароль - ОК...');
        
    mysqli_select_db($link, "db_users");
    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = sprintf("SELECT user_id, user_password FROM tbl_users WHERE user_login='%s' LIMIT 1", mysqli_real_escape_string($link, $login));
    logger($query);
    if ($result_sql = mysqli_query($link, $query)) 
    {
        $row = mysqli_fetch_row($result_sql);
        mysqli_free_result($result_sql);
    }
    if($row[1] === md5(md5($password))) 
    {
      logger('login: Пароль введен правильный');
      mysqli_close($link);
      $_SESSION["login"] = $login; 
      resp("Вы успешно вошли в систему");
      $gourl='index.html';
      echo '<META HTTP-EQUIV="Refresh" Content="2; URL='.$gourl.'">';    
      exit();
    } 
    else 
    {
      $error_msg = 'Вы ввели неправильный логин/пароль';
      logger($error_msg);
      $_SESSION["login"] = "";
      mysqli_close($link);
      resp($error_msg);
    }       
  }
  else
  {
    logger("Не завдан логин и/или пароль");
  }

?>
