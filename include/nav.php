<?php
$pays_data = getPaysData();
$array_pays = [];
// $active_pays = [];
$active_pays = isset($_GET['multi_pays']) ? $_GET['multi_pays'] : [];
// definit array pays
foreach($pays_data as $pays){
    if(!in_array($pays['Pays'], $array_pays)){
        $array_pays[] = $pays['Pays'];
    }
}

$startDate = '2023-02-07';
$endDate = '2023-03-09';

// Create DateTime objects for the start and end dates
$startDateTime = new DateTime($startDate);
$endDateTime = new DateTime($endDate);

// Calculate the number of days between the start and end dates
$interval = $startDateTime->diff($endDateTime);
$numberOfDays = $interval->days;

// Loop through each day in the date range
$currentDateTime = $startDateTime;
for ($i = 0; $i <= $numberOfDays; $i++) {
  // Format the current date as a string and do something with it
  $currentDate = $currentDateTime->format('Y-m-d');
 ?>  <a href="<?=$_SERVER['REQUEST_URI']?>&date==='<?=$currentDate?>'"><?=$currentDate?></a>

  <?php // Increment the current date by 1 day
  $currentDateTime->modify('+1 day');
}



?>

<div class="dropdown w-[265.667px] h-[56px] relative top-0 left-0">
</div>

<div class="dropdown w-[265.667px] fixed top-0 left-0">
    <button onclick="myFunction()" class="dropbtn w-full">Pays</button>
    <div id="myDropdown" class="dropdown-content max-h-screen overflow-scroll">
        <div class="<?php if(empty($active_pays)){ echo 'hidden';}else{ echo 'flex';} ?> flex-wrap p-4">
            Filtres actifs (cliquez pour supprimer):
            <?php foreach($active_pays as $active){
                $new_url = removeFilterFromUrl("&multi_pays[]=",$active) ?>
                <a class="hover:bg-red-500 group hover:text-white p-2 rounded-lg" href="<?=$new_url?>"><span class="text-red-500 group-hover:text-white">X</span> <?=$active?></a>
            <?php } ?>
        </div>
        <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
        <a class="pays" href="<?=substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "&"))?>">Tous les pays</a>
        <?php
        foreach($pays_data as $pays) {
            if(!in_array($pays['Pays'],$active_pays)){?>
                    <a class="pays" href="<?=$_SERVER['REQUEST_URI']?>&multi_pays[]=<?= $pays['Pays'] ?>"><?= $pays['Pays'] ?></a>
    <?php   }
        } ?>
    </div>
</div>

<style>
    /* Dropdown Button */
    .dropbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* Dropdown button on hover & focus */
    .dropbtn:hover,
    .dropbtn:focus {
        background-color: #3e8e41;
    }

    /* The search field */
    #myInput {
        box-sizing: border-box;
        background-image: url('searchicon.png');
        background-position: 14px 12px;
        background-repeat: no-repeat;
        font-size: 16px;
        padding: 14px 20px 12px 45px;
        border: none;
        border-bottom: 1px solid #ddd;
    }

    /* The search field when it gets focus/clicked on */
    #myInput:focus {
        outline: 3px solid #ddd;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f6f6f6;
        min-width: 230px;
        border: 1px solid #ddd;
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content .pays {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content .pays:hover {
        background-color: #f1f1f1
    }

    /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
    .show {
        display: block;
    }
</style>

<script>
    /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
                console.log(txtValue);
            } else {
                a[i].style.display = "none";
            }
        }
    }



</script>