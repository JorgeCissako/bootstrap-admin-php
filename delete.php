<?php

    if(isset($_POST['id_mem'])){
    $pdo = new pdo ('mysql:host=localhost;dbname=bootstrap_projeto','root','');

    $sql = $pdo->prepare(" delete from `tb_equipa` where id = ?");
    $sql->execute(array($_POST['id_mem']));

    }

?>