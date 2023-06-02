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
    <p>Selecione os papeis que o usuario deve ter</p>
    <form method="POST" action="../controller/Usuario.php?acao=atualizar">
        <input type="hidden" name="usuario-id" id="usuario-id">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="papeis[]" value="1">
            <label class="form-check-label">Usuario</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="papeis[]" value="2">
            <label class="form-check-label">Administrador</label>
        </div>
    <button type="submit" id="saveEdit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<br><br>
<div><button type="button" class="btn btn-warning" onclick="troca()">Cadastrar mais pessoas</button></div>
<script>
    document.getElementById('saveEdit').addEventListener('click', function(event) {
        var checkboxes = document.querySelectorAll('input[name="papeis[]"]');
        var selecionado = false;
    
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selecionado = true;
                break;
            }
        }
        if (!selecionado) {
            event.preventDefault();
            alert('Selecione pelo menos um papel.');
        } else {
            var usuarioId = document.getElementById('usuario-id').value;
            var form = document.getElementById('form-edicao-papeis');
            var action = form.getAttribute('action');
            form.setAttribute('action', action + '&id=' + usuarioId);
            alert("Papeis editados!");
        }
    });

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
        document.getElementById('form-edicao-papeis').style.display = 'block';
        document.getElementById('usuario-id').value = usuarioId;
    }

    var botoesEditar = document.querySelectorAll('.btn-editar-usuario');
        botoesEditar.forEach(function(botao) {
            botao.addEventListener('click', function() {
                var usuarioId = this.getAttribute('data-id');
                document.getElementById('usuario-id').value = usuarioId;
                document.getElementById('form-edicao-papeis').style.display = 'block';
        });
    });

</script>
</body>
</html>