<?php

class Map
{
    public static function getCategoryList()
    {
        $db = Db::getConnection();

        $categoryList = array();

        $result = $db->query('SELECT DISTINCT category_name FROM map_categories');

        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['category_name'] = $row['category_name'];

            $i++;
        }

        return $categoryList;
    }

    public static function getLinkList()
    {
        $db = Db::getConnection();

        $categoryList = array();

        $result = $db->query('SELECT id, category_name, link_name, href FROM map_categories');

        $i = 0;
        while ($row = $result->fetch()) {
            $linkList[$i]['id'] = $row['id'];
            $linkList[$i]['category_name'] = $row['category_name'];
            $linkList[$i]['link_name'] = $row['link_name'];
            $linkList[$i]['href'] = $row['href'];
            $i++;
        }

        return $linkList;
    }
}
