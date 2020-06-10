<?php

class Fast
{
    //入口
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));

    }

    //拆分url请求
    public function callHook()
    {
        if (!empty($_GET['url'])) {
            $url = $_GET['url'];
            $urlArray = explode("/", $url);

            //控制器名
            $controllerName = ucfirst(empty($urlArray[0] ? 'Index' : $urlArray[0]));
            $controller = $controllerName . 'Controller';

            //Action名
            array_shift($urlArray);
            $action = empty($urlArray[0]) ? 'index' : $urlArray[0];

            //url参数
            array_shift($urlArray);
            $queryString = empty($queryString) ? array() : $urlArray;
        }
        //数据为空处理
        $action = empty($action) ? 'index' : $action;
        $queryString = empty($queryString) ? array() : $queryString;

        //实例化控制器
        $int = new $controller($controller, $action);

        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($int, $action), $queryString);
        } else {
            exit($controller . "控制器不存在：" . $controller);
        }
    }

    //ini设置
    public function setReporting()
    {
        if (APP_DEBUG == true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', RUNTIME_PATH . 'logs/error.log');
        }
    }

    //删除敏感字符
    public function stripSlashsDeep($value)
    {
        $value = is_array($value) ? array_map('stripSlashDeep', $value) : stripslashes($value);
        return $value;
    }

    //检测敏感字符并删除
    public function removeMagicQuotes()
    {
        $_GET = $this->stripSlashsDeep($_GET);
        $_POST = $this->stripSlashsDeep($_POST);
        $_COOKIE = $this->stripSlashsDeep($_COOKIE);
        $_SESSION = $this->stripSlashsDeep($_SESSION);
    }

    //自动加载controller和model
    public function loadClass($class)
    {
        $frameworks = ROOT . $class . EXT;
        $controllers = APP_PATH . 'application/controllers/' . $class . EXT;
        $models = APP_PATH . 'application/models' . $class . EXT;

        if (file_exists($frameworks)) {
            include $frameworks;
        } elseif (file_exists($controllers)) {
            include $controllers;
        } elseif (file_exists($models)) {
            include $models;
        } else {
            exit("加载错误！");
        }
    }
}
