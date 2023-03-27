<?php
    require ("index.php");
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        require_once("function_auteur.php");
        require_once("function_articles.php");
        $id = intval($_GET['id']);

        $article = get_article($id);
        $auteurs = get_auteurs();
    } else {
        echo "Le paramètre id ne peut être nul";
        exit;
    }
    ?>

<html>
<body>
<form method="post" action="update_article.php?id=<?php echo $id ?>" enctype="multipart/form-data">
    <h1>Modifier un article</h1>
    <label>
        Titre :
        <input type="text" name="titre" value="<?php echo $article['titre'] ?>"/>
    </label>
    <label>
        Contenu :
        <input type="text" name="contenu" value="<?php echo $article['contenu'] ?>"/>
    </label>
    <label>
        Date de parution :
        <input type="date" name="date" value="<?php echo $article['date_parution'] ?>"/>
    </label>
    <label>
        Couverture :
        <input type="file" name="couverture" value="<?php echo $article['couverture'] ?>"/>
    </label>
    <label>
        Est public :
        <?php
            $public = $article['est_public'];
        ?>
        <label>NON<input type="radio" name="public" value="0" <?php echo ($public ? '' : 'checked') ?>/></label>

        <label>OUI<input type="radio" name="public" value="1" <?php echo ($public ? 'checked' : '') ?>/></label>
    </label>

    <label>
        Auteur :
        <select name="auteur">
            <?php
            foreach ($auteurs as $auteur) {
                $selected = $auteur['id'] == $article['auteur_id'] ? 'selected' : '';
                echo "<option value=" . $auteur['id'] . " " . $selected . ">" . $auteur['nom'] . " " . $auteur['prenom'] . "</option>";
            }
            ?>
        </select>
    </label>
    <button type="submit">Modifier article</button>
</form>
</body>
</html>