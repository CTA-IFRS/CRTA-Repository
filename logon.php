
<?php
include("conexao.php");
if (isset($_POST['email']) && strlen($_POST['email']) > 0) {
	if (!isset($_SESSION))
		session_start();
    session_unset();
	$_SESSION['email'] = $mysqli->escape_string($_POST['email']);
 $_SESSION['senha'] = md5(md5($_POST['senha']));

 $sql_code = "SELECT senha, codigo FROM usuario WHERE email = '$_SESSION[email]'";
 $sql_query = $mysqli->query($sql_code) or die ($mysqli->error);
 $dado = $sql_query->fetch_assoc();
 $total = $sql_query->num_rows;

 if($total == 0){
  $erro[] = "E-mail incorreto.";
 }else{
  if($dado['senha'] == $_SESSION['senha']){
   $_SESSION['usuario'] = $dado['codigo'];
  }else{
   $erro[] = "Senha incorreta.";
  }

 if(count($erro) == 0 || !isset($erro)){
  echo "<script>alert('Login efetuado com sucesso'); location.href='sucesso.php'</script>";
 }
 }
if (count($erro) == 0 || !isset($erro)) {
	echo "<script>alert ('Login efetuado com sucesso'); location.href='sucesso.php';</script>";
}
}

?><html lang="pt-br">
  <head>
    <title>Repositório de TA</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
<style>
div {
  padding: 30px;
}
</style>

  </head>

  <body>
<!-- Barra do governo -->
<!--<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;">
  <ul id="menu-barra-temp" style="list-style:none;">
    <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
        <a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a>
    </li>
  </ul>
</div>
-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: #2B67BD">
<a class="navbar-brand" href="index.html">
<img src="imgs/cta.png">
</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite" aria-controls="navbarSite" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSite">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
      </li>
                    <li class="nav-item">
            <a class="nav-link" href="#">Serviços</a>
          </li>
                    <li class="nav-item">
            <a class="nav-link" href="#">Sobre</a>
          </li>
                    <li class="nav-item">
            <a class="nav-link" href="#">Parceiros</a>
          </li>

        </ul>
            
  </li>
</ul>

        <ul class="navbar-nav ml-auto">
           <a href="https://www.facebook.com/acessibilidadevirtual"><img border="0" src="imgs/Faceboo.png" /></a>
            <a href="https://www.youtube.com/user/AcessibilidadeCanal"><img border="0" src="imgs/YouTub.png" /></a>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="buscar..." aria-label="Buscar">

          <button class="btn btn-default-success my-2 my-sm-0" type="Submit">Buscar</button>
        </form>
      </div>

    </nav>
<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12"  align="center">
  <div class="container">
    
</div>
</div>

</div>

    <!-- Logon -->
 <div class="container">
 	
 	<?php if (count($erro) > 0)
 	foreach ($erro as $msg) {
 		echo "<p>$msg</p>";
 	}

 	?>

<form method="POST" action="">
	<p><input value="<?php echo $_SESSION['email']; ?>" name="email" placeholder="E-mail" type="text"></p>
	<p><input  name="senha"  type="text"></p>
	<p><a href="">Esqueceu a senha?</a></p>
	<p><input  value="Entrar" type="submit"></p>
</form>


<!-- compartilhar em redes -->

<div class="col-12 mb-1">  </div>

  <div class="container">
<div class="float-right">

          <a href="url"><img border="0" src="imgs/share.png" /></a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fcta.ifrs.edu.br%2Fcrta%2Fo-que-e-o-crta%2F"><img border="0" src="imgs/Face.png" /></a>
          <a href="https://twitter.com/intent/tweet?text=O%20que%20%C3%A9%20o%20CRTA&url=https%3A%2F%2Fcta.ifrs.edu.br%2Fcrta%2Fo-que-e-o-crta%2F"><img border="0" src="imgs/twit.png" /></a>
          <a href="https://cta.ifrs.edu.br/crta/o-que-e-o-crta/"><img border="0" src="imgs/link.png" /></a>
          <a href="https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fcta.ifrs.edu.br%2Fcrta%2Fo-que-e-o-crta%2F&media=&description=O%20que%20%C3%A9%20o%20CRTA"><img border="0" src="imgs/Pint.png" /></a>

</div>

<div class="col-12 mb-1">  </div>
</div>

<div class="col-12 mb-1">  </div>


</div>


  
</div>

<!-- Footer -->

<footer class="container-fluid  text-left py-5" style="background-color: #2B67BD">
      <div class="row">
        
        <div class="col-6 col-md">
          <h5>INSTITUCIONAL</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-light" href="#">Histórico</a></li>
            <li><a class="text-light" href="#">Equipe</a></li>
            <li><a class="text-light" href="#">Serviços</a></li>
            <li><a class="text-light" href="#">Documentos norteadores</a></li>
            <li><a class="text-light" href="#">Localização</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>ACESSIBILIDADE DIGITAL</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-light" href="#">Conceito</a></li>
            <li><a class="text-light" href="#">Documentos e Ferramentas</a></li>
            <li><a class="text-light" href="#">Dicas</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>TECNOLOGIA ASSISTIVA</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-light" href="#">O que é TA</a></li>
            <li><a class="text-light" href="#">Nosso laboratório de TA</a></li>
            <li><a class="text-light" href="#">Nossos recursos de TA</a></li>
            <li><a class="text-light" href="#">Ferramentas gratuítas de Tecnologia Assistivas</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>PROJETO CRTA</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-light" href="#">O que é o CRTA</a></li>
            <li><a class="text-light" href="#">Ações do CRTA</a></li>
            <li><a class="text-light" href="#">Repositório de TA</a></li>
            <li><a class="text-light" href="#">Equipe</a></li>

          </ul>

          

        </div>
        <div class="col-12 col-md">
         <img src="imgs/Logo IF.png" href="https://ifrs.edu.br/"> <small class="d-block mb-3 text-light">&copy; 2020</small>
              <a class="text-light" href="#">Avenida Osvaldo Aranha, 540 CEP: 95700-206, Bento Gonçalves – RS E-mail: cta@ifrs.edu.br Telefone: (54) 3455-3261</a>
        </div>
      </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </body>
</html>