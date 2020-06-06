<?php
include "CompileClass.php";

class ZLTemplate
{
    private $arrayConfig = array(
        'suffix' => '.m',  //模板文件后缀
        'templateDir' => 'template/', //模板目录
        'compileDir' => 'cache/', //编译后存放目录
        'cache_htm' => false,    //是否编译静态html文件
        'suffix_cache' => '.htm', //编译文件后缀
        'cache_time' => 7200, //自动更新时间
    );
    public $file;   //模板文件名
    private $value = array();
    private $compileTool;   //编译器

    static private $instance = null;

    public function __construct($arrayConfig = array())
    {
        $this->arrayConfig = $arrayConfig + $this->arrayConfig;
        $this->compileTool = new CompileClass();
    }

    //单例模式
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new ZLTemplate();
        }
        return self::$instance;
    }

    public function setConfig($key, $value = null)
    {
        if (is_array($key)) {
            $this->arrayConfig = $key + $this->arrayConfig;
        } else {
            $this->arrayConfig[$key] = $value;
        }
    }

    public function getConfig($key = null)
    {
        if ($key) {
            return $this->arrayConfig[$key];
        } else {
            return $this->arrayConfig;
        }
    }

    public function assign($key, $value)
    {
        $this->value[$key] = $value;
    }

    public function assignArray($array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $this->value[$k] = $v;
            }
        }
    }

    public function path()
    {
        return $this->arrayConfig['templateDir'] . $this->file . $this->arrayConfig['suffix'];
    }

    public function show($file)
    {
        $this->file = $file;
        if (!is_file($this->path())) {
            exit("找不到对应模板文件:" . $this->path());
        }
        $compileFile = $this->arrayConfig['compileDir'] . md5($file) . '.php';
        var_dump($compileFile);
        var_dump($this->path());
        if (!is_file($compileFile)) {
            mkdir($this->arrayConfig['compileDir']);
            $this->compileTool->compile($this->path(), $compileFile);
            readfile($compileFile);
        } else {
            readfile($compileFile);
        }
    }
}
