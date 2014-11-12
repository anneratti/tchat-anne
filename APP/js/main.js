// On définit une variable globale
// permettant de stocker l'identifiant de l'utilisateur
var userId = 0;
//const API_URL =  'http://localhost/tchat-anne/API/index.php',
//const API_URL = 'http://192.168.1.103/tchat-Gervaise/API/index.php';
const API_URL = 'http://192.168.1.100/tchat/API/index.php';

// Une fois que le DOM est bien chargé
$(function () {


    $('#userNickname').keypress(function(eventObject) {
        if (eventObject.which == 13)
        {
            userConnect();
            $('#hide').show();
        }
    });

    messageListRefresh();
    usersListRefresh();

});

$(function () {


    $('#message').keypress(function(eventObject) {
        if (eventObject.which == 13)
        {
            messageSend();
        }
    });

    messageListRefresh();
    usersListRefresh();

});


// Fonction de connection au t'chat du nouvel utilisateur
function userConnect()
{
    $.ajax({
        // On définit l'URL appelée
        //url: 'http://localhost/tchat/API/index.php',
        url: API_URL,
        // On définit la méthode HTTP
        type: 'GET',
        // On définit les données qui seront envoyées
        data: {
            action: 'userAdd',
            userNickname: $('#userNickname').val()
        },
        // l'équivalent d'un "case" avec les codes de statut HTTP
        statusCode: {
            // Si l'utilisateur est bien créé
            201: function (response) {
                // On stocke l'identifiant récupéré dans la variable globale userId
                //window.userId = response.userId;
                //console.log('connect response');
                //console.log(response);
                //console.log('connect response.userId');
                //console.log(response.userId);
                window.userId = response;
                //console.log('connect window.userId');
                //console.log(window.userId);

                //console.log('fin connect');
                // On masque la fenêtre, puis on rafraichit la liste de utilisateurs
                usersListRefresh();
                $('#userNickname').val("");
            },
            // Si l'utilisateur existe déjà
            208: function (response) {
                //console.log('existe deja connect');
                window.userId = response;
                //console.log('connect window.userId');
                console.log(window.userId);
                // On fait bouger la fenêtre de gauche à droite
                // et de droite à gauche 3 fois
                // (à faire...)
            }
        }
    })
}
// Fonction de connection au t'chat du nouvel utilisateur
function messageSend()
{
    //console.log('coucou');
    //console.log(window.userId);
    //console.log('fin coucou');
    $.ajax({


        // On définit l'URL appelée
       //url: 'http://localhost/tchat/API/index.php',
        url: API_URL,
        // On définit la méthode HTTP
        type: 'GET',
        // On définit les données qui seront envoyées
        data: {
            action: 'addMessage',
            messageValue: $('#message').val(),
            userId: window.userId
        },
        // l'équivalent d'un "case" avec les codes de statut HTTP
        statusCode: {
            // Si le message est bien créé
            201: function (response) {

                // On masque la fenêtre, puis on rafraichit la liste de utilisateurs
                messageListRefresh();
                $('#message').val("");
            }
        }
    })
}


function usersListRefresh()

{

    $.ajax({

        //url: "../API/index.php?action=listUsers",
        //url: "http://192.168.1.103/tchat/API/index.php?action=listUsers",
        url: API_URL,
        type: "GET" ,
        data: {
            action: 'listUsers'

        }

    }).done(function(reponse)
        {

            //console.log(reponse);
            $('#userList li').remove();

            $.each(reponse, function(cle, valeur)
            {



                $('#userList').append(
                        '<li id="userList1">' +
                            valeur['userNickName']+ '</li>'
                    );




            });
        })
    .done(function() {
    // on relance l'appel AJAX dans 0.5 secondes
    window.setTimeout(usersListRefresh, 500);
});

}
function messageListRefresh()
{

    $.ajax({


        //url: "../API/index.php?action=listMessages",
        url: API_URL,
        type: "GET",
        data: {
            action: 'listMessages'

        }

    }).done(function(reponse)
    {

        //console.log(reponse);
        $('#blog article').remove();
         $.each(reponse, function(cle, valeur)
        {


            //console.log(valeur['messageValue']);
            //console.log(valeur['messageDate']);
            //console.log(valeur['userId']);
            //console.log(valeur['userNickName']);

            $('#blog').append(
                '<article><p class="article">' +
                    valeur['messageDate']   + ' ' +
                    valeur['userNickName'] + '<br>' +

                valeur['messageValue']+ '</p></article>'
            );




        });
// on relance l'appel AJAX dans 0.5 secondes

    })
    .done(function() {
    // on relance l'appel AJAX dans 0.5 secondes
    window.setTimeout(messageListRefresh, 500);
    });
}





