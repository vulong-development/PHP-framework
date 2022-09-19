<?php

class User
{
    #Регистрация нового пользователя
    public static function register($login, $email, $password): bool
    {
        #Удаление HTML и PHP тегов из получаемой строки
        $login = trim(strip_tags($login));
        $password = trim(strip_tags($password));

        $db = Db::getConnection();

        $sql = 'INSERT INTO user (login, email, password) VALUES (:login, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $result->bindParam(':password', $password_hashed, PDO::PARAM_STR);

        return $result->execute();
    }

    #Проверка существования пользователя с заданными $email и $password
    public static function checkUserData($login, $password)
    {
        $login = trim(strip_tags($login));
        $password = trim(strip_tags($password));

        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE login = :login';

        $result = $db->prepare($sql);

        $result->bindParam(':login', $login, PDO::PARAM_STR);
        // $result->bindParam(':password', $password, PDO::PARAM_STR);

        $result->execute();

        $user = $result->fetch();

        #Проверка пароля вводимого пользователем с паролем в БД
        $passDb = $user['password'];
        if (password_verify($password, $passDb) || $user = true) {
            return $user['id'];
        }

        return false;
    }

    #Сохранение id пользователя в сессию
    public static function auth($userId)
    {

        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {
        #Если сессия есть, вернём идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
        return true;
    }

    # Валидация поля ввода пароля. Проверка пароля на количество символов(не менее 6-ти символов)
    public static function checkPassword($password): bool
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    # Валидация поля ввода пароля. Проверка пароля на минимальное количество символов(не менее 6-ти символов)
    public static function checkLogin($login): bool
    {
        if (strlen($login) >= 2) {
            return true;
        }
        return false;
    }

    # Проверка на совпадение полей ввода пароля(Повтор вводимого пароля пользователем)
    public static function matchPasswords($password, $password_confirm): bool
    {
        if ($password === $password_confirm) {
            return true;
        }
        return false;
    }

    # Валидация электронной почты(Соответствует ли введённое значение паттерну)
    public static function checkEmail($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    # Проверка наличия email в БД
    public static function checkEmailExists($email): bool
    {
        $db = Db::getConnection();

        # Подготовленный запрос к БД
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    # Проверка наличия логина в БД
    public static function checkLoginExists($login): bool
    {
        $db = Db::getConnection();

        # Подготовленный запрос к БД
        $sql = 'SELECT COUNT(*) FROM user WHERE login = :login';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            #Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }

    public static function setUserLogin()
    {
        #Получаем идентификатор пользователя из сесии
        $userId = User::checkLogged();

        #Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        return $user['login'];
    }

    #Прошёл ли пользователь авторизацию
    public static function isGuest(): bool
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }
}
