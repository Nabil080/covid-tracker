<?php include ('include/header.php'); ?>

<body class="bg-blue-100">

    <?php include ('include/nav.php'); ?>

    <button class="bg-blue-300 rounded-lg px-2 py-1 absolute right-8 top-80"><a href="stats_cool.php">Stats cool
            -></a></button>

    <?php if (isset($_GET['pays'])) {
        echo $_GET['pays'];
    } ?>
    <canvas id="myChart" style="width:100%;max-width:700px">></canvas>
    <table>

        <tr>
            <th>Date</th>
            <th>Pays</th>
            <th>Infections</th>
            <th>Décès</th>
            <th>Taux de décès</th>
        </tr>

        <?php
        $pays_data = getPaysData();
        $i = 0;
        foreach ($pays_data as $covid) {
            if (isset($_GET['pays']) && $i <= 10000) {
                ;
                if (in_array($_GET['pays'], $covid)) {
                    $i++
                    ?>
                    <tr class="text-center">
                        <td><?= $covid['Date'] ?></td>
                        <td><?= $covid['Pays'] ?></td>
                        <td><?= $covid['Infection'] ?></td>
                        <td><?= $covid['Deces'] ?></td>
                        <td><?= $covid['TauxDeces'] ?></td>
                    </tr>

                <?php }
            } elseif ($i <= 10000) {
                $i++; ?>

                <tr class="space-x-4">
                    <td><?= $covid['Date'] ?></td>
                    <td><?= $covid['Pays'] ?></td>
                    <td><?= $covid['Infection'] ?></td>
                    <td><?= $covid['Deces'] ?></td>
                    <td><?= $covid['TauxDeces'] ?></td>
                </tr>
        <?php
            }
        }

        ?>


    </table>


    <?php if (!isset($_GET['pays'])) {
        $global_data = getGlobalData(); ?>
        <script>
            const xyValues = [
                <?php foreach ($global_data as $global) { ?> {
                        x: '<?= $global['Date'] ?>',
                        y: <?= $global['Deces'] ?>
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
    <?php } else { ?>

        <script>
            const xyValues = [
                <?php foreach ($pays_data as $covid) {
                    if (in_array($_GET['pays'], $covid)) { ?> {
                            x: '<?= $covid['Date'] ?>',
                            y: <?= $covid['Deces'] ?>
                        },
                <?php }
                } ?>
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
    <?php include ('include/backtoindex.php'); ?>
</body>

</html>
