<?php
abstract class Dialog{
    public abstract function createButton();

    public function render(){
        $btn = $this->createButton();
        var_dump($btn);
        $btn.onClick();
        $btn.render();
    }
}

class WindowDialog extends Dialog{
    public function createButton()
    {
        // TODO: Implement createButton() method.
        echo "create window dialog button" . PHP_EOL;
        return new WindowsButton();
    }
}

class WebDialog extends Dialog{
    public function createButton()
    {
        // TODO: Implement createButton() method.
        echo "create web dialog button" . PHP_EOL;
        return new HTMLButton();
    }
}

interface Button {
    function render();
    function onClick();
}

class WindowsButton implements Button{
    public function onClick()
    {
        echo "windows button clicked" . PHP_EOL;
    }

    public function render()
    {
        echo "windows button render" . PHP_EOL;
    }
}

class HTMLButton implements Button{
    public function onClick()
    {
        // TODO: Implement onClick() method.
        echo "html button clicked" . PHP_EOL;
    }

    public function render()
    {
        // TODO: Implement render() method.
        echo "html button render" . PHP_EOL;
    }
}

class Application{
    public $dialog = null;
    public function initialize($btn_type){
        if($btn_type == 'html'){
            $this->dialog = new WebDialog();
        }elseif($btn_type == 'windows'){
            $this->dialog = new WindowDialog();
        }
    }

    public function run($btn_type){
        $this->initialize($btn_type);
        $this->dialog->render();
    }
}

$a = new Application();
$a->run('html');


