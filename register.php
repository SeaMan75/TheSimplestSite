<?php
session_start();
include 'utils.php';
use function \utilities\logString as logger;
use function \utilities\response as resp;
logger("wrlbjrwlbjhwrlbjhwrlgbhjrlgjhligbjhrtilbghjrtilh");
if (isset($_POST["login"])
       && isset($_POST["email"])
       && isset($_POST["password"])
       && isset($_POST["rep_password"])
       && isset($_POST["country"]) )  {
          $login = trim(strip_tags($_POST["login"]));
          $email = trim(strip_tags($_POST["email"]));
          $country = trim(strip_tags($_POST["country"]));
          $password = trim(strip_tags($_POST["password"]));
          $rep_password = trim(strip_tags($_POST["rep_password"]));

          $subject = "Регистрация на сайте url_вашего_сайта";
          $msg = "Ваши данные формы регистрации:\n" ."Имя: $login\n" ."Ваш email: $email\n" ."Страна: $country";
          $headers = "Content-type: text/plain; charset=UTF-8" . "\r\n";
          $headers .= "From: Ваше_имя <ваш_email>" . "\r\n";
          $headers .= "Bcc: ваш_email". "\r\n";
          logger('isset($LOGIN) - Ok');

          if ( strcmp($password, $rep_password) == 0
                &&!empty($login) && !empty($email) && !empty($country)
                && !empty($password) && !empty($rep_password)
                && filter_var($email, FILTER_VALIDATE_EMAIL) ) 
                {
                  logger('Пароли равны и все есть...');
                  $link = mysqli_connect("localhost", "root", "root");
                  if (mysqli_connect_errno())
                  {
                    $error_msg = 'Ошибка соединения с базой данных';
                    logger($error_msg);
                    resp($error_msg);
                    exit();
                  }

                  mysqli_select_db($link, "db_users");
                  # проверям логин
                  if(!ctype_alnum($login))
                  {
                   $error_msg = 'Логин может состоять только из букв английского алфавита и цифр';
                   logger($error_msg);
                   resp($error_msg);
                   exit();
                  }
                 //resp();

                  if(strlen($login) < 3 or strlen($login) > 32)
                  {
                    $error_msg = 'Логин должен быть не меньше 3-х символов и не больше 32';
                    logger($error_msg);
                    resp($error_msg);
                    exit();
                  }

                  # проверяем, не сущестует ли пользователя с таким именем
                  $query = sprintf("SELECT COUNT(user_id) cnt_users FROM tbl_users WHERE user_login='%s'", mysqli_real_escape_string($link, $login));
                  logger($query);
                  if ($result_sql = mysqli_query($link, $query)) 
                  {
                    $row = mysqli_fetch_row($result_sql);
                    $cnt_users = $row[0];
                    mysqli_free_result($result_sql);
                    if($cnt_users > 0) 
                    {
                      mysqli_close($link);
                      $error_msg = sprintf('Пользователь %s уже существует в базе данных', $login);
                      logger($error_msg);
                      resp($error_msg);
                      exit();
                    }
                  }

                  # Убираем лишние пробелы и делаем двойное шифрование
                  $password = md5(md5(trim($password)));
                  $query = sprintf("INSERT INTO tbl_users SET user_login='%s',
                                    user_password='%s', user_email='%s', user_country='%s'"
                                    , $login, $password, $email, $country);
                  logger($query);
                  $result_0 = mysqli_query($link, $query);
                  mysqli_close($link);
                  if(!$result_0) 
                  {
                    $error_msg = "Ошибка: ".$query . "<br>" . mysqli_error($link);
                    logger($error_msg);
                    resp($error_msg);
                    exit();
                  }
                  mail($email, $subject, $msg, $headers);
                  logger("======>>>login.php");
                  include "login.php";
                  exit();

                } else 
                {
                  $error_msg = 'Заполните форму!';
                  logger($error_msg);
                  resp($error_msg);
                  exit();
                }
   } else
   {
      logger("");
   }
?>
