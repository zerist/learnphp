<?php
include ("authorControl.php");
include ("gbookModel.php");
include ("message.php");
include ("leaveModel.php");
$message = new message();
$message->name = "phper";
$message->email = "php@qq.com";
$message->content = "hello world";

$gb = new authorControl();
$pen = new leaveModel();
$book = new gbookModel();
$book->setBookPath("D:\\xampp\\htdocs\\learnphp\\messageApp\\a.txt");
$gb->message($pen, $book, $message);
echo $gb->view($book);
$gb->delete($book);
