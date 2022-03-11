   <?php
   require_once('Connection.php');

class Dados{


   public static function validar($login,$senha) {
        $pdo = Connection::conn();
        $sql = 'SELECT * FROM  funcionarios WHERE login = ? AND senha = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($login, $senha));
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
       
    }
    //put


}

