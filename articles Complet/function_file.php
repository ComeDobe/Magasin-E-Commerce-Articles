<?php
    function delete_file($path): void
    {
        if (!unlink($path)) {
            echo "$path n'a pas pu être supprimé";
        } else {
            echo "$path a bien été supprimé du serveur";
        }
    }