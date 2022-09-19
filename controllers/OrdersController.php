<?php

class OrdersController
{
    public function actionIndex()
    {
        $ordersList = array();
        $ordersList = Orders::getOrdersList();

        require_once(ROOT . '/views/orders/index.php');

        return true;
    }

    #Вывод страницы заказа
    public function actionCard($id)
    {
        $order = array();
        $order = Orders::getOrder($id);

        require_once(ROOT . '/views/orders/card.php');

        return true;
    }

    public function actionAdd()
    {
    }
}
