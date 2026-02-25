<?php

date_default_timezone_set('America/Sao_Paulo');

$dia = date('d');

$mes_num = date('m');

$meses = [
  '01' => 'JAN',
  '02' => 'FEV',
  '03' => 'MAR',
  '04' => 'ABR',
  '05' => 'MAI',
  '06' => 'JUN',
  '07' => 'JUL',
  '08' => 'AGO',
  '09' => 'SET',
  '10' => 'OUT',
  '11' => 'NOV',
  '12' => 'DEZ'
];

$mes = $meses[$mes_num];
?>