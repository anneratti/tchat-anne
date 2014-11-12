<?php

/* =========================================================
|                          GENERAL                         |
========================================================= */

// -------------------------------------------------------
// Création des objets permettant de gérer les données
// à partir des modèles

$users = new User($PDO);
$messages = new Messages($PDO);

// -------------------------------------------------------
// Gestion des actions du client
//echo "debut";
//for ( $numId=104 ;$numId<105; $numId++)
//{

//    echo "ID = " . $numId;
    //file_get_contents("http://192.168.1." .$numId ."/tchat/API/index.php?action=addMessage&userId=8&messageValue=OHOn%20fait%20un%20resto%20le%20dernier%20jour%20????%20&userId=1;");
//}
//echo "fin";
//file_get_contents("http://192.168.1." .$numId ."/tchat/API/index.php?action=addMessage&userId=8&messageValue=OHOn%20fait%20un%20resto%20le%20dernier%20jour%20????%20&userId=1;");


// action listusers
if (isset($_GET['action']) && $_GET['action'] === 'listUsers')
{

  $users->listAll();

}

if (isset($_GET['action']) && $_GET['action'] === 'listMessages')
{

    $messages->listAll();

}
if (isset($_GET['action']) && $_GET['action'] === 'addMessage')
{

    $messages->add($_GET['messageValue'] , $_GET['userId'] );
    http_response_code(201);
}

if (isset($_GET['action']) && $_GET['action'] === 'userAdd')
{

    $verif=$users->exists($_GET['userNickname']);


    if ($verif==false)
    {
        http_response_code(201);
        $insertId=$users->add($_GET['userNickname']);
        echo json_encode($insertId );
    }
    else
    {
        http_response_code(208);
        $connectId=$users->existsId($_GET['userNickname']);

       // echo json_encode(false );
        echo json_encode($connectId);

    }

}



