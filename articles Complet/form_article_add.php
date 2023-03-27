<?php
    require ("index.php");
    require_once ("function_auteur.php");
    $auteurs = get_auteurs();
    ?>

<html>
<body>
<form method="post" action="add_article.php" enctype="multipart/form-data">
    <h1>Ajouter un article</h1>
    <label>
        Titre :
        <input type="text" name="titre"/>
    </label>
    <label>
        Contenu :
        <input type="text" name="contenu"/>
    </label>
    <label>
        Date de parution :
        <input type="date" name="date"/>
    </label>
    <label>
        Couverture :
        <input type="file" name="couverture"/>
    </label>
    <label>
        Est public :
        <label>NON<input type="radio" name="public" value="0"/></label>

        <label>OUI<input type="radio" name="public" value="1"/></label>
    </label>

    <label>
        Auteur :
        <select name="auteur">
            <?php
            foreach ($auteurs as $auteur) {
                echo "<option value=" . $auteur['id'] . ">" . $auteur['nom'] . " " . $auteur['prenom'] . "</option>";
            }
            ?>
        </select>
    </label>
    <button type="submit">Ajouter article</button>
</form>
</body>
</html>