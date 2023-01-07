<?php

require('../../_app/Config.inc.php');

$state = filter_input(INPUT_POST, 'estado', FILTER_VALIDATE_INT);

$state = (int) strip_tags(trim($state));
$readCities = new Read;
$readCities->exeRead("app_cities", "WHERE state_id = :uf", ['uf' => $state]);

sleep(1);

echo "<option value=\"\" disabled selected> Selecione a cidade </option>";
foreach ($readCities->getResult() as $city):
    extract($city);
    echo "<option value=\"{$city_id}\"> {$city_name} </option>";
endforeach;
