<?php include('include/header.php');
$pays_data = getPaysData();
$pays_death = getPaysTotalDeces(20);
$graphX = getTotalDeces(20);
$graphY = getTotalPays(20);
$pays_infection = getPaysTotalInfection(20);
$infectionX = getTotalInfection(20);
$infectionY = getTotalInfectionPays(20);
?>

<body class="bg-blue-100">

    <center class="text-red-600 text-xl mt-4"> Classement des pays avec le plus de décès suite au covid </center>

<section class="grid grid-cols-1 my-12 gap-8">
    <div class="flex flex-wrap h-fit mx-[10%]">
        <?php
        $i = 1;
        foreach ($pays_death as $key) {
            if($i <= 20){ ?>
                <div class="flex mt-4 ml-4"><span class="text-red-600"> Top <?= $i ?> </span> - <?= $key['Pays'] ?> : <?=  number_format($key['Deces'], 0, ',', '.')?> </div>
            <?php $i++;
            }
        }
        ?>
    </div>

    <div class="flex">
        <div class="w-1/2">
            <canvas class="" id="myChart">></canvas>
        </div>
        <div class="w-1/2">
            <canvas class="" id="topChart">></canvas>
        </div>
    </div>

</section>

    <center class="text-red-600 text-xl mt-4"> Classement des pays avec le plus d'infectés suite au covid </center>


<section class="grid grid-cols-1 my-12 gap-8">
    <div class="flex flex-wrap h-fit mx-[10%]">
        <?php
        $i = 1;
        foreach ($pays_infection as $key) {
            if($i <= 20){ ?>
                <div class="flex mt-4 ml-4"><span class="text-red-600"> Top <?= $i ?> </span> - <?= $key['Pays'] ?> : <?=  number_format($key['Infection'], 0, ',', '.')?> </div>
            <?php $i++;
            }
        }
        ?>
    </div>

    <div class="flex">
        <div class="w-1/2">
            <canvas class="" id="barInfection">></canvas>
        </div>
        <div class="w-1/2">
            <canvas class="" id="pieInfection">></canvas>
        </div>
    </div>

</section>



    <?php
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

    $i = 0;
    foreach($pays_infection as $key){
        if($i < 10){
        $pie_infection[] = intval($key['Infection']);
        $pie_pays[] = $key['Pays'];
        $i++;
    }
    }
    $pie_graphX = json_encode($pie_infection);
    $pie_graphY = json_encode($pie_pays);
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



    new Chart("barInfection", {
        type: "bar",

        data: {
            labels: <?=$infectionY?>,
            datasets: [{
                label:'Infections totals par pays',
                barPercentage: 0.5,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
                backgroundColor: '#852033',
                data: <?=$infectionX?>,
            }]
        }
    });


    new Chart("pieInfection", {
        type: "pie",

        data: {
            labels: <?=$pie_graphY?>,
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
                data: <?=$pie_graphX?>,
            }]
        }
    });
</script>

</html>