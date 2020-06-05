<?php
include "Person.php";
include "Finery.php";
include "ConcreteDecrator.php";

$person = new Person();
$person->setName("xk");

echo "第一种装扮：\n";
$tshirts = new Tshirts();
$trouser = new BigTrouser();
$hat = new RedHat();

$tshirts->Decorate($person);
$trouser->Decorate($tshirts);
$hat->Decorate($trouser);
$hat->show();

$trouser->Decorate($person);
$hat->Decorate($trouser);
$tshirts->Decorate($hat);
$tshirts->show();