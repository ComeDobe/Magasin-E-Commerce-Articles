<?php
    require_once ("function_articles.php");
    require_once ("function_auteur.php");
    require_once ("function_file.php");

    if (isset($_GET['id']) && !empty($_GET['id'])
        && isset($_POST['titre']) && !empty($_POST['titre'])
        && isset($_POST['contenu']) && ! empty($_POST['contenu'])
        && isset($_FILES['couverture']) && $_FILES['couverture']['error'] === 0
        && isset($_POST['public']) && $_POST['public'] >= 0
        && isset($_POST['auteur']) && ! empty($_POST['auteur'])
        && isset($_POST['date']) && ! empty($_POST['date'])) {

        $article_id = intval($_GET['id']);
        $auteur_id = intval($_POST['auteur']);
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = htmlspecialchars($_POST['contenu']);
        $couverture = $_FILES['couverture'];
        $public = intval($_POST['public']);
        $date = htmlspecialchars($_POST['date']);

        if (strlen($titre) < 5) {
            echo "Le titre doit comporter au moins 5 charactères";
            exit;
        }
        if (!in_array($public, [0, 1])) {
            echo "Le booléen est_public doit être O ou 1";
            exit;
        }
        if (!get_article($article_id)) {
            echo "L'article n'existe pas";
            exit;
        }
        if (!get_auteur($auteur_id)) {
            echo "L'auteur n'existe pas";
            exit;
        }
        if (strtotime($date) > strtotime(date("Y-m-d"))) {
            echo "La date doit être antérieur à la date du jour";
            exit;
        }
        if ($couverture['size'] > 4000000) {
            echo "Le fichier doit avoir une taille inférieure à 4 Mo";
            exit;
        } else {
            $infos = pathinfo($couverture['name']);
            $ext = $infos['extension'];
            $ext_autorise = array('jpg', 'jpeg', 'png');
            if (in_array($ext, $ext_autorise)) {
                if (!is_dir("uploads")) {
                    mkdir("uploads");
                }

                $article = get_article($article_id);
                $old_cover_path = $article['couverture'];

                $file_name_server = uniqid() . "." . $ext;
                $cover_file_path = "uploads/" . $file_name_server;

                move_uploaded_file($couverture['tmp_name'],
                    $cover_file_path
                );

                if (file_exists($cover_file_path)) {
                    echo "Le fichier a bien été enregistré";

                    update_article($article_id, $titre, $contenu, $date, $cover_file_path, $public, $auteur_id);
                    delete_file($old_cover_path);
                    header('location:list_article.php');
                } else {
                    echo "Erreur lors de l'enregistrement";
                }
            }
            else {
                echo "L'extension de fichier est incorrecte (uniquement 'jpg, 'jpeg', 'png'";
                exit;
            }
        }
    } else {
        echo "L'un des champs n'a pas été rempli";
        exit;
    }
