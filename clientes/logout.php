<?
session_start();
session_destroy(); // Destrói a sessão limpando todos os valores salvos
?>

<script language = 'javascript'> 
    alert('Você saiu do sistema!')
    location.href = '../login.php?'; 
</script>	