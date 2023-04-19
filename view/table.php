<?php include('include/header.php'); ?>

<body class=bg-blue-100>

<?php include('include/nav.php');

$pays_data = getPaysData();

isset($_GET['date']) ? $date_filter = $_GET['date'] : $date_filter = "";
isset($_GET['pays']) ? $pays_filter = $_GET['pays'] : $pays_filter = "";
isset($_GET['infection']) ? $infection_filter = $_GET['infection'] : $infection_filter = "";
isset($_GET['deces']) ? $deces_filter = $_GET['deces'] : $deces_filter = "";
isset($_GET['taux_deces']) ? $taux_deces_filter = $_GET['taux_deces'] : $taux_deces_filter = "";
isset($_GET['multi_pays']) ? $multi_pays_filter = $_GET['multi_pays'] : $multi_pays_filter = "";
isset($_GET['multi_date']) ? $multi_date_filter = $_GET['multi_date'] : $multi_date_filter = "";

if(!empty($multi_pays_filter)){
    $pays_data = oneFilterData($pays_data,$multi_pays_filter);
    $pays_filter = "";
}

if(!empty($multi_date_filter)){
    $pays_data = dateIntervalFilterData($pays_data,'2023-03-05,2023-03-09');
    $date_filter = "";
}

$pays_data = multipleFilterData($pays_data,$date_filter,$pays_filter,$infection_filter,$deces_filter,$taux_deces_filter);

?>




<table class="w-[80%] mx-[10%] text-center border-2 border-black">
    <div class="w-fit mx-auto text-xl">Tables de données par pays</div>
        <tr class="mb-4 divide-gray-500 divide-x-2 bg-blue-300  ">
            <th>Date</th>
            <th>Pays</th>
            <th>Infections</th>
            <th>Décès</th>
            <th>Taux de décès</th>
        </tr>

        <?php foreach ($pays_data as $covid) { ?>
            <tr class="space-x-4 divide-gray-500 divide-x-2 <?= isset($color) ? ' ' : 'bg-blue-200'?>">
                        <td><?= $covid['Date'] ?></td>
                        <td><?= $covid['Pays'] ?></td>
                        <td><?= $covid['Infection'] ?></td>
                        <td><?= $covid['Deces'] ?></td>
                        <td><?= $covid['TauxDeces'] ?></td>
            </tr>
        <?php isset($color) ? $color = null : $color = 'bg-blue-200' ;} ?>
</table>



<?php include('include/backtoindex.php');?>

</body>

</html>