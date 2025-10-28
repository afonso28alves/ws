<?
require_once '../ws_config.php';

$fields = array(
	'email' => 'afonso@alves.pt',
	'nome' => 'afonso 18',
	'idade' => 18
);

$fields = (is_array($fields)? http_build_query($fields): $fields);

$ci = curl_init();
curl_setopt($ci, CURLOPT_URL, "http://localhost/prog23_opp/AfonsoAlvesws/node_bd/user/12");
//curl_setopt($ci, CURLOPT_POST, true);
curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ci, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ci, CURLOPT_HEADER, false);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ci);
$_resposta = json_decode($response, true);
_output_header_(true, null, $_resposta);

?>