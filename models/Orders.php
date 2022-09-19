<?php

class Orders
{
    #Получение списка всех заказов пользователя из БД
    public static function getOrdersList()
    {
        $userId = $_SESSION['user'];
        $db = Db::getConnection();

        $ordersList = array();

        $result = $db->query("SELECT id, order_item, comment, added_date, payment, status FROM orders WHERE user_id = '$userId'");

        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['order_item'] = $row['order_item'];
            $ordersList[$i]['comment'] = $row['comment'];
            $ordersList[$i]['added_date'] = $row['added_date'];
            $ordersList[$i]['payment'] = $row['payment'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }

        return $ordersList;
    }

    #Получение информации о заказе из БД
    public static function getOrder($id = false)
    {
        if ($id) {

            $db = Db::getConnection();
            $order = array();
            $result = $db->query("SELECT id, order_item FROM orders WHERE id = '$id'");

            $i = 0;
            while ($row = $result->fetch()) {
                $order[$i]['id'] = $row['id'];
                $order[$i]['order_item'] = $row['order_item'];

                $i++;
            }
        }

        return $order;
    }

     #Создание нового заказа в БД
     public static function addNewOrder()
     {
        $order_item = '';
        $comment = '';
        $user_id = $_SESSION['user'];

        $db = Db::getConnection();

        $sql = 'INSERT INTO orders (user_id, order_item, comment) '
            . 'VALUES (:user_id, :order_item, :comment )';

        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $result->bindParam(':order_item', $order_item, PDO::PARAM_STR);
        $result->bindParam(':comment', $comment, PDO::PARAM_STR);

        return $result->execute();

     }

     #Получение последнего заказа из БД(вновь созданоого) ?
     public static function getNewOrder()
    {
        $db = Db::getConnection();

        $ordersList = array();

        $result = $db->query('SELECT id, user_id, order_item, comment  FROM orders ORDER BY id DESC LIMIT 1');
        

        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_id'] = $row['user_id'];
            $ordersList[$i]['order_item'] = $row['order_item'];
            $ordersList[$i]['comment'] = $row['comment'];
            $ordersList[$i]['added_date'] = $row['added_date'];
            $i++;
        }

        return json_encode($ordersList);
    }
}
