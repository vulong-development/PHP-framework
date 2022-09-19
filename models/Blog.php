<?php

class Blog
{
    # Извлечение названий разделов и категорий из БД
    public static function getChapterList()
    {
        $db = Db::getConnection();

        $chapterList = array();

        $result = $db->query('SELECT DISTINCT chapter_name FROM blog_categories ');

        $i = 0;
        while ($row = $result->fetch()) {
            $chapterList[$i]['chapter_name'] = $row['chapter_name'];

            $i++;
        }

        return $chapterList;
    }

    public static function getLinkList()
    {
        $db = Db::getConnection();

        $linkList = array();

        $result = $db->query('SELECT id, chapter_name, category_name FROM blog_categories WHERE status = "1"');

        $i = 0;
        while ($row = $result->fetch()) {
            $linkList[$i]['id'] = $row['id'];
            $linkList[$i]['chapter_name'] = $row['chapter_name'];
            $linkList[$i]['category_name'] = $row['category_name'];
            // $linkList[$i]['introduction'] = $row['introduction'];
            // $linkList[$i]['source'] = $row['source'];
            // $linkList[$i]['source_href'] = $row['source_href'];
            // $linkList[$i]['status'] = $row['status'];
            $i++;
        }

        return $linkList;
    }

    # Получение данных о категории из БД
    public static function getCategory($id = false)
    {
        if ($id) {

            $db = Db::getConnection();
            $category = array();
            $result = $db->query("SELECT category_name, introduction, source, source_href FROM blog_categories WHERE AND id = '$id'");

            $i = 0;
            while ($row = $result->fetch()) {
                // $category[$i]['id'] = $row['id'];
                $category[$i]['category_name'] = $row['category_name'];
                $category[$i]['introduction'] = $row['introduction'];
                $category[$i]['source'] = $row['source'];
                $category[$i]['source_href'] = $row['source_href'];

                $i++;
            }
        }

        return $category;
    }

    # Получение заголовка статьи из БД
    public static function getArticlesById($id = false)
    {
        if ($id) {

            $db = Db::getConnection();
            $article = array();
            $result = $db->query("SELECT title, description, added_date FROM blog_articles WHERE status = '1' AND category_id = '$id'");

            $i = 0;
            while ($row = $result->fetch()) {
                // $category[$i]['id'] = $row['id'];
                $article[$i]['title'] = $row['title'];
                $article[$i]['description'] = $row['description'];
                $article[$i]['added_date'] = $row['added_date'];

                $i++;
            }
        }

        return $article;
    }
}
