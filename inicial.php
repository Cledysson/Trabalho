<?php
include("conexao/conexao.php");
$sql_code = "SELECT * FROM usuarios";
$sql_query = $mysqli->query($sql_code) or die ($mysqli->error);
$linha = $sql_query->fetch_assoc();
?>
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
<h1>Usuários Pizzaria Ifome</h1>
<nav id="menu">
    <ul>
        <li><a href="index.php?p=cadastrar">Cadastro de Clientes</a></li>
    </ul>
</nav>
<p class="espaco"></p>
<table border=1 cellpadding=10>
	<tr class=titulo>
		<td>Nome</td>
		<td>cpf</td>
		<td>Telefone</td>
		<td>E-mail</td>
		<td>Edição</td>
	</tr>
	<?php
	do{
	?>
	<tr>
		<td><?php echo $linha['nome']; ?></td>
		<td><?php echo $linha['cpf']; ?></td>
		<td><?php echo $linha['telefone']; ?></td>
		<td><?php echo $linha['email']; ?></td>
		<td>
			<a href="index.php?p=editar&usuario=<?php echo $linha['codigo']; ?>">Editar</a>
			
			<a href="javascript: if(confirm('Tem certeza que deseja deletar o usuário <?php echo $linha['nome']; ?>?')) location.href='index.php?p=deletar&usuario=<?php echo $linha['codigo']; ?>';">Deletar</a>
		</td>
	</tr>
	<?php }
	while ($linha = $sql_query->fetch_assoc()); ?>
</table>