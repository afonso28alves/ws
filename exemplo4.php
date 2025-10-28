<?
$data = file_get_contents('dados3.json');
$genericos = json_decode($data);
// print_r($genericos);
$listapessoas = $genericos->listapessoas->pessoas;    
//print_r($listapessoas);
?>

<table border = 1>
    <tbody>
        <tr>
            <th>Foto de Perfil</th>
            <th>Nome</th>
            <th>Idade</th>
            <th>Dados</th>
        </tr>
        <?foreach($listapessoas as $pessoa):?> 
        <tr> 
            <td>
                <img src="<?=$pessoa->url_foto;?>"alt="x"style="width:100px;" />
            </td>
            <td><?=$pessoa->nome;?></td>
            <td><? echo $pessoa->idade;?></td>
            <?
                $dadosLocais = $pessoa->dados[0];
                $dadosGostos = $pessoa->dados[1];
                //print_r($carProfissionais);
            ?>
            <td>
                <ul>    Pessoais
                    <li><?=$dadosLocais->morada;?></li>
                    <li><?=$dadosLocais->idolo;?></li>
                </ul>
                <ul>Gostos
                    <li><?=$dadosGostos->hobbies;?></li>
                    <li><?=$dadosGostos->serie;?></li>
                </ul>
            </td>
        </tr>
        <?endforeach;?>
    </tbody>
</table>
<?
$listaprodutos = $genericos->listaprodutos->produtos;    
//print_r($listaprodutos);
?>
<table border =1>
    <tbody>
        <tr>
            <th>Id</th>
            <th>Descrição</th>
            <th>Preço</th>
        </tr>
        <?foreach($listaprodutos as $produto):?> 
        <tr>
            <td><?=$produto->id;?></td>
            <td><?=$produto->descricao;?></td>
            <td><? echo $produto->preco;?></td>
        </tr>
        <?endforeach;?>
    </tbody>