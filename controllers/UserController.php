<?php

class UserController
{
    #Вывод представления страницы регистрации
    public function actionGetRegister(): bool
    {
        $login = '';
        $email = '';
        $password = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = false;

            if (User::checkLoginExists($login)) {
                $errors[] = 'Такой логин уже используется';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }

            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if (!User::matchPasswords($password, $password_confirm)) {
                $errors[] = 'Пароли не совпадают';
            }

            if ($errors == false) {
                $result = User::register($login, $email, $password);
            }
        }

        require_once(ROOT . '/views/user/register.php');

        return true;
    }

    #Вывод представления страницы авторизации
    public function actionGetLogin(): bool
    {

        require_once(ROOT . '/views/user/login.php');

        return true;
    }

    public function actionPostAjaxRegister()
    {
        $login = '';
        $email = '';
        $password = '';
        $result = false;

        if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['email'])) {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = false;
            $success = false;

            if (User::checkLoginExists($login)) {
                $errors[] = 'Такой логин уже используется';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }

            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if (!User::matchPasswords($password, $password_confirm)) {
                $errors[] = 'Пароли не совпадают';
            }

            if ($success == false) {
                $result = User::register($login, $email, $password);
                $success[] = 'Вы успешно зарегистрированы!';
            }
        }

        if (!empty($errors)) {
            $status = array('errors' => $errors);
        } else if (!empty($success)) {
            $status = array('success' => $success);
        };

        echo json_encode($status);

        return true;
    }

    #Авторизация пользователя посредством Ajax
    public function actionPostAjaxLogin()
    {
        //TODO: Добавить проверку заголовков
        $login = '';
        $password = '';

        if (isset($_POST['login']) && isset($_POST['password'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $errors = false;
            $success = false;

            # Валидация полей
            if (!User::checkLogin($login)) {
                $errors[] = 'Неверный логин';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Неверный пароль';
            }

            # Проверка существования пользователя в БД
            $userId = User::checkUserData($login, $password);
            if (!$userId) {

                # Если данные не верны -выводим ошибку
                $errors[] = 'Неверные данные для входа';
            }
            if ($userId) {
                $success[] = 'Вы успешно авторизованы!';

                #Если данные верны, сохраняем id пользователя в сессию
                User::auth($userId);
            } else {
                return http_response_code(400);
            }
        } else {
            return http_response_code(400);
        }

        if (!empty($errors)) {
            $status = array('errors' => ['Неверные данные для входа']);
        } else if (!empty($success)) {
            $status = array('success' => $success);
        };

        echo json_encode($status);

        return true;
    }

    #Выход пользователя из сессии
    public function actionGetLogout()
    {
        session_start();
        unset($_SESSION['user']);
        header("Location: /");
    }
}
