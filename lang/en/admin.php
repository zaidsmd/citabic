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
        'actions' => 'Actions',
        'save'=> 'Save',
        'language'=>[
            'fr'=>'French',
            'en'=>'English',
        ],
        'saved'=>'Saved successfully'
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
    'company_info' => [
        'title' => 'Company Information',
        'subtitle' => 'Manage legal and contact information displayed on the website.',
        'language_title' => 'Editing Language',
        'language_help' => 'Choose the language dataset you want to edit.',
        'last_updated' => 'Last updated',
        'messages' => [
            'updated' => 'Company info updated successfully.',
        ],
        'sections' => [
            'basic_info' => 'Basic Information',
            'contact_info' => 'Contact Information',
            'legal_info' => 'Legal Information',
        ],
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
        ],
        'labels' => [
            'legal_name' => 'Legal Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'legal_form' => 'Legal Form',
            'capital' => 'Capital',
            'ice' => 'ICE',
            'rc' => 'RC',
            'status' => 'Status',
            'creation_date' => 'Creation Date',
            'full_name' => 'Full Name',
        ],
        'placeholders' => [
            'full_name' => 'CITABIC Group',
            'legal_name' => 'CITABIC SARL',
            'legal_form' => 'SARL',
            'address' => 'Company full address',
        ],
        'help' => [
            'full_name' => 'Public display name used across the site.',
        ],
    ],
    'our_approach' => [
        'title' => 'Our Approach',
        'section_title' => 'Section Title',
        'visible'=> 'Visible',
        'design_only'=> 'Design Only',
        'items' => 'Items',
        'add_item' => 'Add Item',
        'icon' => 'Icon',
        'color' => 'Color',
        'item_title' => 'Title',
        'label' => 'Label',
        'description' => 'Description',
        'action' => 'Action',
        'remove' => 'Remove',
        'save_changes' => 'Save Changes',
        'messages' => [
            'updated' => 'Our Approach updated successfully.',
        ],
    ],
    'section'=>[
        'title'=>'Sections of website',
        'hero'=>'Hero Section',
        'about'=>'About Section',
        'contents'=>[
            'labels'=>[
                'hero_title'=>'Hero Title',
                'hero_subtitle'=>'Hero Subtitle',
                'about_title'=>'About title',
                'about_text'=>'About text'
            ]
        ],
        'placeholders'=>[
            'hero_title'=>'Hero Title',
            'hero_subtitle'=>'Hero Subtitle',
            'about_title'=>'About title',
            'about_text'=>'About text'
        ]
    ]
];
