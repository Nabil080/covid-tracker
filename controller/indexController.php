<?php

function dashboard()
{
    require('view/dashboard.php');
}

function test()
{
    require('view/randomview.php');
}

function classements()
{
    require('view/classements.php');
}

function table()
{
    require('view/table.php');
}

function getPaysData()
{
    $json_data = file_get_contents("covid_2023.json");
    $covid_data = json_decode($json_data, true);
    $data = [];
    foreach ($covid_data['PaysData'] as $key) {
        $data[] = [
            'Date' => substr($key['Date'], 0, strpos($key['Date'], "T")),
            'Pays' => $key['Pays'],
            'Infection' => $key['Infection'],
            'Deces' => $key['Deces'],
            'TauxDeces' => $key['TauxDeces'],
        ];
    }

    return $data;
}

function getGlobalData()
{
    $json_data = file_get_contents("covid_2023.json");
    $covid_data = json_decode($json_data, true);
    $data = [];
    foreach ($covid_data['GlobalData'] as $key) {
        $data[] = [
            'Date' => substr($key['Date'], 0, strpos($key['Date'], "T")),
            'Infection' => $key['Infection'],
            'Deces' => $key['Deces'],
            'TauxDeces' => $key['TauxDeces'],
        ];
    }

    return $data;
}

function getOnePaysData($pays)
{
    $all_pays = getPaysData();
    $pays_data = [];
    foreach ($all_pays as $key)
    {
        if(in_array($pays,$key))
        {
            $pays_data[] = [
                'Date' => $key['Date'],
                'Pays' => $key['Pays'],
                'Infection' => $key['Infection'],
                'Deces' => $key['Deces'],
                'TauxDeces' => $key['TauxDeces'],
            ];
        }
    }

    return $pays_data;
}


