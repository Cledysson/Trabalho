<?php $erro=Array();

include("conexao/conexao.php");

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
			$sql_code = "INSERT INTO usuarios(nome,
			 cpf,
			  email,
			  senha,
			  telefone)
			  VALUES(
			  '$_SESSION[nome]',
			  '$_SESSION[cpf]',
			  '$_SESSION[email]',
			  '$senha',
			  '$_SESSION[telefone]'
			  )";
			  
			  $confirma = $mysqli->query($sql_code) or die ($mysqli->error);

			  if($confirma){
			  	unset($_SESSION[nome],
			  	$_SESSION[cpf],
			  	$_SESSION[email],
			  	$_SESSION[senha],
			  	$_SESSION[telefone]);

				echo "<script>location.href='index.php?p=inicial'; </script>";
			  }else
			  	$erro[] = $confirma;
		}
	}
?>
<h1>Cadastrar Usuário</h1>
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
<form action="index.php?p=cadastrar" method="POST">
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
	<label for="senha">Senha(entre 8 e 16 caracteres.)</label>
	<input required type="password" name="senha" >
	<p class="espaco"></p>
	<label for="rsenha">Repita a Senha</label>
	<input required type="password" name="rsenha">
	<p class="espaco"></p>
	<input type="submit" value="Cadastrar" name="confirmar">
</form>