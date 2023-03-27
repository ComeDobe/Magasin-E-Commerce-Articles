<?php
    require ("index.php");
    require_once ("function_articles.php");
    $articles = get_articles();
?>

<html lang="fr">
<body>
    <h1>Liste des articles</h1>

    <?php
    echo "<div id='articles'>";
    foreach ($articles as $article) {
        show_article($article);
    }
    echo "</div>";
    ?>

</body>
</html>
