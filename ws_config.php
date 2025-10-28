<?
//Configuraçoes básicas
$config['app_name'] = 'AfonsoApp';
$config['url'] = 'http://localhost/prog23_opp/Afonso%20Alves%20ws/';
$config['dbhost'] = 'localhost';
$config['dbname'] = 'webservice_prog23';
$config['dbuser'] = 'root';
$config['dbpass'] = '';

//apresentar erros ou debug completo
$config['show_error_log'] = true;

$pdo = new PDO("mysql:host=localhost;dbname=webservice_prog23","root", "", array(PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION));

/*
	Retorna uma resposta JSON para o cliente/servidor solicitador
	
	@param boolean $__sucess - indica se houve sucesso na operaçao
	@param string $__message - msg opcional
	@param array $__dados - a resposta
*/
function _output_header_($__sucess = true, $__message = null, $__dados = array()){
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode(
		array(
			'success' => $__sucess,
			'message' => $__message,
			'dados' => $__dados
		)
	);
	exit;
}

/*
json_encode -> codifica os dados para o formato JSON
json_decode -> descodifica os dados do formato JSON
*/



?>