<?php
include ('include/header.php');
include ('include/nav.php');

$pays_data = getPaysData();
// var_dump($_SESSION);
isset($_GET['pays']) ? $pays_filter = $_GET['pays'] : $pays_filter = '';

isset($_GET['deces']) ? $deces_filter = $_GET['deces'] : $deces_filter = '';
isset($_GET['taux_deces']) ? $taux_deces_filter = $_GET['taux_deces'] : $taux_deces_filter = '';
isset($_GET['multi_pays']) ? $multi_pays_filter = $_GET['multi_pays'] : $multi_pays_filter = '';

if (isset($_POST['startDate'])) {
    $_SESSION['startDate'] = $_POST['startDate'];
} elseif (!isset($_SESSION['startDate'])) {
    $_SESSION['startDate'] = '2023-02-07';
}

if (isset($_POST['infection'])) {
    if ($_POST['submit'] == 'mini') {
        $_SESSION['infection_filter'] = ' > ' . $_POST['infection'];
    } else {
        $_SESSION['infection_filter'] = ' < ' . $_POST['infection'];
    }
} else {
    if (!isset($_SESSION['infection_filter'])) {
        $_SESSION['infection_filter'] = '';
    }
}

$infection_filter = $_SESSION['infection_filter'];

if (isset($_POST['deces'])) {
    if ($_POST['submit'] == 'mini') {
        $_SESSION['deces_filter'] = ' > ' . $_POST['deces'];
    } else {
        $_SESSION['deces_filter'] = ' < ' . $_POST['deces'];
    }
} else {
    if (!isset($_SESSION['deces_filter'])) {
        $_SESSION['deces_filter'] = '';
    }
}

$deces_filter = $_SESSION['deces_filter'];

if (isset($_POST['taux_deces'])) {
    if ($_POST['submit'] == 'mini') {
        $_SESSION['taux_deces_filter'] = ' > ' . $_POST['taux_deces'];
    } else {
        $_SESSION['taux_deces_filter'] = ' < ' . $_POST['taux_deces'];
    }
} else {
    if (!isset($_SESSION['taux_deces_filter'])) {
        $_SESSION['taux_deces_filter'] = '';
    }
}

$taux_deces_filter = $_SESSION['taux_deces_filter'];

if (!empty($multi_pays_filter)) {
    $pays_data = oneFilterData($pays_data, $multi_pays_filter);
    $pays_filter = '';
}

if (isset($_SESSION['startDate']) && isset($_SESSION['endDate'])) {
    $date_interval = $_SESSION['startDate'] . ',' . $_SESSION['endDate'];
    $pays_data = dateIntervalFilterData($pays_data, $date_interval);
    $date_filter = '';
}
isset($_GET['date']) ? $date_filter = $_GET['date'] : $date_filter = '';

$pays_data = multipleFilterData($pays_data, $date_filter, $pays_filter, $infection_filter, $deces_filter, $taux_deces_filter);
$pays_data = sortData($pays_data);

?>

<body class=bg-blue-100>

<table class="w-[80%] mx-[10%] text-center border-2 border-black">
    <div class="w-fit mx-auto text-xl">Tables de données par pays</div>
        <tr class="mb-4 divide-gray-500 divide-x-2 bg-blue-300 ">
            <?php if ($_SESSION['sort']['name'] == 'Date') {
                if ($_SESSION['sort']['order'] == 'desc') { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Date,asc">Date <i class="fa-solid fa-sort-down"></i></button></th></form>
                <?php } else { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Date,desc">Date <i class="fa-solid fa-sort-up"></i></button></th></form>
                <?php }
            } else { ?>
                <form action ="" method="post"><th><button type="submit" name="sort" value="Date,desc">Date <i class="fa-solid fa-sort"></i></button></th></form>
            <?php } ?>
            <?php if ($_SESSION['sort']['name'] == 'Pays') {
                if ($_SESSION['sort']['order'] == 'desc') { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Pays,asc">Pays <i class="fa-solid fa-sort-down"></i></button></th></form>
                <?php } else { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Pays,desc">Pays <i class="fa-solid fa-sort-up"></i></button></th></form>
                <?php }
            } else { ?>
                <form action ="" method="post"><th><button type="submit" name="sort" value="Pays,desc">Pays <i class="fa-solid fa-sort"></i></button></th></form>
            <?php } ?>
            <?php if ($_SESSION['sort']['name'] == 'Infection') {
                if ($_SESSION['sort']['order'] == 'desc') { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Infection,asc">Infections <i class="fa-solid fa-sort-down"></i></button></th></form>
                <?php } else { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Infection,desc">Infections <i class="fa-solid fa-sort-up"></i></button></th></form>
                <?php }
            } else { ?>
                <form action ="" method="post"><th><button type="submit" name="sort" value="Infection,desc">Infections <i class="fa-solid fa-sort"></i></button></th></form>
            <?php } ?>
            <?php if ($_SESSION['sort']['name'] == 'Deces') {
                if ($_SESSION['sort']['order'] == 'desc') { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Deces,asc">Décès <i class="fa-solid fa-sort-down"></i></button></th></form>
                <?php } else { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="Deces,desc">Décès <i class="fa-solid fa-sort-up"></i></button></th></form>
                <?php }
            } else { ?>
                <form action ="" method="post"><th><button type="submit" name="sort" value="Deces,desc">Décès <i class="fa-solid fa-sort"></i></button></th></form>
            <?php } ?>
            <?php if ($_SESSION['sort']['name'] == 'TauxDeces') {
                if ($_SESSION['sort']['order'] == 'desc') { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="TauxDeces,asc">Taux de Décès (%) <i class="fa-solid fa-sort-down"></i></button></th></form>
                <?php } else { ?>
                    <form action ="" method="post"><th><button type="submit" name="sort" value="TauxDeces,desc">Taux de Décès (%) <i class="fa-solid fa-sort-up"></i></button></th></form>
                <?php }
            } else { ?>
                <form action ="" method="post"><th><button type="submit" name="sort" value="TauxDeces,desc">Taux de Décès (%) <i class="fa-solid fa-sort"></i></button></th></form>
            <?php } ?>
        </tr>

        <?php if ($pays_data) {
            foreach ($pays_data as $covid) { ?>
            <tr class="space-x-4 divide-gray-500 divide-x-2 <?= isset($color) ? ' ' : 'bg-blue-200' ?>">
                        <td><?= $covid['Date'] ?></td>
                        <td><?= $covid['Pays'] ?></td>
                        <td><?= number_format($covid['Infection'], 0, ',', '.') ?></td>
                        <td><?= number_format($covid['Deces'], 0, ',', '.') ?></td>
                        <td><?= $covid['TauxDeces'] ?></td>
            </tr>
        <?php isset($color) ? $color = null : $color = 'bg-blue-200';
            }
        } else {
            echo 'Pas de données correspondant aux filtres.';
        } ?>
</table>

<?php include ('include/backtoindex.php'); ?>

</body>

</html>
