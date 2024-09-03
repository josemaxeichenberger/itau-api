<?php
session_status();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'cliente') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
}
  function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $html = curl_exec($ch);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  }

  function commodities() {
    $urlHTML = curl_get_contents('https://br.investing.com/commodities/grains');
    $dom = new DOMDocument();
    @$dom->loadHTML($urlHTML);

    $table = $dom->getElementsByTagName('table')[0];
    $tbody = $table->getElementsByTagName('tbody')[0];
    $trs = $tbody->getElementsByTagName('tr');
    $valores = [];
    foreach ($trs as $tr) {
      $tds = $tr->getElementsByTagName('td');
      $a = $tds[1]->getElementsByTagName('a')[0];
      $valores[$a->nodeValue] = $tds[3]->nodeValue;
    }

    return $valores;
  }

    $comms = commodities();
    echo '<br>soja: '.$comms['Soja'];
    echo '<br>milho: '.$comms['Milho'];

?>