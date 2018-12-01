<?php $erro=Array();

include("conexao/conexao.php");

if(!isset($_GET['usuario']))
echo "<script> alert('Código Inválido.'); location.href='index.php?p=inicial'; </script>";
else{

$usu_codigo = intval($_GET['usuario']);

if(isset ($_POST['confirmar'])){

	//Registro de dados
	
	if(!isset($_SESSION))
		session_start();
	foreach($_POST as $chave=>$valor)
		$_SESSION[$chave] = $mysqli->real_escape_string($valor);
	
	//Validação dos dados
	if(strlen($_SESSION['nome']) == 0)
		$erro[] = "Preencha o nome.";

	if(strlen($_SESSION['cpf']) == 0)
		$erro[] = "Preencha o CPF.";

	if(substr_count($_SESSION['email'],'@') != 1 || substr_count($_SESSION['email'],'.') < 1)
		$erro[] = "Preencha o e-mail corretamente.";

	if(strlen($_SESSION['telefone']) == 0)
		$erro[] = "Preencha o Telefone.";

	if(strlen($_SESSION['senha']) < 8 || strlen($_SESSION['senha']) > 16 )
		$erro[] = "Preencha a senha corretamente.";

	if(strcmp($_SESSION['senha'], $_SESSION['rsenha']) != 0)
		$erro[] = "As senhas não batem.";

	//Inserção no banco de dados e redirecionamento
		if(count($erro) == 0){
			$senha = md5(md5($_SESSION['senha']));
			
			$sql_code = "UPDATE usuarios SET
			nome = '$_SESSION[nome]',
			cpf = '$_SESSION[cpf]',
			email = '$_SESSION[email]',
			telefone = '$_SESSION[telefone]',
			senha = '$senha'
			WHERE codigo = '$usu_codigo'";
			  
			  $confirma = $mysqli->query($sql_code) or die ($mysqli->error);

			  if($confirma){
			  	unset($_SESSION[nome],
			  	$_SESSION[scpf],
			  	$_SESSION[email],
			  	$_SESSION[telefone],
			  	$_SESSION[senha]);

				echo "<script>location.href='index.php?p=inicial'; </script>";
			  }else
			  	$erro[] = $confirma;
		}else{

			$sql_code = "SELECT * FROM usuarios WHERE codigo = '$usu_codigo'";
			$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
			$linha = $sql_query->fetch_assoc();

				if(!isset($_SESSION))
				session_start();

				$_SESSION[nome] = $linha['nome'];
			  	$_SESSION[cpf] = $linha['cpf'];
			  	$_SESSION[email] = $linha['email'];
			  	$_SESSION[senha] = $linha['senha'];
			  	$_SESSION[telefone] = $linha['telefone'];
	}
}
?>
<h1>Editar Usuário</h1>
<?php 
if(count($erro) > 0){ 
	echo "<div class='erro'>";
	foreach($erro as $valor) 
	echo "$valor <br>";
	echo "</div>";
}
?>
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
<a href="index.php?p=inicial">Voltar</a>
<p class="espaco"></p>
<form action="index.php?p=editar&usuario=<?php echo $usu_codigo; ?>" method="POST">
	<label for="nome">Nome</label>
	<input required type="text" name="nome">
	<p class="espaco"></p>
	<label for="cpf">CPF</label>
	<input required type="text" name="cpf">
	<p class="espaco"></p>
	<label for="email">E-mail</label>
	<input required type="email" name="email">
	<p class="espaco"></p>
	<label for="telefone">Telefone</label>
	<input required type="telefone" name="telefone">
	<p class="espaco"></p>
	<label for="senha">Senha(Entre 8 e 16 caracteres.)</label>
	<input required type="password" name="senha" >
	<p class="espaco"></p>
	<label for="rsenha">Repita a Senha</label>
	<input required type="password" name="rsenha">
	<p class="espaco"></p>
	<input type="submit" value="Salvar" name="confirmar">
</form>
<?php } ?>