<?php 
require 'conexao.php';
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Morador - Criar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
        <div class=row>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Adicionar Morador
                            <a href="index.html" class="btn btn-danger float-end">Voltar</a>
                        </h4>            
                    </div>
                  <div class="card-body">
                      <form action="createUsuario.php" method="POST">
                      <div class="mb-3">
                        <label for="">Bloco</label>
                        <input type="text" name="bloco" id="" class="form-control">
                      </div>
                      <div class="mb-3">
                        <label for="">Apartamento</label>
                        <input type="text" name="apartamento" id="" class="form-control">
                      </div>
                      <div class="mb-3">
                        <label for="">Morador</label>
                        <input type="text" name="morador" id="" class="form-control" required>
                      </div>                      
                      <div class="mb-3">
                        <button type="submit" name="createUsuario" class="btn btn-primary">Salvar</button>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>