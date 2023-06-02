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
    exit();
} else if($acao == 'deletar'){
    Usuario::deletar($_REQUEST['id']);
    header('Location:../view/Cadastros.php ');
    exit();
} else if($acao =='atualizar'){
    $idUsuario = $_POST['usuario-id'];
    if (isset($_POST['papeis'])) {
        $papeisSelecionados = $_POST['papeis'];
        Usuario::update1($idUsuario);
        foreach ($papeisSelecionados as $idPapel) {
            Usuario::update2($idUsuario, $idPapel);
        }
    header('Location:../view/Cadastros.php ');
    exit();
    }
}  
?>