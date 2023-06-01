<?php
include_once '../model/Usuario.class.php';
$usuarios = Usuario::getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body class="text-white bg-dark">
<h2>Usuários</h2>
<table class="table table-dark">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <?php if ($usuario['fk_papel'] == 1): ?>
                <tr>
                    <td><?= $usuario['nome']; ?></td>
                    <td><?= $usuario['email']; ?></td>
                    <td><?= $usuario['celular']; ?></td>
                    <td>
                    <button class="btn btn-danger btn-excluir-usuario" data-id="<?= $usuario['id_usuario']; ?>">Excluir</button>
                    <button class="btn btn-success btn-editar-usuario" data-id="<?= $usuario['id_usuario']; ?>">Editar</button>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<br><br>
<h2>Administradores</h2>
<table class="table table-dark">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <?php if ($usuario['fk_papel'] == 2): ?>
                <tr>
                    <td><?= $usuario['nome']; ?></td>
                    <td><?= $usuario['email']; ?></td>
                    <td><?= $usuario['celular']; ?></td>
                    <td>
                    <button class="btn btn-danger btn-excluir-usuario" data-id="<?= $usuario['id_usuario']; ?>">Excluir</button>
                    <button class="btn btn-success btn-editar-usuario" data-id="<?= $usuario['id_usuario']; ?>">Editar</button>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<br><br>
<div id="form-edicao-papeis" style="display: none;">
    <h3>Editar Papéis do Usuário</h3>
    <form method="POST" action="../controller/Usuario.php?acao=atualizar">
        <input type="hidden" name="id" id="usuario-id">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="papeis[]" value="1">
            <label class="form-check-label">Usuario</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="papeis[]" value="2">
            <label class="form-check-label">Administrador</label>
        </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<br><br>
<div><button type="button" class="btn btn-warning" onclick="troca()">Cadastrar mais pessoas</button></div>
<script>
    var btnExcluirUsuarios = document.querySelectorAll('.btn-excluir-usuario');
    btnExcluirUsuarios.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var idUsuario = this.getAttribute('data-id');
            if (confirm('Deseja mesmo excluir este usuário?')) {
                window.location.href = '../controller/Usuario.php?acao=deletar&id=' + idUsuario;
            }
        });
    });
    function troca() {
        window.location.href = "Index.html";
    }
    function handleEditarUsuario(event) {
        var usuarioId = event.target.dataset.id;
        var checkboxUsuario = document.querySelector('input[name="papeis[]"][value="1"]');
        var checkboxAdministrador = document.querySelector('input[name="papeis[]"][value="2"]');
        var formEdicaoPapeis = document.getElementById('form-edicao-papeis');

        checkboxUsuario.checked = false;
        checkboxAdministrador.checked = false;

        var papeisUsuario = Usuario.getPapeisUsuario(usuarioId);
        marcarCheckboxesPapeis(papeisUsuario);

        document.getElementById('usuario-id').value = usuarioId;
        formEdicaoPapeis.style.display = 'block';
    }

var botoesEditar = document.querySelectorAll('.btn-editar-usuario');
botoesEditar.forEach(function (botao) {
  botao.addEventListener('click', handleEditarUsuario);
});

var botoesEditar = document.querySelectorAll('.btn-editar-usuario');
botoesEditar.forEach(function (botao) {
    botao.addEventListener('click', handleEditarUsuario);
});
function marcarCheckboxesPapeis(papeisUsuario) {
  var checkboxUsuario = document.querySelector('input[name="papeis[]"][value="1"]');
  var checkboxAdministrador = document.querySelector('input[name="papeis[]"][value="2"]');
  
  checkboxUsuario.checked = papeisUsuario.includes("1");
  checkboxAdministrador.checked = papeisUsuario.includes("2");
}
</script>
</body>
</html>