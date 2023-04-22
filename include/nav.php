<?php
$pays_data = getPaysData();

$active_pays = isset($_GET['multi_pays']) ? $_GET['multi_pays'] : [];
// definit array pays


$array_pays = getUniquePaysList($pays_data);

$date_array = getdateInterval($pays_data,'Date');

if(isset($_POST['startDate'])){
    $_SESSION['startDate'] = $_POST['startDate'];
}elseif(!isset($_SESSION['startDate'])){
    $_SESSION['startDate'] = "2023-02-07";
}

if(isset($_POST['endDate'])){
    $_SESSION['endDate'] = $_POST['endDate'];
}elseif(!isset($_SESSION['endDate'])){
    $_SESSION['endDate'] = "2023-03-09";
}

if(isset($_POST['infection'])){
    $_SESSION['infection'] = $_POST['infection'];
}elseif(!isset($_SESSION['infection'])){
    $_SESSION['infection'] = "0";
}

if(isset($_POST['deces'])){
    $_SESSION['deces'] = $_POST['deces'];
}elseif(!isset($_SESSION['deces'])){
    $_SESSION['deces'] = "0";
}

if(isset($_POST['taux_deces'])){
    $_SESSION['taux_deces'] = $_POST['taux_deces'];
}elseif(!isset($_SESSION['taux_deces'])){
    $_SESSION['taux_deces'] = "0";
}

?>
<div class="w-full h-[100px]"></div>
<nav class="bg-blue-200 border-b-2 border-black align-center fixed top-0 flex justify-center w-full">

<div class="relative dropdown w-[265.667px]">
    <button onclick="paysDropdown()" class="dropbtn w-full">Pays <i class="fa fa-chevron-down"></i></button>
    <div id="paysDropdown" class="dropdown-content max-h-screen overflow-scroll">
        <div class="<?php if(empty($active_pays)){ echo 'hidden';}else{ echo 'flex';} ?> w-[265.667px] flex-wrap p-4">
            Filtres actifs (cliquez pour supprimer):
            <?php foreach($active_pays as $active){
                $new_url = removeFilterFromUrl("&multi_pays[]=",$active) ?>
                <a class="hover:bg-red-500 group hover:text-white p-2 rounded-lg" href="<?=$new_url?>"><span class="text-red-500 group-hover:text-white">X</span> <?=$active?></a>
            <?php } ?>
        </div>
        <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
        <a class="a" href="<?=substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "&"))?>">Tous les pays</a>
        <?php
        foreach($array_pays as $pays) {
            if(!in_array($pays,$active_pays)){?>
                    <a class="a" href="<?=$_SERVER['REQUEST_URI']?>&multi_pays[]=<?= $pays ?>"><?= $pays ?></a>
    <?php   }
        } ?>
    </div>
    <button class="absolute top-[75px] ml-4 px-4 py-1 bg-red-200 hover:bg-red-300"><a href="unset.php">Réinitialiser les filtres</a></button>
</div>

<div class="grow flex">
    <form action="" method="post" class="mx-auto my-auto">
        Infections :
        <input type="number" placeholder="0" value="<?=$_SESSION['infection']?>" class="pl-2 w-24" name="infection">
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['infection_filter'])){ echo str_contains($_SESSION['infection_filter'],'>') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="mini">mini</button>
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['infection_filter'])){ echo str_contains($_SESSION['infection_filter'],'<') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="maxi">maxi</button>
    </form>

<!-- // TODO traitement ajax -->

    <!-- <form action="" method="post" class="mx-auto my-auto">
        Infections :
        <input type="number" placeholder="0" value="<?=$_SESSION['infection']?>" class="pl-2 w-24" name="infection">
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['infection_filter'])){ echo str_contains($_SESSION['infection_filter'],'>') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="mini">mini</button>
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['infection_filter'])){ echo str_contains($_SESSION['infection_filter'],'<') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="maxi">maxi</button>
    </form>

<script>
const url = 'https://api.github.com/users/shrutikapoor08/repos';

fetch(url)
    .then(response => response.json())
    .then(repos => {
        const reposList = repos.map(repo => repo.name);
        console.log(reposList);
    })
    
.catch(err => console.log(err))


</script> -->





    <form action="" method="post" class="mx-auto my-auto">
        Décès :
        <input type="number" placeholder="0" value="<?=$_SESSION['deces']?>" class="pl-2 w-24" name="deces">
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['deces_filter'])){ echo str_contains($_SESSION['deces_filter'],'>') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="mini">mini</button>
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['deces_filter'])){ echo str_contains($_SESSION['deces_filter'],'<') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="maxi">maxi</button>
    </form>

    <form action="" method="post" class="mx-auto my-auto">
        Taux de Décès :
        <input type="number"  step='0.01' placeholder="0.00" value="<?=$_SESSION['taux_deces']?>" class="pl-2 w-24" name="taux_deces">
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['taux_deces_filter'])){ echo str_contains($_SESSION['taux_deces_filter'],'>') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="mini">mini</button>
        <button type="submit" class="px-2 border hover:bg-green-500 <?php if(isset($_SESSION['taux_deces_filter'])){ echo str_contains($_SESSION['taux_deces_filter'],'<') ? "bg-green-500 border-black" : "bg-green-400 border-white" ;}else{echo "bg-green-400 border-white";} ?>"  name="submit" value="maxi">maxi</button>
    </form>

    <form action="" method="post" class="mx-auto my-auto ">
        <!-- <input type="text" class="" name="action" value="<?=$new_url?>"> -->
        <label class="align-center h-fit my-auto">Date de début</label>
        <input type="date" name="startDate" value='<?=$_SESSION['startDate']?>' min='' max='2023-03-09'>
        <label class="align-center h-fit my-auto">Date de fin</label>
        <input type="date" name="endDate" value='<?=$_SESSION['endDate']?>' min='2023-02-07' max='2023-03-09'>
        <button type="submit" class="px-2 border border-white hover:bg-green-500 bg-green-400" >submit</button>
    </form>



</div>

<div class="dropdown">
    <button onclick="dateDropdown()" class="dropbtn">Dates exactes <i class="fa fa-chevron-down"></i></button>
    <div id="dateDropdown" class="dropdown-content max-h-screen overflow-scroll">
        <div class="flex flex-wrap p-4 justify-start">
            <?php
            foreach($date_array as $date){
            ?>
                <a class="a w-full" href="<?=$_SERVER['REQUEST_URI']?>&date==='<?=$date?>'"><?=$date?></a>
            <?php } ?>
        </div>
    </div>
</div>

</nav>

<script>
    /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
    function paysDropdown() {
        document.getElementById("paysDropdown").classList.toggle("show");
    }

    function dateDropdown() {
        document.getElementById("dateDropdown").classList.toggle("show");
    }

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("paysDropdown");
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
