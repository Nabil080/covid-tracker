<?php include('include/header.php');
$pays_data = getPaysData();
$pays_death = getPaysTotalDeces();
$graphX = getTotalDeces();
$graphY = getTotalPays();
?>

<body class="bg-blue-100">

    <center class="text-red-600 text-xl"> Classement des pays avec le plus de décès suite au covid </center>


    <canvas class="absolute right-80 top-40 overflow-x-auto max-w-[50vw]" id="myChart">></canvas>
    <canvas class="absolute right-80 top-[40rem] overflow-x-auto max-w-[50vw]" id="topChart">></canvas>


    <?php

    $i = 1;
    foreach ($pays_death as $key) { ?>
        <div class="flex">
            <div class="mt-4 ml-4"><span class="text-red-600"> Top <?= $i ?> </span> - <?= $key['Pays'] ?> : <?=  number_format($key['Deces'], 0, ',', '.')?> </div>
        </div>
    <?php $i++;
    }


    $i = 0;
    foreach($pays_death as $key){
        if($i < 10){
        $top_death[] = intval($key['Deces']);
        $top_pays[] = $key['Pays'];
        $i++;
    }
    }
    $top_graphX = json_encode($top_death);
    $top_graphY = json_encode($top_pays);
    ?>

<?php include('include/backtoindex.php');?>
</body>

<script>

    new Chart("myChart", {
        type: "bar",

        data: {
            labels: <?=$graphY?>,
            datasets: [{
                label:'Décès totals par pays',
                barPercentage: 0.5,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
                backgroundColor: '#852033',
                data: <?=$graphX?>,
            }]
        }
    });

    new Chart("topChart", {
        type: "pie",

        data: {
            labels: <?=$top_graphY?>,
            datasets: [{
                label:'Comparaison 10 pays principaux',
                backgroundColor: [
                '#852033',
                '#913647',
                '#9d4d5c',
                '#aa6370',
                '#b67985',
                '#c29099',
                '#cea6ad',
                '#dabcc2',
                '#e7d2d6',
                '#f3e9eb',
                ],
                hoverOffset: 4,
                data: <?=$top_graphX?>,
            }]
        }
    });
</script>

</html>