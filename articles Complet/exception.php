<?php
    function handle_exception($ex): void
    {
        echo "Une erreur a été rencontrée" . $ex->getMessage() . PHP_EOL;
    }
