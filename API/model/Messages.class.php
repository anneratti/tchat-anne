<?php

// Messages.class.php

/**
 * Classe permettant de gérer les users
 */
class Messages extends Model
{
  protected $messageValue = 'messageValue';
  protected $messageDate = 'messageDate';
  protected $userId = 'userId';

  

  
  public function listAll()
  {
    // On prépare la requête SQL
    $query = "SELECT a.* , b.userNickName  FROM messages a  , users b
    where a.userId = b.userId order by messageDate desc" ;

    // On charge notre requête SQL dans la couche d'abstraction PDO
      $statement = $this->PDO->prepare($query);

      // On exécute notre requête SQL
      $statement->execute();

      // On retourne nos résultats SQL (liste des personnages)
      // sous la forme d'un tableau à deux dimensions
      echo json_encode($statement->fetchAll());
  }

  public function add($messageValue,$userId)
  {

   // On prépare notre requête SQL
      $query = "INSERT INTO messages (messageValue, userId) VALUES (:messageValue,  :userId)";
      console.log($messageValue);
      console.log($userId);
      // On prépare notre tableau faisant le "binding" entre les valeurs de nos variables
      // et celles qui sont envoyées dans la requête SQL (pour éviter les injections)

      $boundValues = [
          'messageValue' => $messageValue,

          'userId' => $userId
      ];

      // On charge notre requête SQL dans la couche d'abstraction PDO
      $statement = $this->PDO->prepare($query);

      // On exécute notre requête SQL (en liant notre tableau de "binding")
      $statement->execute($boundValues);
  }





}
