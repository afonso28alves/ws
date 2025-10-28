<?
require_once './ws_config.php';

$url = 'dados.json';

//file_get_contents ->metodo de captura e carregamento de recursos remotos ou locais

//Exemplo com objetos
$data = file_get_contents($url);
$pessoas = json_decode($data);
print_r($pessoas);

?>

<table>
	<tbody>
		<tr>
			<th>Nome</th>
			<th>Idade</th>
			<th>Morada</th>
		</tr>
		<? foreach($pessoas as $pessoa):?>
		<tr>
			<td><?=$pessoa->nome; ?></td>
			<td><?=$pessoa->idade; ?></td>
			<td><?=$pessoa->morada; ?></td>
		</tr>
		<? endforeach;?>
	</tbody>
</table>

<?

//Exemplo com array associativo
$pessoasAssoc = json_decode($data, true);
print_r($pessoasAssoc);
?>

<table>
	<tbody>
		<tr>
			<th>Nome</th>
			<th>Idade</th>
			<th>Morada</th>
		</tr>
		<? foreach($pessoasAssoc as $pessoa):?>
		<tr>
			<td><?=$pessoa['nome']; ?></td>
			<td><?=$pessoa['idade']; ?></td>
			<td><?=$pessoa['morada']; ?></td>
		</tr>
		<? endforeach;?>
	</tbody>
</table>

<?
$urlDados1 = 'dados1.json';

$dataDados1 = file_get_contents($urlDados1);
$pessoasDados1 = json_decode($dataDados1, true);
print_r($pessoasDados1);


?>
<table>
	<tbody>
		<tr>
			<th>Nome</th>
			<th>Idade</th>
			<th>Morada</th>
			<th>Altura</th>
			<th>Peso</th>
			<th>Cor</th>
		</tr>
		<? foreach($pessoasDados1 as $pessoa):?>
		<tr>
			<td><?=$pessoa['nome']; ?></td>
			<td><?=$pessoa['idade']; ?></td>
			<td><?=$pessoa['morada']; ?></td>
			<td><?=$pessoa['caracteristicas'][0]['altura']; ?></td>
			<td><?=$pessoa['caracteristicas'][0]['peso']; ?></td>
			<td><?=$pessoa['caracteristicas'][0]['cor']; ?></td>			
		</tr>
		<? endforeach;?>
	</tbody>
</table>

<script>
	var request = new XMLHttpRequest();
	request.open('GET', 'dados.json', true);
	request.onload = function(){
		var data = JSON.parse(this.response);
		console.log(data);

		for(var i=0; i < data.length; i++){
			document.write(data[i].nome + ' tem '+ data[i].idade + ' e mora em '+ data[i].morada + '<br />');
		}
	};
	request.send();

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
	$(document).ready(function(){
		$.getJSON('dados.json', function(data){
			for(var i=0; i<data.length; i++)
				document.write(data[i].nome+" "+data[i].morada+"<br />");
		});
	});
</script>