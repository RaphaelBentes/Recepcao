<?php
class Connection {
    public static function conn() {

	    $HOST = 'mysql:host=localhost;port=3306;dbname=recepcao';
		$USER = 'root';
		$PSW = '';

        $conn = new PDO($HOST,$USER,$PSW);
        $conn->exec('SET CHARACTER SET utf8');
        return $conn;
    }
}
?>
