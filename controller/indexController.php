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

    return $data;
}

function getUniquePaysList($data){
    $array_pays = [];
    foreach($data as $pays){
        if(!in_array($pays['Pays'], $array_pays)){
            $array_pays[] = $pays['Pays'];
        }
    }
    sort($array_pays);

    return $array_pays;
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

function getPaysTotalDeces(int $number){
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

    $data = [];
    $i = 0;
    foreach ($pays_death as $key){
        if($i <= $number){
            $data[] = $key;
            $i++;
        }
    }
    return $data;
}

function getTotalDeces(int $number){
    $pays_death = getPaysTotalDeces($number);
    $death = [];

    foreach($pays_death as $key){
        $death[] = intval($key['Deces']);
    }

    $death_json = json_encode($death);

    return $death_json;
}

function getTotalPays(int $number){
    $pays_death = getPaysTotalDeces($number);
    $pays = [];

    foreach($pays_death as $key){
        $pays[] = $key['Pays'];
    }

    $pays_json = json_encode($pays);

    return $pays_json;
}

function getPaysTotalInfection(int $number){
    $pays_data = getPaysData();

    $pays_infection = [];
    foreach ($pays_data as $covid) {
        if ($covid['Date'] == '2023-03-09') {
            $pays_infection[] = [
                'Infection' => $covid['Infection'],
                'Pays' => $covid['Pays']
            ];
        }
    }
    rsort($pays_infection);

    $data = [];
    $i = 0;
    foreach ($pays_infection as $key){
        if($i <= $number){
            $data[] = $key;
            $i++;
        }
    }
    return $data;
}

function getTotalInfection(int $number){
    $pays_infection = getPaysTotalInfection($number);
    $infection = [];

    foreach($pays_infection as $key){
        $infection[] = intval($key['Infection']);
    }

    $infection_json = json_encode($infection);

    return $infection_json;
}

function getTotalInfectionPays(int $number){
    $pays_infection = getPaysTotalInfection($number);
    $pays = [];

    foreach($pays_infection as $key){
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

function sortCustomData(array $pays_data,string $sort,string $order){

    if(is_int($pays_data[0][$sort]) OR is_float($pays_data[0][$sort])){echo'ola';
        if($order == 'asc'){
            usort($pays_data, function($a, $b) use ($sort){
                return $a[$sort] - $b[$sort];
            });
        }elseif($order == 'desc'){
            usort($pays_data, function($b, $a) use ($sort){
                return $a[$sort] - $b[$sort];
            });
        }
    }

    if($sort == 'Date'){
        if($order == 'asc'){
            usort($pays_data, function($a, $b) use ($sort){
                return strtotime($a[$sort]) - strtotime($b[$sort]);
            });
        }elseif($order == 'desc'){
            usort($pays_data, function($b, $a) use ($sort){
                return strtotime($a[$sort]) - strtotime($b[$sort]);
            });
        }
    }

    if($sort == 'Date'){
        if($order == 'asc'){
            usort($pays_data, function($a, $b) use ($sort){
                return strtotime($a[$sort]) - strtotime($b[$sort]);
            });
        }elseif($order == 'desc'){
            usort($pays_data, function($b, $a) use ($sort){
                return strtotime($a[$sort]) - strtotime($b[$sort]);
            });
        }
    }

    if($sort == 'Pays'){
        if($order == 'asc'){
            usort($pays_data, function($a, $b) {
                return strcoll($a['Pays'], $b['Pays']);
            });
        }elseif($order == 'desc'){
            usort($pays_data, function($b, $a) {
                return strcoll($a['Pays'], $b['Pays']);
            });
        }
    }

    return $pays_data;

}

function sortData(array $pays_data){

    $_SESSION['sort'] = [];

    $_SESSION['sort']['name'] = isset($_SESSION['sort']['name']) ? $_SESSION['sort']['name'] : 'Date';
    $_SESSION['sort']['order'] = isset($_SESSION['sort']['order']) ? $_SESSION['sort']['order'] : 'desc';

    if(isset($_POST['sort'])){
        $sort_order = explode(",",$_POST['sort']);
        $_SESSION['sort']['name'] = $sort_order[0];
        $_SESSION['sort']['order'] = $sort_order[1];
    }

    $sort = trim($_SESSION['sort']['name']);
    $order = trim($_SESSION['sort']['order']);

    if(isset($pays_data[0])){

        if(is_int($pays_data[0][$sort]) OR is_float($pays_data[0][$sort])){
            if($order == 'asc'){
                usort($pays_data, function($a, $b) use ($sort){
                    return $a[$sort] - $b[$sort];
                });
            }elseif($order == 'desc'){
                usort($pays_data, function($b, $a) use ($sort){
                    return $a[$sort] - $b[$sort];
                });
            }
        }

        if($sort == 'Date'){
            if($order == 'asc'){
                usort($pays_data, function($a, $b) use ($sort){
                    return strtotime($a[$sort]) - strtotime($b[$sort]);
                });
            }elseif($order == 'desc'){
                usort($pays_data, function($b, $a) use ($sort){
                    return strtotime($a[$sort]) - strtotime($b[$sort]);
                });
            }
        }

        if($sort == 'Date'){
            if($order == 'asc'){
                usort($pays_data, function($a, $b) use ($sort){
                    return strtotime($a[$sort]) - strtotime($b[$sort]);
                });
            }elseif($order == 'desc'){
                usort($pays_data, function($b, $a) use ($sort){
                    return strtotime($a[$sort]) - strtotime($b[$sort]);
                });
            }
        }

        if($sort == 'Pays'){
            if($order == 'asc'){
                usort($pays_data, function($a, $b) {
                    return strcoll($a['Pays'], $b['Pays']);
                });
            }elseif($order == 'desc'){
                usort($pays_data, function($b, $a) {
                    return strcoll($a['Pays'], $b['Pays']);
                });
            }
        }

    }else{
        $pays_data = null;
    }


    return $pays_data;

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


function getDateInterval($data,$dateSyntaxe){

    $date = [];

    foreach($data as $key){
        if(!in_array($key[$dateSyntaxe], $date)){
            $date[] = $key[$dateSyntaxe];
        }
    }

    sort($date);
    $startDate = $date[0];
    $endDate = $date[count($date)-1];

    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    $interval = $startDateTime->diff($endDateTime);
    $numberOfDays = $interval->days;

    $currentDateTime = $startDateTime;

    $date_interval_array = [];

    for ($i = 0; $i <= $numberOfDays; $i++) {
        $currentDate = $currentDateTime->format('Y-m-d');
        $date_interval_array[] = $currentDate;
        $currentDateTime->modify('+1 day');
    }

    return $date_interval_array;

}

