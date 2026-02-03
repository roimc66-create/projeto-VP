<?php
// Garante fuso horário do Brasil
date_default_timezone_set('America/Sao_Paulo');

// Dia atual
$dia = date('d');

// Mês atual (numérico)
$mes_num = date('m');

// Mapa de meses em português
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

// Sigla do mês
$mes = $meses[$mes_num];
?>