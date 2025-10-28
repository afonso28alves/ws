<?
$data = file_get_contents('dados3.json');
$jsonObjs = json_decode($data);
//print_r($jsonObjs);
$listapessoas = $jsonObjs->listapessoas->pessoas;
//print_r($listapessoas);
?>

<table border=1>
	<tbody>
		<tr>
			<th>Nome</th>
			<th>Idade</th>
			<th>Caracteristicas</th>
			<th>Foto</th>
		</tr>
		<? foreach($listapessoas as $pessoa):?>
		<tr>
			<td><?=$pessoa->nome; ?></td>
			<td><?=$pessoa->idade; ?></td>
			<?
				$carGerais = $pessoa->dados[0];
				$carHob = $pessoa->dados[1];
				//print_r($carProf);
			?>
			<td>
				<ul>Características Gerais
					<li><?=$carGerais->morada; ?></li>
					<li><?=$carGerais->idolo; ?></li>
				</ul>
				<ul>Características Hobbies
				<li><?=$carHob->hobbies; ?></li>
				<li><?=$carHob->serie; ?></li>
				</ul>
			</td>
			<td>
				<img src="<?=$pessoa->url_foto; ?>" alt="x" style="width:100px">
			</td>
		</tr>
		<? endforeach;?>
	</tbody>
</table>

<!-- PRODUTOS -->
<?
$listaprodutos = $jsonObjs->listaprodutos->produtos;
?>
<table border=1>
	<tbody>
		<tr>
			<th>ID</th>
			<th>Descrição</th>
			<th>Preço</th>
		</tr>
		<? foreach($listaprodutos as $produto):?>
		<tr>
			<td><?=$produto->id; ?></td>
			<td><?=$produto->descricao; ?></td>
			<td><?=$produto->preco; ?></td>
		</tr>
		<? endforeach;?>
	</tbody>
</table>