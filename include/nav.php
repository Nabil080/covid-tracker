<div class="dropdown w-[265.667px] h-[56px] relative top-0 left-0">
</div>

<div class="dropdown w-[265.667px] fixed top-0 left-0">
    <button onclick="myFunction()" class="dropbtn w-full">Pays</button>
    <div id="myDropdown" class="dropdown-content max-h-screen overflow-scroll">
        <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
        <a href="<?=substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "&"))?>">Tous les pays</a>
        <?php $array_pays = [];$pays_data = getPaysData();$pays_active = [];
        foreach ($pays_data as $pays) {
            if (!in_array($pays['Pays'], $array_pays)) {
                $array_pays[] = $pays['Pays'];
                $get_pays = isset($_GET['multi_pays']) ? $_GET['multi_pays'] : [];
                if(!in_array($pays['Pays'],$get_pays) OR empty($get_pays)){
                    if(isset($_GET['multi_pays'])){?>
                        <a href="<?=$_SERVER['REQUEST_URI']?>&multi_pays[]=<?= $pays['Pays'] ?>"><?= $pays['Pays'] ?></a>
                    <?php }else{?>
                        <a href="<?=$_SERVER['REQUEST_URI']?>&multi_pays[]=<?= $pays['Pays'] ?>"><?= $pays['Pays'] ?></a>
                    <?php }
                }else{
                    $pays_active[] = $pays['Pays'];
                }
            }
        }
        var_dump($pays_active);?>

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
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
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