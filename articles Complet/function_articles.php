<?php

    require_once ("connexion.php");
    require_once ("function_file.php");
    require_once ("exception.php");

    function show_article($article): void
    {
        echo "<div class='article'>";
        echo "<h2>" . $article['titre'] . "</h2>";
        echo "<a href='form_article_upd.php?id=" . $article['id'] . "'><button>Modifier</button></a>";
        echo "<a href='delete_article.php?id=" . $article['id'] . "'><button>Supprimer</button></a>";
        echo "<p>Paru le " . $article['date_parution'] . "</p>";
        echo "<p>Ecrit par " . $article['nom'] . " ". $article['prenom'] . "</p>";
        echo "<p>Est public : " . ($article['est_public'] ? 'OUI' : 'NON');
        echo "<h3>Contenu </h3>";
        echo "<p>" . $article['contenu'] . "</p>";
        echo "<img src='" . $article['couverture'] . "'/>";
        echo "</div>";
    }
    function add_article($titre, $contenu, $date, $couverture, $public, $auteur): void
    {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $sql = "INSERT INTO articles (titre, contenu, date_parution, couverture, est_public, auteur_id) VALUES (?, ?, ?, ?, ?, ?)";

                $request = mysqli_prepare($connexion, $sql);
                mysqli_stmt_bind_param($request, "ssssii", $titre, $contenu, $date, $couverture, $public, $auteur);

                mysqli_stmt_execute($request);

                $id = mysqli_stmt_insert_id($request);
                if ($id) {
                    echo "Le nouvel article a été enregistré avec l'id $id";
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

    function update_article($id, $titre, $contenu, $date, $couverture, $public, $auteur): void {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $sql = "UPDATE articles SET titre = ?, contenu = ?, date_parution = ?, couverture = ?, est_public = ?, auteur_id = ? WHERE id = ?";

                $request = mysqli_prepare($connexion, $sql);
                mysqli_stmt_bind_param($request, "ssssiii", $titre, $contenu, $date, $couverture, $public, $auteur, $id);

                mysqli_stmt_execute($request);

                echo "L'article a été modifié l'id $id";
            } catch (Exception $ex) {
               handle_exception($ex);
               exit;
            }
        } else {
            echo "La connexion n'a pas pu être ouverte";
            exit;
        }
    }

    function get_article($id) {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $sql = "SELECT * FROM articles WHERE id = ?";
                $req = mysqli_prepare($connexion, $sql);
                mysqli_stmt_bind_param($req, "i", $id);
                mysqli_stmt_execute($req);
                $result = mysqli_stmt_get_result($req);

                if ($result->num_rows > 0) {
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    return $rows[0];
                } else {
                    echo "L'article avec id $id n'a pas pu être trouvé !";
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
    function get_articles(): array
    {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $result = mysqli_query($connexion, "SELECT articles.id, articles.titre, articles.contenu, DATE_FORMAT(articles.date_parution, '%d-%m-%Y') as date_parution, articles.couverture, articles.est_public, a.nom as nom, a.prenom as prenom FROM articles INNER JOIN auteurs a on articles.auteur_id = a.id;");
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            } catch (Exception $ex) {
                handle_exception($ex);
                exit;
            }
        } else {
            echo "La connexion n'a pas pu être ouverte";
            exit;
        }
    }

    function get_cover_path($id)
    {
        $connexion = connect_to_DB();

        if ($connexion) {
            try {
                $sql = "SELECT couverture FROM articles WHERE id = ?";
                $req = mysqli_prepare($connexion, $sql);
                mysqli_stmt_bind_param($req, "i", $id);
                mysqli_stmt_execute($req);
                $result = mysqli_stmt_get_result($req);
                if ($result->num_rows > 0) {
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    return $rows[0]['couverture'];
                } else {
                    echo "La couveture de l'index $id n'a pas pu être trouvée";
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

    function delete_article($id): void
    {
        $connexion = connect_to_DB();

        if ($connexion) {
            $cover_path = get_cover_path($id);

            try {
                $sql = "DELETE articles FROM articles WHERE id = ?";
                $req = mysqli_prepare($connexion, $sql);
                mysqli_stmt_bind_param($req, "i", $id);
                mysqli_stmt_execute($req);

                delete_file($cover_path);

                echo "L'article avec l'id $id a bien été supprimé";
            } catch (Exception $ex) {
                handle_exception($ex);
                exit;
            }
        } else {
            echo "L'article avec id $id n'a pas pu être trouvé !";
            exit;
        }
    }
