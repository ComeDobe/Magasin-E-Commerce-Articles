<?php

    require_once ("connexion.php");
    require_once ("exception.php");

    function add_auteur($nom, $prenom, $date): void
    {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $sql = "INSERT INTO auteurs (nom, prenom, date_naissance) VALUES (?, ?, ?)";


                $request = mysqli_prepare($connexion, $sql);
                mysqli_stmt_bind_param($request, "sss", $nom, $prenom, $date);

                mysqli_stmt_execute($request);

                $id = mysqli_stmt_insert_id($request);
                if ($id) {
                    echo "Le nouvel auteur a été enregistré avec l'id $id";
                }
            } catch (Exception $ex) {
                handle_exception($ex);
                exit;
            }
        } else {
            echo "La connexion n'a pas pu être ouverte";
        }
    }

    function get_auteurs(): array
    {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $result = mysqli_query($connexion, "SELECT * FROM auteurs;");
                $auteurs = mysqli_fetch_all($result, MYSQLI_ASSOC);
                return $auteurs;
            } catch (Exception $ex) {
                handle_exception($ex);
                exit;
            }
        } else {
            echo "La connexion n'a pas pu être ouverte";
            exit;
        }
    }
    function get_auteur($id)
    {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $sql = "SELECT * FROM auteurs WHERE id = ?";
                $request = mysqli_prepare($connexion, $sql);
                mysqli_stmt_bind_param($request, "i", $id);

                mysqli_stmt_execute($request);
                $result = mysqli_stmt_get_result($request);

                if ($result->num_rows > 0) {
                    $rows = mysqli_fetch_all($result);
                    return $rows[0];
                } else {
                    echo "Aucun utilisateur avec l'id $id n'a pu être trouvé";
                    exit;
                }
            } catch (Exception $ex) {
                handle_exception($ex);
                exit;
            }
        } else {
            echo "La connexion n'a pas pu être ouverte";
            exit;
        }
    }
