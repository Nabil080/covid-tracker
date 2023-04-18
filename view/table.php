<?php include('include/header.php'); ?>

<body class=bg-blue-100>

<?php include('include/nav.php');

$pays_data = isset($_GET['pays']) ? getOnePaysData($_GET['pays']) : getPaysData();

?>

<div class="w-fit absolute top-4 left-[45%] text-xl">Tables de données par pays</div>



<table class="w-[80%] mx-[10%] text-center border-2 border-black">

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