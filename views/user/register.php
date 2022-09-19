<?php
header("Strict-Transport-Security: max-age=63072000;");
//TODO: Добавить заголовки CSP
//TODO: Исправить путь для webmanifest
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM | Регистрация</title>
    <link rel="icon" href="<?php ROOT ?>/favicon.svg">
    <link rel="stylesheet" href="<?php ROOT ?>/css/app.min.css">
    <link rel="manifest" href="/crm.webmanifest">
    <!-- Yandex.Metrika counter -->
    <!-- /Yandex.Metrika counter -->
  </head>
  <body class="start-page">
    <script src="../js/register.js"></script>
  </body>
  </html>
