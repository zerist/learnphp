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
        if(!empty($_GET['url'])){
            $url = $_GET['url'];
            $urlArray = explode("/", $url);

            //控制器名
            $controllerName = ucfirst(empty($urlArray[0] ? 'Index' : $urlArray[0]));
            $controller = $controllerName . 'Controller';

            //Action名
            array_shift($urlArray);
            $action = empty($urlArray[0]) ? 'Index' : $urlArray[0];

            //url参数
            array_shift($urlArray);
            $queryString = empty($queryString) ? array() : $urlArray;
        }
    }
}
