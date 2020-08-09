<?php 
$timestamp = strtotime("now");
$stringDate = date('d-m-Y H:i', $timestamp);

$cek1 = strtotime("now");
$cek2 = date('25-6-2020 22:12', $timestamp);

echo "Timestamp: {$timestamp} <br>";
echo "String date: {$stringDate} <br>";

echo "Timestamp: {$cek1} <br>";
echo "String date: {$cek2} <br>";

$isic1 = ($cek1);
$isic2 = ($cek2);
echo "cek 1 : " . $isic1;
echo "cek 2 : " . $isic2;
if($cek1 > $cek2)
{
    echo "ini terlambat str > cek2";
}
else 
{
    echo "ini terlambat str < cek2";
}

//echo "akhir";

?>