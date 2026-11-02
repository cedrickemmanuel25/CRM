<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mode démonstration publique
    |--------------------------------------------------------------------------
    |
    | Activé uniquement sur l'instance de démonstration en ligne (DEMO_MODE=true).
    | Il bloque les opérations sensibles (administration, maintenance, exports
    | complets, téléversements, modification des comptes) et autorise la
    | réinitialisation du jeu de données fictif par la commande demo:reset.
    |
    */

    'enabled' => (bool) env('DEMO_MODE', false),

    /*
    | Garde-fou de demo:reset : le nom de la base doit contenir cette chaîne,
    | pour qu'aucune base qui ne serait pas dédiée à la démonstration ne soit réinitialisée.
    */
    'database_marker' => env('DEMO_DATABASE_MARKER', 'demo'),

    'message' => 'Cette action est désactivée dans la démonstration publique.',

];
