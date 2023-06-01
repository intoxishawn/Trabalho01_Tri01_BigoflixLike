<?php
$acao = $_GET['acao'];

include_once '../model/Usuario.class.php';

if ($acao == 'cadastrar'){
    $usuario = new Usuario();
    $usuario->setNome($_POST['nome']);
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha($_POST['senha']);
    $usuario->setCelular($_POST['celular']);
    if(isset($_POST['papeis']))
    {
        foreach($_POST['papeis'] as $papel)
        {
            $usuario->setPapel($papel);
        }
    }
    $usuario->save();
    header('Location:../view/Index.html');
} else if($acao == 'deletar'){
    Usuario::deletar($_REQUEST['id']);
    header('Location:../view/Cadastros.php ');
} else if($acao =='atualizar'){
    $usuario = new Usuario();
    $usuario->setId($_POST['id']);
    $usuario->setNome($_POST['nome']);
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha($_POST['senha']);
    $usuario->setCelular($_POST['celular']);
    $usuario->update();
    header('Location:../view/Cadastros.php ');
} else if($acao == 'consultar-papeis') {
    $usuarioId = $_GET['id'];
    $usuario = Usuario::getById($usuarioId);
    $papeis = $usuario->consultaPapeis();
    echo json_encode(['papeis' => $papeis]);
    exit;
}  
?>