<?php

class CompileClass
{
    private $template;  //模板文件名
    private $content;   //模板内容
    private $comfile;   //编译后内容
    private $left = '{';
    private $right = '}';
    private $value = array();

    private $T_P = array(); //匹配规则
    private $T_R = array(); //替换规则

    public function __construct()
    {
        $this->T_P[] = "#\{\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}#";
        $this->T_P[] = "#\{(loop|foreach)\ \$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}#";
        $this->T_P[] = "#\{\/(loop|foreach)\}#";
        $this->T_P[] = "#\{([K|V])\}#";
        $this->T_P[] = "#\{if(.*?)\}#";
        $this->T_P[] = "#\{(else if|elseif)(.*?)\}#";
        $this->T_P[] = "#\{else\}#";

        $this->T_R[] = "<?php echo $this->value['\\1'];?>";
        $this->T_R[] = "<?php foreach((array)\$this->value['\\2'] as \$K=>\$V){?>";
        $this->T_R[] = "<?php }?>";
        $this->T_R[] = "<?php echo \$\\1; ?>";
        $this->T_R[] = "<?php if(\\1){ ?>";
        $this->T_R[] = "<?php }else if(\\2){ ?>";
        $this->T_R[] = "<?php }else{ ?>";
    }

    public function compile($source, $destFile)
    {
        $this->content = preg_replace($this->T_P, $this->T_R, $this->content);
    }

    public function c_var(){
        $pattern = '#\{\ \$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*) \}#';
        if(strpos($this->content, '{$') !== false){
            $this->content = preg_replace($pattern, "<?php echo \$this->value['\\1'];?>", $this->content);
        }
    }

    public function c_foreach(){
        $pattern1 = "#\{(loop|foreach)\ \$(.*?)}#";
        $pattern2 = "#\{\/(loop|foreach)}#";
        $pattern3 = "#\{([K|V])\}#";

        $rst_str1 = "<?php foreach((array)\\2 as \$K=>\$V){?>";
        $rst_str2 = "<?php }?>";
        $rst_str3 = "<?php echo \$\\1;?>";

        $this->content = preg_replace($pattern1, $rst_str1, $this->content);
        $this->content = preg_replace($pattern2, $rst_str2, $this->content);
        $this->content = preg_replace($rst_str3, $rst_str3, $this->content);

    }
}
