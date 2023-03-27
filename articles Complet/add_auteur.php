<?php
    require ("function_auteur.php");

    if (isset($_POST['nom']) && !empty($_POST['nom'])
        && isset($_POST['prenom']) && ! empty($_POST['prenom'])
        && isset($_POST['date']) && ! empty($_POST['date'])) {

        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $date = htmlspecialchars($_POST['date']);

        if (strlen($nom) < 3) {
            echo "Le nom doit compoter au moins 5 charactères";
            exit;
        }
        if (strlen($prenom) < 3) {
            echo "Le prenom doit comporter au moins 5 charactères";
            exit;
        }
        if (strtotime($date) > strtotime(date("Y-m-d"))) {
            echo "La date doit être inférieure à la date du jour";
            exit;
        }

        add_auteur($nom, $prenom, $date);
    } else {
        echo "L'un des champs n'a pas été rempli";
        exit;
    }
