<!DOCTYPE html>
<html>
<head>
  <title>PHP File Upload</title>
</head>
<body>
  <form method="POST" action="proc_retorno.php" enctype="multipart/form-data">
    <div class="upload-wrapper">
      <label for="file-upload">
        <input type="file" id="file-upload" name="arquivo">
    </label>
    </div>
 
    <input type="submit" name="send" value="Enviar" />
  </form>
</body>
</html>