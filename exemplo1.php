<?
require_once './ws_config.php';

//Exemplo 1 
$jsonStr = '{"nome": "Afonso", "idade": 18, "sexo": "Masc."}';

//Parsing na string para gerar um obj PHP 
$objPessoa = json_decode($jsonStr);

echo "->".$jsonStr;
//echo "->".$objPessoa; obj nao é uma string 

echo "<br />Nome: ".$objPessoa->nome."<br />";
echo "Idade: ".$objPessoa->idade."<br />";
echo "Sexo: ".$objPessoa->sexo."<br /><br />";


//EXEMPLO 2
$jsonStr = '{
	"pessoas":[
		{"nome": "Sergio", "idade": 25, "sexo": "Masc."},
		{"nome": "Maria", "idade": 55, "sexo": "Fem."},
		{"nome": "Pedro", "idade": 12, "sexo": "Masc."},
		{"nome": "Joana", "idade": 18, "sexo": "Fem."}
	]
}';
$objPessoas = json_decode($jsonStr);

$listaPessoas = $objPessoas->pessoas;
print_r($listaPessoas);

echo "<br />Nome: ".$listaPessoas[1]->nome."<br />";
echo "Idade: ".$listaPessoas[1]->idade."<br />";

foreach($listaPessoas as $p){
	echo "Nome $p->nome, idade: $p->idade, Sexo: $p->sexo<br />";
}

//Exemplo 3
$jsonStr = '{
	"pessoas":[
		{"nome": "Sergio", "idade": 25, "sexo": "Masc.", "filhos": ["Manuel", "Maria", "Albertina"]},
		{"nome": "Maria", "idade": 55, "sexo": "Fem."},
		{"nome": "Pedro", "idade": 12, "sexo": "Masc."},
		{"nome": "Joana", "idade": 18, "sexo": "Fem.", "filhos": ["JP", "Cristiano"]}
	],
	"ultimoacesso": "23/12/2024"
}';

$objPessoas = json_decode($jsonStr);
$listaPessoas = $objPessoas->pessoas;
$ultimoacesso = $objPessoas->ultimoacesso;
echo "A ultima vez que acedeste foi:".$ultimoacesso."<br />";

/* Iterar os elementos do array e verificar se a prop "filhos" existe, usamos
o metodo property_exists(param1, param2)
param1 -> Se o param1 possui a prop denominada no param2
*/

foreach($listaPessoas as $p){
	echo "Nome $p->nome, idade: $p->idade, Sexo: $p->sexo<br />";
	if(property_exists($p, "filhos")){
		$deps = $p->filhos;
		foreach($deps as $f)
			echo "Filhos: $f <br />";
	}
}
//var_dump($listaPessoas);

//EXEMPLO 4 COM ARRAY ASSOCIATIVO
$jsonStr = '{"Sérgio" : 38, "Maria" : 12, "Manuel" : 23}';
$json_arr = json_decode($jsonStr, true); //Array associativo
/*var_dump($json_arr);
print_r($json_arr);
echo $json_arr["Sérgio"];*/

//JSON_ENCODE -> converter um obj e, JSON(string)
$idadesPessoas = array("Sergio" => 38, "Maria" => 20, "Manuel" => 67);
$pessoasJson = json_encode($idadesPessoas);
echo "<br />".$pessoasJson."<br />";
//SAIDA: {"Sergio":38,"Maria":20,"Manuel":67}

$listaPessoas = array('pessoas' => array(
		array(
			'nome' => 'Sergio',
			'idade' => 12		
		),
		array(
			'nome' => 'Pedro',
			'idade' => 56		
		),
		array(
			'nome' => 'Juliana',
			'idade' => 67		
		)
	)
);

$listaPessoasJSON = json_encode($listaPessoas);
echo "<br />".$listaPessoasJSON."<br />";

$exemploRec = json_decode($listaPessoasJSON);
foreach($exemploRec as $p)
	foreach($p as $atributo){
		echo '<br />'.$atributo->nome;
		echo $atributo->idade.'<br />';
	}

//Controlo de erros no parsing ao JSON 
if(json_last_error() == 0){
	echo '<br /> Sem erros no JSON! <br />';
}else{
	echo "Lista de erros:";
	switch(json_last_error()){
		case JSON_ERROR_DEPTH:
			echo 'Profundidade maxima atingida!';
			break;
		case JSON_ERROR_STATE_MISMATCH:
			echo 'State mismatch!';
			break;
		case JSON_ERROR_CTRL_CHAR:
			echo 'Caracter de controlo encontrado!';
			break;
		case JSON_ERROR_SYNTAX:
			echo 'Erro de sintaxe, JSON mal formatado!';
			break;
		case JSON_ERROR_UTF8:
			echo 'Erro na codificação UTF-8!';	
			break;
		default:
			echo 'Erro desconhecido';
	}
}








?>