<?php
    class Person{
        private $name;
        private $age;
        private $sex;

        function __construct($name="", $sex="man", $age=10){
            $this->name = $name;
            $this->sex = $sex;
            $this->age = $age;
        }

        public function __isset($propertyName){
            if($propertyName == "name"){
                return false;
            }
            return isset($this->$propertyName);
        }

        public function __unset($propertyName){
            if($propertyName == "name"){
                return;
            }
            unset($this->$propertyName);
        }

        public function say(){
            echo "my name is ".$this->name." sex:".$this->sex." age:".$this->age.".<br>";
        }
    }

    $person1 = new Person("xk", "man", 23);

    var_dump(isset($person1->age));
    unset($person1->name);
    $person1->say();
?>