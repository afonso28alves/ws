<?
require_once '../ws_config.php';
/*
$_GET e $_POST nativos
$_PUT e $_DELETE
Trabalhar os dados em cru(raw)
Mecanismo de validação(file_get_contents(php://input))
*/

$fields = array(
	'email' => 'novo@novo.pt',
	'nome' => 'novo nome',
	'idade' => 125
);

//Verificar se são um array
$fields = (is_array($fields)? http_build_query($fields): $fields);

$ci = curl_init();
curl_setopt($ci, CURLOPT_URL, "http://localhost/prog23_opp/AfonsoAlvesws/bd/user/6");
//curl_setopt($ci, CURLOPT_POST, true);
curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ci, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ci, CURLOPT_HEADER, false);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ci);
$_resposta = json_decode($response, true);
_output_header_(true, null, $_resposta);

?>