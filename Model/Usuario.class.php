<?php
include_once 'conexao.php';

class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $celular;
    private $papeis = array();

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getCelular(){
        return $this->celular;
    }

    public function setCelular($celular){
        $this->celular = $celular;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getPapeis(){
        return $this->papeis;
    }

    public function setPapel($papel){
        if(!is_array($this->papeis)){
            $this->papeis = array();
        }
        $this->papeis[] = $papel;
    }

    public function save()
    {
        $pdo = conexao();
        try{
            $stmt1 = $pdo->prepare('INSERT INTO usuario (nome, email, senha, celular) VALUES(:nome, :email, :senha, :celular)');
            $stmt1->execute([
                ':nome' => $this->nome,
                ':email' => $this->email,
                ':senha' => $this->senha,
                ':celular' => $this->celular
            ]); 
            $this->id = $pdo->lastInsertId();
            foreach($this->papeis as $papel){
                $stmt2 = $pdo->prepare('INSERT INTO papel_usuario (fk_papel, fk_usuario) VALUES(:papel, :id)');
                $stmt2->execute([
                    ':papel' => $papel,
                    ':id' => $this->id
                ]); 
            }
            return true;
        }catch(Exception $e){
            //Log 
            return false;
        }
    }

    public function update()
    {
        $pdo = conexao();
        try{
            $stmt = $pdo->prepare('UPDATE usuario SET nome = :nome, email = :email, senha = :senha, celular = :celular WHERE id = :id');
            $stmt->execute([
                ':nome' => $this->nome,
                ':email' => $this->email,
                ':senha' => $this->senha,
                ':celular' => $this->celular,
                ':id' => $this->id
            ]);
            return true;
        }catch(Exception $e){
            //Log 
            return false;
        }
    }

    public static function deletar($id){
        $pdo = conexao();
        
        $stmt1 = $pdo->prepare('DELETE FROM papel_usuario WHERE fk_usuario = :id');
        $stmt1->execute([
            ':id' => $id
        ]);
    
        $stmt2 = $pdo->prepare('DELETE FROM usuario WHERE id_usuario = :id');
        $stmt2->execute([
            ':id' => $id
        ]);
    }

    public static function getAll(){
        $pdo = conexao();
        $stmt = $pdo->prepare('SELECT * FROM usuario INNER JOIN papel_usuario ON usuario.id_usuario = papel_usuario.fk_usuario');
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    }

    public function getPapeisUsuario($id) {
        $pdo = conexao();
        $stmt = $pdo->prepare('SELECT fk_papel FROM papel_usuario WHERE fk_usuario = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $papeis = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $papeis;
    }

}