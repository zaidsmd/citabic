<?php

return [
    'common' => [
        'cms' => 'CMS',
        'fix_errors' => 'Veuillez corriger les erreurs suivantes :',
        'back_to_list' => 'Retour a la liste',
        'create' => 'Creer',
        'update' => 'Mettre a jour',
        'cancel' => 'Annuler',
        'edit' => 'Editer',
        'delete' => 'Supprimer',
        'actions' => 'Actions'
    ],
    'certifications' => [
        'title' => 'Certifications',
        'list'=> 'Liste des certifications',
        'add'=> 'Ajouter une certification',
        'fields'=>[
            'name' => 'Nom',
            'slug' => 'Slug',
            'description' => 'Description',
            'language' => 'Langue',
            'image' => 'Image',

        ],
        'form' => [
            'title_create' => 'Ajouter une certification',
            'title_edit' => 'Modifier la certification',
            'tabs' => [
                'french' => 'Francais',
                'english' => 'Anglais',
            ],
            'fields' => [
                'name_fr' => 'Nom (FR)',
                'name_en' => 'Nom (EN)',
                'description_fr' => 'Description (FR)',
                'description_en' => 'Description (EN)',
                'image' => 'Image',
                'current_image' => 'Image actuelle',
                'current_image_alt' => 'Image actuelle de la certification',
            ],
            'dropzone' => [
                'prompt' => 'Deposez une image ici ou cliquez pour televerser',
                'create_help' => 'Une image est requise pour les nouvelles certifications.',
                'edit_help' => 'Laissez vide pour conserver l\'image actuelle.',
            ],
        ],
    ],
];
