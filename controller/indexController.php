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

function getJson(){
    $json_data = file_get_contents("covid_2023.json");
    $covid_data = json_decode($json_data, true);

    return $covid_data;
}

function getPaysData()
{
    $covid_data = getJson();
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
    $covid_data = getJson();
    $data = [];
    foreach ($covid_data['GlobalData'] as $key) {
        $data[] = [
            'Date' => substr($key['Date'], 0, strpos($key['Date'], "T")),
            'Infection' => $key['Infection'],
            'Deces' => $key['Deces'],
            'TauxDeces' => $key['TauxDeces'],
        ];
    }
// TODO sort by variable
// TODO select les valeurs
    return $data;
}

function getOnePaysData(string $pays)
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

function getMultiplePaysData(array $pays_array){
    $all_pays = getPaysData();
    $pays_data = [];

    // * Transformation string en array
    // $paramValue = "France,Brésil,Inde,Chine";
    // $array = explode(",", $paramValue);
    // $array = array_map('trim', $array);
    // var_dump($array);

    foreach ($all_pays as $key)
    {
        foreach($pays_array as $pays){
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
    }
    return $pays_data;

}

function getPaysTotalDeces(){
    $pays_data = getPaysData();

    $pays_death = [];
    foreach ($pays_data as $covid) {
        if ($covid['Date'] == '2023-03-09') {
            $pays_death[] = [
                'Deces' => $covid['Deces'],
                'Pays' => $covid['Pays']
            ];
        }
    }
    rsort($pays_death);

    return $pays_death;
}

function getTotalDeces(){
    $pays_death = getPaysTotalDeces();
    $death = [];

    foreach($pays_death as $key){
        $death[] = intval($key['Deces']);
    }

    $death_json = json_encode($death);

    return $death_json;
}

function getTotalPays(){
    $pays_death = getPaysTotalDeces();
    $pays = [];

    foreach($pays_death as $key){
        $pays[] = $key['Pays'];
    }

    $pays_json = json_encode($pays);

    return $pays_json;
}

/**
 *Cette fonction récupère un tableau avec les données définit par les paramètres.
 * @param $global_or_pays 'GlobalData' ou 'PaysData' pour choisir la bdd.
 * @param bool $date true pour récupérer les dates, sinon false.
 * @param bool $pays true pour récupérer les pays, sinon false.
 * @param bool $infection true pour récupérer les infection, sinon false.
 * @param bool $deces true pour récupérer les deces, sinon false.
 * @param bool $taux_deces true pour récupérer les taux_deces, sinon false.
 *
*/
function getChosenData(
    string $global_or_pays,
    bool $date,
    bool $pays,
    bool $infection,
    bool $deces,
    bool $taux_deces,
)
{
    $covid_data = getJson();
    $data_source = $global_or_pays == 'pays' ? 'PaysData' : 'GlobalData';
    $data = [];
    foreach ($covid_data[$data_source] as $key) {
        $data_items = [];
        if($date){$data_items['Date'] = substr($key['Date'], 0, strpos($key['Date'], "T"));}
        if($pays){$data_items['Pays'] = $key['Pays'];}
        if($infection){$data_items['Infection'] = $key['Infection'];}
        if($deces){$data_items['Deces'] = $key['Deces'];}
        if($taux_deces){$data_items['TauxDeces'] = $key['TauxDeces'];}

        $data[] = $data_items;
    }

    return $data;

    // TODO: Filtrer (par exemple date = 12 juin)
    // TODO: Trier (par exemple par plus haut décès)
}

function sortData(array $data, string $sort){

$sorted_data = sort($data);

}

function oneFilterData(array $data, $pays_filter){
$filtered_data = [];
if(is_string($pays_filter)){$filter_array = explode(",", $pays_filter);}else{$filter_array = $pays_filter;}
$filter_array = array_map('trim', $filter_array);

foreach($data as $key){
    foreach($filter_array as $filter_item){
        if(in_array($filter_item, $key)){
            $filtered_data[] = $key;
        }
    }
}

return $filtered_data;
}

function dateIntervalFilterData(array $data, string $date_filter){

    $filter_array = explode(",", $date_filter);
    $filter_array = array_map('trim', $filter_array);

    foreach($data as $key){
        if($key['Date'] >= $filter_array[0] && $key['Date'] <= $filter_array[1]){
            $filtered_data[] = $key;
        }
    }

    return $filtered_data;
}

function multipleFilterData(
    array $data,
    string $date,
    string $pays,
    string $infection,
    string $deces,
    string $taux_deces,
    )
{
    $data_filter = [];
    $filtered_data = [];

    !empty($date) ? $data_filter[] = " \$key['Date'] $date " : "";
    !empty($pays) ? $data_filter[] = " \$key['Pays'] $pays " : "";
    !empty($infection) ? $data_filter[] = " \$key['Infection'] $infection " : "";
    !empty($deces) ? $data_filter[] = " \$key['Deces'] $deces " : "";
    !empty($taux_deces) ? $data_filter[] = " \$key['TauxDeces'] $taux_deces " : "";

    $filter_string = implode(" && ", $data_filter);
    // var_dump($filter_string);



    foreach($data as $key){
        $include_key = eval("return $filter_string;");
        if($include_key OR $filter_string == ""){
            $filtered_data[] = $key;
        }
    }
    return $filtered_data;
}

function removeFilterFromUrl($get_to_remove, $filter_to_remove){
    $get_to_remove = $get_to_remove.urlencode($filter_to_remove);
    $new_url = str_replace($get_to_remove, "",$_SERVER['REQUEST_URI']);

    return $new_url;
}

function getDateInterval($startDate, $endDate){

    // Create DateTime objects for the start and end dates
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    // Calculate the number of days between the start and end dates
    $interval = $startDateTime->diff($endDateTime);
    $numberOfDays = $interval->days;

    // Loop through each day in the date range
    $currentDateTime = $startDateTime;

    $date_interval_array = [];

    for ($i = 0; $i <= $numberOfDays; $i++) {
        // Format the current date as a string and do something with it
        $currentDate = $currentDateTime->format('Y-m-d');
        $date_interval_array[] = $currentDate;
        $currentDateTime->modify('+1 day');
    }

    return $date_interval_array;

}

