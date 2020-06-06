<?php
try {
    $dsn = "mysql:host=localhost;dbname=learn_php";
    $db = new PDO($dsn, 'root', '');

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'UTF8'");

    $sql = "INSERT INTO test(id, name, sex) values(1,'xk','man')";
    $db->exec($sql);

    $insert = $db->prepare("insert into test(id,name,sex) values(?,?,?)");
    $insert->execute(array(2, 'rt', 'it'));
    $insert->execute(array(3, 'op', 'kk'));

    $sql = "select id,name,sex from test";
    $query = $db->prepare($sql);
    $query->execute();

    var_dump($query->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $err) {
    echo $err->getMessage();
}
