<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simular Operações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <form 
      action="/simulate"
      method="POST"
      enctype="multipart/form-data"
      class="container my-5">
      <h1 class="mb-3">Simular operações</h1>
      <div class="mb-3">
        <label for="formFile" class="form-label">Operações</label>
        <input class="form-control" type="file" id="formFile" name="operacoes" required>
      </div> 
      <div class="mb-3">
        <label for="formFile" class="form-label">Cotações do Periodo</label>
        <input class="form-control" type="file" id="formFile" name="cotacoes" required>
      </div> 
      <button type="submit" class="btn btn-success mt-3">Enviar</button>
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>