<?php
    if (isset($_GET['id'])) {
        require_once ("function_articles.php");
        $article_id = intval($_GET['id']);

        if (!get_article($article_id)) {
            echo "L'article avec l'id $article_id n'existe pas";
            exit;
        }
        delete_article($article_id);
        header('location:list_article.php');
    } else {
        echo "L'id à supprimer doit être renseigné";
        exit;
    }
