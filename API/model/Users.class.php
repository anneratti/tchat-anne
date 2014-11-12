<?php

// Users.class.php

/**
 * Classe permettant de gérer les users
 */
class User extends Model
{
  protected $userNickName = 'userNickName';
  

  
  public function listAll()
  {
    // On prépare la requête SQL
    $query = "SELECT *  FROM users order by userNickName asc" ;

     // On charge notre requête SQL dans la couche d'abstraction PDO
      $statement = $this->PDO->prepare($query);

      // On exécute notre requête SQL
      $statement->execute();

      // On retourne nos résultats SQL (liste des personnages)
      // sous la forme d'un tableau à deux dimensions
      echo json_encode($statement->fetchAll());
  }
    public function exists($userNickName)
    {


        // On prépare la requête SQL
        $query = "SELECT *  FROM users where userNickName =:userNickName  " ;

        $boundValues = [
            'userNickName' => $userNickName

        ];

        // On charge notre requête SQL dans la couche d'abstraction PDO
        $statement = $this->PDO->prepare($query);

        // On exécute notre requête SQL
        $statement->execute($boundValues);

        // On retourne nos résultats SQL (liste des personnages)
        // sous la forme d'un tableau à deux dimensions
        if ($statement->rowCount() === 0)
        {
            // On retourne la valeur FALSE
            return false;


        }
        else
        {
            return true;

        }


    }
    public function existsId($userNickName)
    {


        // On prépare la requête SQL
        $query = "SELECT userId  FROM users where userNickName =:userNickName" ;

        $boundValues = [
            'userNickName' => $userNickName

        ];

        // On charge notre requête SQL dans la couche d'abstraction PDO
        $statement = $this->PDO->prepare($query);

        // On exécute notre requête SQL
        $statement->execute($boundValues);

        // On retourne nos résultats SQL

        $result=$statement->fetch();
        $id=$result['userId'];

         //echo json_encode($id);
        return($id);




    }

    public function add($userNickName)
    {




        // On prépare notre requête SQL
        $query = "INSERT INTO users (userNickName) VALUES (:userNickName)";

        // On prépare notre tableau faisant le "binding" entre les valeurs de nos variables
        // et celles qui sont envoyées dans la requête SQL (pour éviter les injections)

        $boundValues = [
            'userNickName' => $userNickName

        ];

        // On charge notre requête SQL dans la couche d'abstraction PDO
        $statement = $this->PDO->prepare($query);

        // On exécute notre requête SQL (en liant notre tableau de "binding")
        $statement->execute($boundValues);
        $lastId=$this->PDO->lastInsertId();
        return($lastId);


    }

/*
  public function exists($n)
  {
    $whereArray = [
      'n' => $n
    ];

    $queryResults = $this->SQLQueryManager->select('carts_products', $whereArray);

    // S'il n'y a aucun enregistrement dans la BDD
    if (count($queryResults) === 0)
    {
      // On retourne la valeur FALSE
      return false;
    }
    // Sinon (s'il n'y aucun enregistrement)
    else
    {
      // On retourne la valeur TRUE
      return true;
    }
  }

  public function add($productId)
  {
    $whereArray = [
      'productId' => $productId,
      'cartId' => $_SESSION['cartId']
    ];

    $queryResults = $this->SQLQueryManager->select('carts_products', $whereArray);

    if (count($queryResults) === 1)
    {
      $this->increase($queryResults[0]['n']);
    }
    else
    {
      $valuesArray = [
        'productId' => $productId,
        'cartProductQuantity' => 1,
        'cartId' => $_SESSION['cartId']
      ];

      $products = $this->SQLQueryManager->insert('carts_products', $valuesArray);
    }
  }
  */

  /**
   * Supprime le produit du panier de la BDD
   * 
   * @param  int  $n Identifiant de la ligne de panier
   * @return void
   */
  public function remove($n)
  {
    $this->SQLQueryManager->delete('carts_products', ['n' => $n]);
  }

  /**
   * 
   * 
   * @param  int  $n Identifiant de la ligne de panier
   * @return void
   */
  
}
