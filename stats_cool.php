<?php include('include/header.php') ?>

<body>

    <center class="text-red-600 text-xl"> Classement des pays avec le plus de décès suite au covid </center>

    <button class="bg-blue-300 rounded-lg px-2 py-1 absolute right-8 top-80"><a href="index.php">
            <- Stats pas cool</a></button>

    <canvas class="absolute right-80 top-80 overflow-x-auto max-w-[50vw]" id="myChart">></canvas>


    <?php
// $array_pays= [];
//         foreach($covid_data['PaysData'] as $pays){
//             if(!in_array($pays['Pays'],$array_pays)){
//                 $array_pays[] = $pays['Pays'];
//             }
//         }
// // var_dump($array_pays);

// foreach($covid_data['PaysData'] as $covid){
//     foreach($array_pays as $pays){
//         if($covid['Pays'] == 'France'){
//         var_dump ($covid['Deces']);
//         }
//     }
// }

$death = [];
foreach($covid_data['PaysData'] as $covid){
    if($covid['Date'] == '2023-03-09T00:00:00'){
        $death[] = ['Deces' => $covid['Deces'],
                    'Pays' => $covid['Pays']];
    }
}
rsort($death);
$i = 1;
foreach($death as $key){ ?>
    <div class="flex">
        <h1 class=" text-red-600"> Top <?=$i?></h1>
        <div class="mt-4 ml-4"> Nombre de morts en <?=$key['Pays']?> : <?=$key['Deces']?></div>
    </div>
    <?php $i++;}

// var_dump($death);

?>


</body>

<script>
const xValues = [
    // <?php foreach($death as $key){echo "'".$key['Pays']."', ";}?>
    'Albanie',
    'France',
    'Japon',
    'Chine',
    'Albanio',
    'Albania',
];

const yValues = [
    // <?php foreach($death as $key){echo $key['Deces'].", ";}?>
    1,
    2,
    3,
    4,
    5,
    6,
];

new Chart("myChart", {
    type: "bar",

    data: {
        labels: xValues,
        datasets: [{
            // barPercentage: 0.5,
            // barThickness: 6,
            // maxBarThickness: 8,
            // minBarLength: 2,
            data: yValues
        }]
    }
});
</script>

</html>