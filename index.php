<?php
            $json_data = file_get_contents("covid_2023.json");
            $covid_data = json_decode($json_data, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    < script src = "https://code.jquery.com/jquery-3.6.0.min.js" >
    </script>
    </script>

    <title>Document</title>
</head>

<body>

    <center>
        <?php
        $array_pays= [];
        foreach($covid_data['PaysData'] as $pays){
            if(!in_array($pays['Pays'],$array_pays)){ $array_pays[] = $pays['Pays']?>
        <button class="pays" data-id="<?=$pays['Pays']?>"><a
                href="?pays=<?=$pays['Pays']?>"><?=$pays['Pays']?></a></button>
        <?php }} ?>
    </center>


    <?=$_GET['pays']?>
    <canvas id="myChart" style="width:100%;max-width:700px">></canvas>


    <table>

        <tr>
            <th>Date</th>
            <th>Pays</th>
            <th>Hospitalisés</th>
            <th>Décès</th>
            <th>Guérisons</th>
            <th>Taux de décès</th>
            <th>Taux de guérison</th>
            <th>Taux d'infection</th>
        </tr>

        <?php
            $i = 0 ;
            foreach($covid_data['PaysData'] as $covid){
                if(isset($_GET['pays']) && $i <= 100){ ;
                    if(in_array($_GET['pays'],$covid)){$i++
                ?>
        <tr>
            <td><?=$covid['Date']?></td>
            <td><?=$covid['Pays']?></td>
            <td><?=$covid['Infection']?></td>
            <td><?=$covid['Deces']?></td>
            <td><?=$covid['Guerisons']?></td>
            <td><?=$covid['TauxDeces']?></td>
            <td><?=$covid['TauxGuerison']?></td>
            <td><?=$covid['TauxInfection']?></td>
        </tr>

        <?php }}elseif($i <= 100){ $i++; ?>

        <tr>
            <td><?=$covid['Date']?></td>
            <td><?=$covid['Pays']?></td>
            <td><?=$covid['Infection']?></td>
            <td><?=$covid['Deces']?></td>
            <td><?=$covid['Guerisons']?></td>
            <td><?=$covid['TauxDeces']?></td>
            <td><?=$covid['TauxGuerison']?></td>
            <td><?=$covid['TauxInfection']?></td>
        </tr>
        <?php }
        }


        ?>


    </table>


    <?php if(!isset($_GET['pays'])){?>
    <script>
    const xyValues = [
        <?php foreach($covid_data['GlobalData'] as $global){ ?> {
            x: '<?=substr($global['Date'],0,strpos($global['Date'],"T"))?>',
            y: <?=$global['Deces']?>
        },
        <?php } ?>
    ];

    new Chart("myChart", {
        type: "line",
        data: {
            label: 'salut',
            datasets: [{
                pointRadius: 4,
                pointBackgroundColor: "rgba(50,100,200,1)",
                backgroundColor: "rgba(25, 25, 25, 0.5)",
                data: xyValues
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: 'YYYY-MM-DD', // format of the date string
                        tooltipFormat: 'll' // format of the tooltip on hover
                    }
                }]
            }
        }
    });
    </script>
    <?php }else{ ?>

    <script>
    const xyValues = [
        <?php foreach($covid_data['PaysData'] as $covid){
            if(in_array($_GET['pays'],$covid)){ ?> {
            x: '<?=substr($covid['Date'],0,strpos($covid['Date'],"T"))?>',
            y: <?=$covid['Deces']?>
        },
        <?php }} ?>
    ];

    new Chart("myChart", {
        type: "line",
        data: {
            label: 'salut',
            datasets: [{
                pointRadius: 4,
                pointBackgroundColor: "rgba(50,100,200,1)",
                backgroundColor: "rgba(25, 25, 25, 0.5)",
                data: xyValues
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: 'YYYY-MM-DD', // format of the date string
                        tooltipFormat: 'll' // format of the tooltip on hover
                    }
                }]
            }
        }
    });
    </script>

    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>