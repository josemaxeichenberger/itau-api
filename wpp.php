<?php

  $iphone  = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
  $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
  $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
  $berry   = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
  $ipod    = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");

  //Verifique se é um celular
  if ($iphone || $android || $palmpre || $ipod || $berry == true){

    header('Location: https://wa.me/554733075808?text=Atendimento%20Plataforma%20LAW%20Smart%20*_Por%20favor,%20n%C3%A3o%20apague%20essa%20mensagem_*');

  }

  //Todos os outros
  else {
    
    header('Location: https://wa.me/554733075808?text=Atendimento%20Plataforma%20LAW%20Smart%20*_Por%20favor,%20n%C3%A3o%20apague%20essa%20mensagem_*');

  }

?>