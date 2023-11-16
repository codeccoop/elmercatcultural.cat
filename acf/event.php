<?php

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_6329c54c0c4b7',
        'title' => 'Esdeveniment',
        'fields' => array(
            array(
                'key' => 'field_6329c591f50b7',
                'label' => "Data de realització de l'esdeveniment o sessió final d'un taller",
                'name' => 'date',
                'type' => 'date_picker',
                'instructions' => "Seleccioneu la data de l'esdeveniment puntual o la data de 
                l'última sessió, en cas de ser un taller recurrent amb vàries sessions",
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_6329c591f50p8',
                'label' => 'Data inicial del taller',
                'name' => 'date_initial',
                'type' => 'date_picker',
                'instructions' => "En cas que aquest esdeveniment duri més d'una sessió, 
                seleccioneu la data corresponent a la primera sessió de les múltiples que tindrà.",
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_6346d023a6704',
                'label' => 'Hora de l\'esdeveniment',
                'name' => 'hour',
                'type' => 'text',
                'instructions' => 'Escriviu l\'hora de l\'esdeveniment (21:00 h) o del taller (de 18.00 a 20.00 h)',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '00:00h',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_6346d0d1a6706',
                'label' => 'Fitxa artística/tècnica',
                'name' => 'artists',
                'type' => 'wysiwyg',
                'instructions' => 'Escriviu una descripció artística o bé tècnica de l\'esdeveniment o el taller',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '100',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_633d6fde70a79',
                'label' => 'Descripció de l\'esdeveniment',
                'name' => 'description_event',
                'type' => 'wysiwyg',
                'instructions' => 'Escriu aquí la descripció de l\'event',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_633558b61e19d',
                'label' => 'Imàtges del carousel',
                'name' => 'carroussel_event',
                'type' => 'group',
                'instructions' => 'En aquesta secció podeu afegir imatges que apareixeran en format carroussel dins la fitxa de l\'esdeveniment. En podeu afegir una, dues o tres.
Si no n\'afegiu cap, a la fitxa de l\'esdeveniment apareixerà la imatge destacada.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_6335592ed3740',
                        'label' => 'imatge carroussel 1',
                        'name' => 'image_carroussel_1',
                        'type' => 'image',
                        'instructions' => 'Escull la primera imatge del carroussel',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => 2000,
                        'max_height' => 2000,
                        'max_size' => '',
                        'mime_types' => 'jpg, jpeg, png, webp',
                    ),
                    array(
                        'key' => 'field_6335598813da5',
                        'label' => 'imatge carroussel 2',
                        'name' => 'image_carroussel_2',
                        'type' => 'image',
                        'instructions' => 'Escull la segona imatge del carroussel',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => 2000,
                        'max_height' => 2000,
                        'max_size' => '',
                        'mime_types' => 'jpg, jpeg, png, webp',
                    ),
                    array(
                        'key' => 'field_6335598513da4',
                        'label' => 'imatge carroussel 3',
                        'name' => 'image_carroussel_3',
                        'type' => 'image',
                        'instructions' => 'Escull la tercera imatge del carroussel',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => 2000,
                        'max_height' => 2000,
                        'max_size' => '',
                        'mime_types' => 'jpg, jpeg, png, webp',
                    ),
                ),
            ),
            array(
                'key' => 'field_633d700b70a7a',
                'label' => 'Vídeo',
                'name' => 'video',
                'type' => 'oembed',
                'instructions' => 'Si vols que aparegui un vídeo incrustat (youtube, vimeo, etc.) enllaça l\'url aquí:',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'width' => 1000,
                'height' => 500,
            ),
            array(
                'key' => 'field_6346d070a6705',
                'label' => 'Preu de l\'esdeveniment',
                'name' => 'price',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_63ac23d589421',
                'label' => 'Gestió d\'inscripcions',
                'name' => 'checkbox',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'Activa la gestió de les inscripcions a través de la web',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6329c5e6f50b8',
                'label' => 'Nombre de places disponibles',
                'name' => 'available_stock',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_63ac23d589421',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_63ac235bd76ee',
                'label' => 'Data d\'inici d\'inscripcions',
                'name' => 'date_sale_from',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_63ac23d589421',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_63ac238ad76ef',
                'label' => 'Data de tancament d\'inscripcions',
                'name' => 'date_sale_to',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_63ac23d589421',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_63ac8baa110f5',
                'label' => 'Enllaç a l\'inscripció',
                'name' => 'external_inscription',
                'type' => 'url',
                'instructions' => 'Utilitzeu aquest camp per indicar on trobar el formulari d\'inscripció a l\'esdeveniment en cas que aquestes no siguin gestionades desde wordpress',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_63ac23d589421',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_63fdf9e2a2924',
                'label' => 'gènere',
                'name' => 'genere',
                'type' => 'select',
                'instructions' => 'Escull una de les opcions per mostrar el camp de gènere al formulari:
- Activitat sense camp de gènere: NO ES MOSTRARÀ
- Activitat per a homes cis: MOSTRARÀ EL CAMP AMB TOTES LES OPCIONS
- Activitat no mixta:	MOSTRARÀ EL CAMP SENSE L\'OPCIÓ HOME CIS',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Activitat sense camp de gènere' => 'Activitat sense camp de gènere',
                    'Activitat per a homes cis' => 'Activitat per a homes cis',
                    'Activitat no mixta' => 'Activitat no mixta',
                ),
                'default_value' => 'Activitat sense camp de gènere',
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'event',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'workshop',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Dates de l\'esdeveniment',
        'show_in_rest' => 1,
    ));

endif;