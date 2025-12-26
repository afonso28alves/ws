<?
//http://localhost/prog23_opp/AfonsoAlvesws/exemplo3.php?format=xml ou json

require_once './ws_config.php';
if($_SERVER['REQUEST_METHOD'] !== "GET") 
	_output_header_(false, "Método de req. não aceite! Apenas aceito o GET", null);

$format = strtolower($_GET['format']) == 'json' ? 'json': 'xml';

$stmt = $pdo->prepare("SELECT * FROM user ORDER BY nome DESC");
$stmt->execute();
$users = array();
//rowCount -> devolve a quantidade de resultados
if($stmt->rowCount() > 0){
	while($row = $stmt->fetch(PDO::FETCH_OBJ)){
		$users[] = array('user' => $row);
	}
	//Construir o json
	if($format == 'json'){
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array('users' => $users));
	}else{
		header('Content-Type: text/xml');
		echo '<users>';
		foreach($users as $user){
			/*
			key -> user
			tag -> atributo da Bd
			val -> conteudo do atrib
			*/
			if(is_array($user)){
				foreach($user as $key => $val){
					echo '<'.$key.'>';
						foreach($val as $tag => $v)
							echo '<'.$tag.'>'.htmlentities($v).'</'.$tag.'>';
					echo '</'.$key.'>';
				}
			}
		}
		echo '</users>';
	}
}

//print_r($users);

?>
