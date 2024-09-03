<?php
session_start();
if (!$_SESSION['logado']) {
?>
<script language= "JavaScript">
location.href="login.php"
</script>
<?php
return false;
}
?>
