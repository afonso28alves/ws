<?
$data = file_get_contents('dados4.json');
$jsonObjs = json_decode($data);
//print_r($jsonObjs);
$listausers = $jsonObjs->users;
//print_r($listausers);
?>

<table border=1>
	<tbody>
		<tr>
			<th>Nome</th>
			<th>Idade</th>
		</tr>
		<? foreach($listausers as $user):?>
		<tr>
			<td><?=$user->user; ?></td>
			<td><?=$user->password; ?></td>		
		</tr>
		<? endforeach;?>
	</tbody>
</table>

<?
$listaclientes = $jsonObjs->listaclientes->clientes;    
//print_r($listaclientes);
?>

<table border=1>
	<tbody>
		<tr>
			<th>Nome</th>
			<th>Tipo</th>
			<th>Saldo</th>
		</tr>
		<? foreach($listaclientes as $cliente):?>
		<tr>
			<td><?=$cliente->nome; ?></td>
			<td><?=$cliente->tipo; ?></td>
			<td><?=$cliente->saldo; ?></td>		
		</tr>
		<? endforeach;?>
	</tbody>
</table>

<?
$listaimoveis = $jsonObjs->listaimoveis->imoveis;    
//print_r($listaimoveis);
?>

<table border=1>
	<tbody>
		<tr>
			<th>Descrição</th>
			<th>Preço</th>
			<th>Tipologia</th>
			<th>Localização</th>
			<th>Detalhes</th>
		</tr>
		<? foreach($listaimoveis as $imovel):?>
		<tr>
			<td><?=$imovel->descricao; ?></td>
			<td><?=$imovel->preco; ?></td>
			<td><?=$imovel->tipologia; ?></td>
			<td><?=$imovel->localizacao; ?></td>
			<td><?
				if(property_exists($imovel, "details")):
					$ldetails = $imovel->details;
					foreach($ldetails as $v):?>
						<ul><?
						foreach($v as $k => $val):?>	
								<li><?=$k;?>:<?=$val?></li>	
						<?endforeach;?>
						</ul><?
					endforeach;
				else:
					echo "Imóvel sem details";
				endif;
				
			?></td>		
		</tr>
		<? endforeach;?>
	</tbody>
</table>