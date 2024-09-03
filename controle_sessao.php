<?php
session_start();
if (!isset($_SESSION['logado'])) {
?>
    <script language="JavaScript">
        location.href = "login.php"
    </script>
<?php
    return false;
}if (!isset($_SESSION['razao'])) {
    ?>
    <script language="JavaScript">
        location.href = "login.php"
    </script>
<?php
    return false;

}
?>