<?php

return [
    'common' => [
        'cms' => 'CMS',

        'fix_errors' => 'Please fix the following errors:',

        'back_to_list' => 'Return to list',

        'create' => 'Create',

        'update' => 'Update',

        'cancel' => 'Cancel',

        'edit' => 'Edit',

        'delete' => 'Delete',
        'actions' => 'Actions'
    ],

    'certification' => [
        'title' => 'Certifications',
        'list'=> 'List of certifications',

        'add' => 'Add a certification',

        'fields' => [
            'name' => 'Name',

            'slug' => 'Slug',

            'description' => 'Description',

            'language' => 'Language',

            'image' => 'Image',

        ],

        'form' => [
            'title_create' => 'Add a certification',

            'title_edit' => 'Edit the certification',

            'tabs' => [
                'french' => 'French',

                'english' => 'English',
            ],

            'fields' => [
                'name_fr' => 'Name (FR)',

                'name_en' => 'Name (EN)',

                'description_fr' => 'Description (FR)',

                'description_en' => 'Description (EN)',

                'image' => 'Image',

                'current_image' => 'Current image',

                'current_image_alt' => 'Current certification image',
            ],

            'dropzone' => [
                'prompt' => 'Drop an image here or click to upload',

                'create_help' => 'An image is required for new certifications.',
                'edit_help' => 'Leave blank to keep the current image.',
            ],
        ],
    ],
];
