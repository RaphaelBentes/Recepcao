<?php
   require_once('Connection.php');

class Pessoas{

    public static function get_pessoas() {
        $pdo = Connection::conn();
        $sql = 'SELECT * FROM  pessoas';
        $query = $pdo->query($sql);
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    }

    public static function put_paciente($nome, $cpf, $sus, $nascimento, $sexo, $telefone, $email, $cep, $endereco, $complemento, $numero, $cidade, $estado,$status, $id){
        $pdo = Connection::conn();
        $sql = 'UPDATE pacientes SET pac_nome = ?, pac_cpf = ?, pac_sus = ?, pac_aniversario = ?, pac_sexo= ?, pac_telefone = ?, pac_email = ?, pac_cep = ?, pac_endereco = ?, pac_complemento = ?, pac_numero = ?, pac_cidade = ?, pac_estado = ?, pac_status = ? WHERE pac_id = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($nome, $cpf, $sus, $nascimento, $sexo, $telefone, $email, $cep, $endereco, $complemento, $numero, $cidade, $estado,$status, $id));
        if ($query->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
   
    public static function post_pessoa($nome, $cpf, $telefone, $email){
        $pdo = Connection::conn();
        $sql = 'INSERT INTO pessoas() VALUES(null,?,?,?,?)';
        $query = $pdo->prepare($sql);
        $query->execute(array($nome, $cpf, $telefone, $email));
        if ($query->rowCount() > 0) {
            return $pdo->lastInsertId();
        } else {
            return 0;
        }
    }

    public static function find_pessoa($cpf) {
        $pdo = Connection::conn();
        $sql = 'SELECT * FROM  pessoas WHERE cpf = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($cpf));
        $dados = $query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount() > 0){
            return $dados;   
        }else{
            return 0;
        }
    }

    public static function remove_consulta($id){
        $pdo = Connection::conn();
        $sql = 'DELETE FROM consultas WHERE con_id = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($id));
        if ($query->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}

