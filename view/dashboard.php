<?php include('include/header.php'); ?>

<body class="bg-blue-100">
    <center class="text-3xl">Bienvenue sur mon covid tracker !</center>

    <div class="ml-4 mt-4 text-xl text-blue-800">Que voulez vous faire ?</div>

    <li class="[&>*]:underline space-y-4 [&>*]:ml-4 mt-2 ">
        <ul><a href="?action=graph" class="hover:text-blue-800">Parcourir les graphiques</a></ul>
        <ul><a href="?action=classements" class="hover:text-blue-800">Parcourir les classements</a></ul>
        <ul><a href="?action=table" class="hover:text-blue-800">Accèder aux tables de données brutes</a></ul>
        <ul><a href="?action=pays" class="hover:text-blue-800">Accèder aux informations d'un pays en particulier</a>
        </ul>
    </li>

    <div class="ml-4 mt-8 text-xl text-blue-800">Les pays les plus populaires :</div>

    <li class="[&>*]:underline space-y-2 [&>*]:ml-4 mt-2">
        <ul><a href="?action=États-Unis" class="hover:text-blue-800">États-Unis</a></ul>
        <ul><a href="?action=Brésil" class="hover:text-blue-800">Brésil</a></ul>
        <ul><a href="?action=Inde" class="hover:text-blue-800">Inde</a></ul>
        <ul><a href="?action=Russie" class="hover:text-blue-800">Russie</a></ul>
        <ul><a href="?action=Mexique" class="hover:text-blue-800">Mexique</a></ul>
        <ul><a href="?action=Royaume-Uni" class="hover:text-blue-800">Royaume-Uni</a></ul>
        <ul><a href="?action=Pérou" class="hover:text-blue-800">Pérou</a></ul>
        <ul><a href="?action=Italie" class="hover:text-blue-800">Italie</a></ul>
        <ul><a href="?action=Allemagne" class="hover:text-blue-800">Allemagne</a></ul>
        <ul><a href="?action=France" class="hover:text-blue-800">France</a></ul>
    </li>


    <a href="?action=test" class="fixed right-12 top-[50%] text-xl bg-red-500 p-2 rounded-lg "> INDEX TEMPORAIRE </a>


</body>

</html>