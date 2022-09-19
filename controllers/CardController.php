<?php

class CardController
{
  #Вывод всех заказов на страницу из БД при загрузке страницы
  public function actionOnload()
  {
      $ordersList = array();
      $ordersList = Orders::getOrdersList();

      include_once ROOT . '/views/orders/orders_list.php';

      return true;
  }

  public function actionAdd()
  {
      #Добавление нового заказа на страницу
      Orders::addNewOrder();

      $ordersList = array();
      $ordersList = Orders::getOrdersList();

      include_once ROOT . '/views/orders/orders_list.php';

      return true;
  }
}
