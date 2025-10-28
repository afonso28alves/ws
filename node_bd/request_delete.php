<?
require_once '../ws_config.php';

$ci = curl_init();
curl_setopt($ci, CURLOPT_URL, "http://localhost/prog23_opp/AfonsoAlvesws/bd/user/10");
curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ci, CURLOPT_HEADER, false);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ci);
$_resposta = json_decode($response, true);
_output_header_(true, null, $_resposta);

?>