<?
require_once '../ws_config.php';
/*
isset - verifica se existe
empty - existe, verifica conteudo
*/
$request_method = $_SERVER["REQUEST_METHOD"];
switch($request_method){
	case 'GET':
		//uma vez que usamos para varias tabelas usamos um nome generico
		// ..dominio/user/x
		if(!empty($_GET["id"])){
			$id_pk = intval($_GET["id"]);
			getIdUser($id_pk);
		}else
			// ../dominio/user
			getAllUser();
		break;
	case 'POST':
		addUser();
		break;
	case 'PUT':
		$id_pk = intval($_GET["id"]);
		updateUser($id_pk);
		break;
	case 'DELETE':
		$id_pk = intval($_GET["id"]);
		deleteUser($id_pk);
		break;
	default:
		header("HTTP/1.0 405 Method Not Allowed");		
}

function getIdUser($id){
	global $pdo;
	$sql = "SELECT * FROM user WHERE id=".$id;
	$response = array();
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	if($stmt->rowCount() > 0){
		while($r = $stmt->fetch(PDO::FETCH_OBJ))
			$response[] = $r;
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($response);	
	}
}

function getAllUser(){
	global $pdo;
	$sql = "SELECT * FROM user;";
	$response = array();
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	if($stmt->rowCount() > 0){
		while($r = $stmt->fetch(PDO::FETCH_OBJ))
			$response[] = $r;
		_output_header_(true, "Lista de users", $response);
	}	
}

function addUser(){
	global $pdo;
	try{
		$pdo->beginTransaction();
		$pdo->query("INSERT INTO user(nome, email, idade) VALUES('".$_POST['nome']."', '".$_POST['email']."', ".intval($_POST['idade']).")");
		$pdo->commit();
		//Só executa o status message se nao der erro no commit, senao passa logo para o catch 
		$r = array(
			'status' => 1,
			'status_message' => 'User registado!'
		);
	}catch(Exception $e){
		$pdo->rollBack();
		$r = array(
			'status' => 0,
			'status_message' => 'Erro no registo do User!'
		);
	}
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($r);
}

function updateUser($id){
	global $pdo;
	//strcasecmp -> metodo de comparaçao binaria
	if(!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT'))
		parse_str(file_get_contents('php://input', $_PUT));
	try{
		$pdo->beginTransaction();
		$pdo->query("UPDATE user SET nome='".$_PUT['nome']."', email='".$_PUT['email']."', idade=".$_PUT['idade']." WHERE id=".$id);
		$pdo->commit();
		$r = array(
			'status' => 1,
			'status_message' => 'User update!'
		);
	}catch(Exception $e){
		$pdo->rollBack();
		$r = array(
			'status' => 0,
			'status_message' => 'Erro no update do User!'
		);
	}
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($r);
}

function deleteUser($id){
	global $pdo;
	try{
		$pdo->beginTransaction();
		$pdo->query("DELETE FROM user WHERE id=".$id);
		$pdo->commit();
		$r = array(
			'status' => 1,
			'status_message' => 'User eliminado!'
		);
	}catch(Exception $e){
		$pdo->rollBack();
		$r = array(
			'status' => 0,
			'status_message' => 'Erro no delete do User!'
		);
	}
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($r);
}



?>