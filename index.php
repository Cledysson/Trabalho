<!DOCTYPE html>
<html>
<head>
	<title>Pizzaria Ifome</title>
	<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
</head>
<body>
<div class=principal>
	<?php
	if(isset($_GET['p'])){
		$pagina = $_GET['p'].".php";
		if(is_file("$pagina"))
			include("$pagina");
		else
			include("404.php");
		}else
		include("inicial.php");
	?>
</div>
</body>
</html>