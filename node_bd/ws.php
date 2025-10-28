<?
require_once './db.php';
require_once './user.php';
require_once './cliente.php';
require_once './json.php';
//require_once './departamento.php';

class MainWebService{
	public $form_data;
	public $form_msg;
	public $db;
	public $method = 'GET';

	public function __construct($dt = null){
		$this->db = new SystemDB();
		$this->form_data = array();
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->loadMethod();
	}
	
	//Padrao desenho Factory
	/*
	($_GET['table']::$table)
	Verificar se na classe existe o atributo estatico table
	.../user
	*/
	public function loadMethod(){
		switch($this->method){
			case 'GET':
				if(!empty($_GET['table']))
					if(class_exists($_GET['table']))
						$this->get($_GET['table']::$table);
					else{
						//Devia ser feito um redirecionamento para pagina inicial ou 404
						echo "Sem controlo para a tabela pedida!";
					}	
				break;
			case 'POST':
				if(!empty($_GET['table']))
					if(class_exists($_GET['table']))
						$this->put($_GET['table']::$table);
					else{
						//Devia ser feito um redirecionamento para pagina inicial ou 404
						echo "(Insert) Sem controlo para a tabela pedida!";
					}	
				break;
			case 'PUT':
				if(!empty($_GET['table']))
					if(class_exists($_GET['table']))
						$this->put($_GET['table']::$table);
					else{
						//Devia ser feito um redirecionamento para pagina inicial ou 404
						echo "(Put) Sem controlo para a tabela pedida!";
					}	
				break;
			case 'DELETE':
				break;
		}
	} //encerramento loadMethod
	/* o $_GET é o das clausulas do .htaccess(table,id)
	Polimorfismo, o mesmo metodo para todas as tabelas
	*/
	function get($t = null, $id = null){
		if(!empty($_GET)){
			foreach($_GET as $key => $v)
				$this->form_data[$key] = $v;
		}
		if($this->chk_array($this->form_data, 'table') && !$this->chk_array($this->form_data, 'id')){
			$query = $this->db->query('SELECT * FROM `'.$t.'`');
			$response = new $t($query->fetchAll(PDO::FETCH_OBJ));
		}else{
			$query = $this->db->query('SELECT * FROM `'.$t.'` WHERE `id` = ?', array($this->chk_array($this->form_data, 'id')));
			$response = new $t($query->fetchAll(PDO::FETCH_OBJ));
		}
		if(empty($response))
			$response = array(
				'status' => 0,
				'message' => 'Não tem o controller'.$t
			);
		new Json($response);
	}

	/*Metodo Post
	Args tabela*/ 
	function post($t= null){
		if(!empty($_POST)){
			foreach($_POST as $key => $v)
				$this->form_data[$key] = $v;
		}
		if($this->chk_array($_GET, 'table')){
			$q = $this->db->insert($t, $this->form_data);
			$response = array(
				'status' => 1,
				'message' => $t.' inserido com sucesso!!!'
			);
		}
		new Json($response);
	}

	/*Método PUT
	Args da tabela e id da chave de alteração
	PUT(prot. HTTP) não existe no php
	*/
	function put($t = null, $id = null){
		parse_str(file_get_contents('php://input', $_PUT));
		$_id = intval($_GET['id']);
		if(!empty($_PUT)){
			foreach($_PUT as $key => $v)
				$this->form_data[$key] = $v;
		}
		if($this->chk_array($_GET, 'table')){
			//update(tabela, campo(Primary key), arg id, alteraçao)
			$q = $this->db->update($t, 'id', $_id, $this->form_data);
			$response = array(
				'status' => 1,
				'message' => $t.' user atualizado com sucesso!!!'
			);
		}
		new Json($response);
	}

	//Verifica se a chave(k) existe no array(ar)
	private function chk_array($ar, $k){
		if(isset($ar[$k]) && !empty($ar[$k]))
			return $ar[$k];
		return null;
	}

}

new MainWebService();

?>