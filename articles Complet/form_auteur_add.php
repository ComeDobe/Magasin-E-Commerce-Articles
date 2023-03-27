<?php
    require("index.php");
    ?>

<html>
<body>
<form method="post" action="add_auteur.php">
    <h1>Ajouter un auteur</h1>
    <label>
        Nom :
        <input type="text" name="nom"/>
    </label>
    <label>
        Prénom :
        <input type="text" name="prenom"/>
    </label>
    <label>
        Date de naissance :
        <input type="date" name="date"/>
    </label>
    <button type="submit">Ajouter auteur</button>
</form>
</body>
</html>