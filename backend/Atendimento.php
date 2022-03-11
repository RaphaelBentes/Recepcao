<?php
   require_once('Connection.php');

class Atendimentos{

    public static function get_atendimentos() {
        $pdo = Connection::conn();
        $sql = 'SELECT * FROM  atendimento';
        $query = $pdo->query($sql);
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    }
    public static function get_proximo() {
        $pdo = Connection::conn();
        $sql = 'SELECT * FROM  proximos';
        $query = $pdo->query($sql);
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    }
 

    public static function concluir_atendimento($id){
        $pdo = Connection::conn();
        $sql = 'UPDATE atendimento SET `status` = "CONCLUÍDO" WHERE id = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($id));
        if ($query->rowCount() > 0) {
            return 1;
        } else {
            return false;
        }
    }

    public static function concluir_proximo($id,$id_ate){
        $pdo = Connection::conn();
        $sql = 'DELETE FROM proximos WHERE id = ? AND id_atendimento = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($id, $id_ate));
        if ($query->rowCount() > 0) {
            return 1;
        } else {
            return false;
        }
    }

    public static function cancelar_atendimento($id, $historico){
        $pdo = Connection::conn();
        $sql = 'UPDATE atendimento SET `status` = "CANCELADO", historico = ? WHERE id = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($historico, $id));
        if ($query->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public static function chamar_atendimento($id,$nome){
        $pdo = Connection::conn();
        $sql = 'INSERT INTO proximos(id,id_atendimento,nome_pessoa) VALUES(null,?,?)';
        $query = $pdo->prepare($sql);
        $query->execute(array($id,$nome));
        if ($query->rowCount() > 0) {
            return 1;
        } else {
            return false;
        }
    }
    public static function post_atendimento($id,$nome,$data,$assunto){
        $pdo = Connection::conn();
        $sql = 'INSERT INTO atendimento(id,id_pessoa,nome,dataA,status,assunto) VALUES(null,?,?,?,"ABERTO",?)';
        $query = $pdo->prepare($sql);
        $query->execute(array($id,$nome,$data,$assunto));
        if ($query->rowCount() > 0) {
            return 1;
        } else {
            return false;
        }
    }

    public static function find_pessoa($cpf) {
        $pdo = Connection::conn();
        $sql = 'SELECT * FROM  pessoas WHERE cpf = '.$cpf;
        $query = $pdo->query($sql);
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if($query->rowCount() > 0){
            return $dados;   
        }else{
            return 0;
        }
    }

    public static function relatorio($data) {
        $pdo = Connection::conn();
        $sql = 'SELECT * FROM  atendimento WHERE dataA = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($data));
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
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

