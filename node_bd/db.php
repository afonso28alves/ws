<?php

class SystemDB {
    /** DB properties */
    public $host = 'localhost',
            $db_name = 'webservice_prog23',
            $password = '',
            $user = 'root',
            $charset = 'utf8',
            $pdo = null,
            $error = null,
            $debug = true,
            $last_id = null;

    public function __construct(
    $host = null, $db_name = null, $password = null, $user = null, $charset = null, $debug = null
    ) {

        // Configura as propriedades novamente.
        // Feito isso no ini­cio dessa classe, as constantes nao serao
        // necessarias. 
        $this->host = defined('HOSTNAME') ? HOSTNAME : $this->host;
        $this->db_name = defined('DB_NAME') ? DB_NAME : $this->db_name;
        $this->password = defined('DB_PASSWORD') ? DB_PASSWORD : $this->password;
        $this->user = defined('DB_USER') ? DB_USER : $this->user;
        $this->charset = defined('DB_CHARSET') ? DB_CHARSET : $this->charset;
        $this->debug = defined('DEBUG') ? DEBUG : $this->debug;

        // Conecta
        $this->connect();
    }

// __construct

    final protected function connect() {

        /* Os detalhes da conexao PDO */
        $pdo_details = "mysql:host={$this->host};";
        $pdo_details .= "dbname={$this->db_name};";
        $pdo_details .= "charset={$this->charset};";

        // Tenta conexao
        try {

            $this->pdo = new PDO($pdo_details, $this->user, $this->password);

            if ($this->debug === true) {

                // Configura o PDO ERROR MODE
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }

            // Libertar as propriedades
            unset($this->host);
            unset($this->db_name);
            unset($this->password);
            unset($this->user);
            unset($this->charset);
        } catch (PDOException $e) {
            if ($this->debug === true) {

                // Mostra a mensagem de erro
                echo "Erro: " . $e->getMessage();
            }
            die();
        } // catch
    }

// connect

    public function query($stmt, $data_array = null) {

        // Prepara e executa
        $query = $this->pdo->prepare($stmt);
        $check_exec = $query->execute($data_array);

        // Verifica se a consulta foi processada
        if ($check_exec) {

            // Retorna a consulta
            return $query;
        } else {

            // Configura o erro
            $error = $query->errorInfo();
            $this->error = $error[2];

            // Retorna falso
            return false;
        }
    }

    public function insert($table) {
        // Configura o array de colunas
        $cols = array();

        // Configura o valor inicial do modelo
        $place_holders = '(';

        // Configura o array de valores
        $values = array();

        // O $j irÃƒÂ¡ assegura que colunas serao configuradas apenas uma vez
        $j = 1;

        // ObtÃƒÂ©m os argumentos enviados
        $data = func_get_args();


        // Ãƒâ€° preciso enviar pelo menos um array de chaves e valores
        if (!isset($data[1]) || !is_array($data[1])) {
            return;
        }

        // Faz um laÃƒÂ§o nos argumentos
        for ($i = 1; $i < count($data); $i++) {

            // ObtÃƒÂ©m as chaves como colunas e valores como valores
            foreach ($data[$i] as $col => $val) {

                // A primeira volta do laÃƒÂ§o configura as colunas
                if ($i === 1) {
                    $cols[] = "`$col`";
                }

                if ($j <> $i) {
                    // Configura os divisores
                    $place_holders .= '), (';
                }

                // Configura os place holders do PDO
                $place_holders .= '?, ';

                // Configura os valores que vamos enviar
                $values[] = $val;

                $j = $i;
            }

            // Remove os caracteres extra dos place holders
            $place_holders = substr($place_holders, 0, strlen($place_holders) - 2);
        }

        // Separa as colunas por vÃƒÂ­rgula
        $cols = implode(', ', $cols);

        // Cria a declaraÃƒÂ§ÃƒÂ£o para enviar ao PDO
        $stmt = "INSERT INTO `$table` ( $cols ) VALUES $place_holders) ";

        // Insere os valores
        $insert = $this->query($stmt, $values);

        // Verifica se a consulta foi realizada com sucesso
        if ($insert) {

            // Verifica se temos o ÃƒÂºltimo ID enviado
            if (method_exists($this->pdo, 'lastInsertId') && $this->pdo->lastInsertId()
            ) {
                // Configura o ÃƒÂºltimo ID
                $this->last_id = $this->pdo->lastInsertId();
            }

            // Retorna a consulta
            return $insert;
        }
        return;
    }

// insert

    public function update($table, $where_field, $where_field_value, $values) {
        // Enviar todos os parÃƒÂ¢metros
        if (empty($table) || empty($where_field) || empty($where_field_value)) {
            return;
        }

        // ComeÃƒÂ§a a declaraÃƒÂ§ÃƒÂ£o
        $stmt = " UPDATE `$table` SET ";

        // Configura o array de valores
        $set = array();

        // Configura a declaraÃƒÂ§ÃƒÂ£o do WHERE campo=valor
        $where = " WHERE `$where_field` = ? ";

        // Precisa enviar um array com valores
        if (!is_array($values)) {
            return;
        }

        // Configura as colunas a atualizar
        foreach ($values as $column => $value) {
            $set[] = " `$column` = ?";
        }

        // Separa as colunas por vÃƒÂ­rgula
        $set = implode(', ', $set);

        // Concatena a declaraÃƒÂ§ÃƒÂ£o
        $stmt .= $set . $where;

        // Configura o valor do campo que vamos pesquisar
        $values[] = $where_field_value;

        // Garante apenas nÃƒÂºmeros nas chaves do array
        $values = array_values($values);

        // Atualiza
        $update = $this->query($stmt, $values);

        // Verifica se a consulta estÃƒÂ¡ OK
        if ($update) {
            // Retorna a consulta
            return $update;
        }
        return;
    }

// update

    public function delete($table, $where_field, $where_field_value) {
        // Precisa enviar todos os parÃƒÂ¢metros
        if (empty($table) || empty($where_field) || empty($where_field_value)) {
            return;
        }

        // Inicia a declaraÃƒÂ§ÃƒÂ£o
        $stmt = " DELETE FROM `$table` ";

        // Configura a declaraÃƒÂ§ÃƒÂ£o WHERE campo=valor
        $where = " WHERE `$where_field` = ? ";

        // Concatena tudo
        $stmt .= $where;

        // O valor que vamos pesquisar para apagar
        $values = array($where_field_value);

        // Apaga
        $delete = $this->query($stmt, $values);

        // Verifica se a consulta estÃƒÂ¡ OK
        if ($delete) {
            // Retorna a consulta
            return $delete;
        }
        return;
    }

// delete
}

// Class SystemDB
?>