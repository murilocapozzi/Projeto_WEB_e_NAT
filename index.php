<?php

    function getUserIP()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                    $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    function getWelcomeMessage()
    {
        $hora = date("H");
        if($hora >= 0 && $hora <= 12)
            $message = 'Bom dia!';
        elseif($hora >= 13 && $hora <= 18)
            $message = 'Boa tarde!';
        else
            $message = 'Boa noite!';

        return $message;
    }

    date_default_timezone_set('America/Sao_Paulo');

    $today = date("F j, Y, H:i:s");

    $paginas = ['home'=> getWelcomeMessage().'<br><br>'.$today.'<br><br>Seu IP é: '.getUserIP(),
                'sobre'=>'Projeto da UC de Redes de Computadores',
                'contato'=>'Email: murilo.capozzi@unifesp.br'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Projeto WEB/NAT</title>
<style type="text/css">
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    header{
        background-color:#069;
        padding:8px 10px;
        text-align:center;
    }

    a{
        display: inline-block;
        margin:0 10px;
        color: white;
        font-size: 17px;
    }

    section{
        max-width: 960px;
        margin: 20px auto;
        padding: 0 2%;
    }

    h2{
        background-color:#069;
        color:white;
        padding: 8px 10px;
    }

    p{
        color: black;
        margin-top:10px;
        font-size: 16px;
    }
    </style>
</head>
<body>
    <header>
    <?php
        foreach($paginas as $key => $value) {
            echo '<a href="?page='.$key.'">'.ucfirst($key).'</a>';
        }
    ?>
    </header>
    <section>
        <h2>
            <?php
                $pagina = (isset($_GET['page']) ? $_GET['page'] : 'home');
                if(!array_key_exists($pagina, $paginas)){
                    $pagina = 'home';
                }

                echo ucfirst($pagina);
            ?>
        </h2>
        <p><?php 
            if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $age = $_POST['age'];
                echo $paginas['contato'];
                echo "<br><br>Olá ".$name.", você possui ".$age." anos!";
            }
            else
                echo $paginas[$pagina]; ?></p>
    </section>
</body>
</htnl>