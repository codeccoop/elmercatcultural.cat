<?php

add_filter('woocommerce_billing_fields', function ($fields) {
    unset($fields['billing_state']);
    unset($fields['billing_country']);
    unset($fields['billing_address_1']);
    unset($fields['billing_address_2']);
    unset($fields['billing_city']);
    unset($fields['billing_company']);

    return $fields;
}, 10, 1);

add_filter('woocommerce_shipping_fields', function () {
    return [];
}, 10, 0);

add_filter('woocommerce_checkout_fields', function ($fields) {
    $is_admin = emc_is_admin();

    $fields['billing']['billing_DNI'] = [
        'placeholder' => __('DNI', 'woocommerce'),
        'required' => !$is_admin,
        'class' => ['form-row-wide'],
        'priority' => 9
    ];

    $fields['billing']['billing_birthyear'] = [
        'type' => 'number',
        'placeholder' => __('Any de naixement', 'elmercat'),
        'required'  => $is_admin,
        'class' => ['form-row-wide'],
        'maxlength' => 10,
        'autocomplete' => 'bday',
    ];

    $fields['billing']['billing_first_name'] = array_merge(
        $fields['billing']['billing_first_name'],
        [
            'label' => null,
            'placeholder'   => __('NOM', 'elmercat'),
            'required'  => !$is_admin
        ]
    );

    $fields['billing']['billing_last_name'] = array_merge(
        $fields['billing']['billing_last_name'],
        [
            'label' => null,
            'placeholder'   => __('COGNOMS', 'elmercat'),
            'required'  => !$is_admin
        ]
    );

    $fields['billing']['billing_email'] = array_merge(
        $fields['billing']['billing_email'],
        [
            'label' => null,
            'placeholder'   => __('CORREU ELECTRÒNIC', 'elmercat'),
            'required'  => !$is_admin
        ]
    );

    $fields['billing']['billing_phone'] = array_merge(
        $fields['billing']['billing_phone'],
        [
            'label' => null,
            'placeholder' => __('TELÈFON', 'elmercat'),
            'required'  => !$is_admin
        ]
    );

    $fields['billing']['billing_postcode'] = array_merge(
        $fields['billing']['billing_postcode'],
        [
            'label' => null,
            'placeholder'   => __('CODI POSTAL', 'elmercat'),
            'required'  => false,
            'autocomplete' => 'postal-code',
        ]
    );

    $fields['extra_fields'] = [
        'billing_gender_mixta' => [
            'type' => 'select',
            'class' => ['form-row-wide'],
            'options' => [
                'a' => __('Home Cis', 'elmercat'),
                'b' => __('Home Trans', 'elmercat'),
                'c' => __('Dona Cis', 'elmercat'),
                'd' => __('Dona Trans', 'elmercat'),
                'e' => __('Persona No Binaria', 'elmercat'),
                'f' => __('Altres/Prefereixo no respondre', 'elmercat')
            ],
            'label'  => __('GÈNERE', 'elmercat'),
            'required' => !$is_admin,
        ],
        'billing_gender_no_mixta' => [
            'type' => 'select',
            'class' => ['form-row-wide'],
            'options' => [
                'a' => __('Home Trans', 'elmercat'),
                'b' => __('Dona Cis', 'elmercat'),
                'c' => __('Dona Trans', 'elmercat'),
                'd' => __('Persona No Binaria', 'elmercat'),
                'e' => __('Altres/Prefereixo no respondre', 'elmercat')
            ],
            'label'  => __('GÈNERE', 'elmercat'),
            'required' => !$is_admin,
        ],
        'billing_menu' => [
            'type' => 'select',
            'class' => ['form-row-wide'],
            'label' => __('MENú', 'elmercat'),
            'options' => ['animal' => 'Opció amb procedència d\'animal', 'vegan' => 'Opció vegana'],
            'required' => !$is_admin,
        ],
    ];

    return $fields;
}, 10, 1);

add_action('woocommerce_checkout_after_customer_details', function () {
    $gender_meta = [];
    $menu_meta = [];

    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        $meta = get_post_meta($product->get_id());

        if (isset($meta['genere'])) {
            $gender_meta[] = $meta['genere'][0];
        }

        if (isset($meta['menu'])) {
            $menu_meta[] = $meta['menu'][0];
        }
    }

    ob_start();
    if (sizeof($gender_meta) > 0) {
        $is_admin = emc_is_admin();
        if (in_array('Activitat no mixta', $gender_meta)) : ?>
            <div class="extra-fields">
                <?php woocommerce_form_field('billing_gender_mixta', array(
                    'type' => 'select',
                    'class' => ['form-row-wide'],
                    'options' => [
                        'Home Cis' => 'Home Cis',
                        'Home Trans' => 'Home Trans',
                        'Dona Cis' => 'Dona Cis',
                        'Dona Trans' => 'Dona Trans',
                        'Persona No Binaria' => 'Persona No Binaria',
                        'Altres/Prefereixo no respondre' => 'Altres/Prefereixo no respondre',
                    ],
                    'label'  => __('GÈNERE', 'elmercat'),
                    'required' => !$is_admin,
                )); ?>
            </div>
        <?php elseif (in_array('Activitat per a homes cis', $gender_meta)) : ?>
            <div class="extra-fields">
                <?php woocommerce_form_field('billing_gender_no_mixta', array(
                    'type' => 'select',
                    'class' => ['form-row-wide'],
                    'options' => [
                        'Home Trans' => 'Home Trans',
                        'Dona Cis' => 'Dona Cis',
                        'Dona Trans' => 'Dona Trans',
                        'Persona No Binaria' => 'Persona No Binaria',
                        'Altres/Prefereixo no respondre' => 'Altres/Prefereixo no respondre'
                    ],
                    'label'  => __('GÈNERE', 'elmercat'),
                    'required' => !$is_admin,
                )); ?>
            </div>
        <?php endif;
    }

    if (sizeof($menu_meta) > 0) {
        if (in_array('1', $menu_meta)) : ?>
            <div class="extra-fields">
                <?php woocommerce_form_field('billing_menu', [
                    'type' => 'select',
                    'class' => ['form-row-wide'],
                    'options' => ['animal' => 'Opció amb procedència d\'animal', 'vegan' => 'Opció vegana'],
                    'label' => __('MENÚ', 'elmercat'),
                    'required' => !$is_admin,
                ]); ?>
            </div>
        <?php endif;
    }

    $extra_fields = ob_get_clean();
    if (strlen($extra_fields) > 0) : ?>
        <div class="extra-fields">
            <h4 style="border-bottom:2px solid #e3d0b9;text-transform:uppercase;padding-bottom:1rem">Camps adicionals</h4>
            <?= $extra_fields ?>
        </div>
    <?php endif;
});

add_action('woocommerce_checkout_create_order', function ($order, $data) {
    $dni = sanitize_text_field($data['billing_DNI']);
    $order->update_meta_data('billing_DNI', $dni);

    $birthyear = (int) $data['billing_birthyear'];
    $order->update_meta_data('billing_birthyear', $birthyear);

    if (isset($data['billing_gender_mixta']) && !empty($data['billing_gender_mixta'])) {
        $value = sanitize_text_field($data['billing_gender_mixta']);
        $order->update_meta_data('billing_gender_mixta', $value);
    }

    if (isset($data['billing_gender_no_mixta']) && !empty($data['billing_gender_no_mixta'])) {
        $value = sanitize_text_field($data['billing_gender_no_mixta']);
        $order->update_meta_data('billing_gender_no_mixta', $value);
    }

    if (isset($data['billing_menu'])) {
        $value = sanitize_text_field($data['billing_menu']);
        $order->update_meta_data('billing_menu', $value);
    }
}, 10, 2);

add_action('woocommerce_admin_order_data_after_billing_address', function ($order) {
    ?>
        <p><b>DNI:</b><?php echo $order->get_meta('billing_DNI'); ?></p> 
        <p><b>Any de naixement:</b><?php echo $order->get_meta('billing_birthyear'); ?></p> 
    <?php

    if ($order->get_meta('billing_gender_mixta')) : ?>
        <p><b>Gènere de la persona inscrita:</b><?= $order->get_meta('billing_gender_mixta'); ?></p>
    <?php elseif ($order->get_meta('billing_gender_no_mixta')) : ?>
        <p><b>Gènere de la persona inscrita:</b><?= $order->get_meta('billing_gender_no_mixta'); ?></p>
    <?php endif;

    if ($order->get_meta('billing_menu')) : ?>
        <p><b>Gènere de la persona inscrita:</b><?= $order->get_meta('billing_menu'); ?></p>
    <?php endif;
});

add_action('woocommerce_review_order_before_submit', function () {
    $is_admin = emc_is_admin();

    woocommerce_form_field('privacy_checkbox', array(
        'type' => 'checkbox',
        'class' => array('emc_privacy_checkbox'),
        'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'required' => !$is_admin,
        'label' => "Accepto la <a href='/politica-de-privacitat' target='_blank' rel='noopener'>Política de Privacitat</a>. Les dades personals s'utilitzaran per processar la comanda, millorar l'experiència d'usuari en aquest lloc web.", // Label and Link
    ));

    woocommerce_form_field('policy_checkbox', array(
        'type' => 'checkbox',
        'class' => array('emc_policy_checkbox'),
        'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'required' => !$is_admin,
        'label' => "Accepto la <a href='/politica-dinscripcions-i-cancelacio' target='_blank' rel='noopener'>Política d'Inscripcions i Cancelacions</a>.", // Label and Link
    ));
});

add_action('woocommerce_after_checkout_validation', function ($fields, $errors) {
    if (!empty($errors->get_error_codes())) {
        foreach ($errors->get_error_codes() as $code) {
            $errors->remove($code);
        }

        $errors->add('validation', '');
    }
}, 99, 2);

add_action('woocommerce_checkout_process', function () {
    $is_admin = emc_is_admin();
    if ($is_admin) {
        return;
    }

    if (!$_POST['billing_first_name']) {
        wc_add_notice(__('És obligatori introduir el NOM'), 'error');
    }

    if (!$_POST['billing_last_name']) {
        wc_add_notice(__('És obligatori introduir els COGNOMS'), 'error');
    }

    if (!$_POST['billing_email']) {
        wc_add_notice(__('És obligatori introduir un CORREU ELECTRÒNIC vàlid'), 'error');
    }

    if (!$_POST['billing_DNI']) {
        wc_add_notice(__('És obligatori introduir el DNI'), 'error');
    } else {
        $validation = elmercatcultural_validate_id($_POST['billing_DNI']);
        if (!$validation['valid']) {
            wc_add_notice(__('El valor del camp DNI és invàlid'), 'error');
        }
    }

    if (!$_POST['billing_birthyear']) {
        wc_add_notice(__('És obligatori introduir la DATA DE NAIXEMENT'), 'error');
    }

    if (!isset($_POST['privacy_checkbox'])) {
        wc_add_notice(__("Heu d'acceptar la política de privadesa"), 'error');
    }

    if (!isset($_POST['policy_checkbox'])) {
        wc_add_notice(__("Heu d'acceptar la política d'inscripcions i cancelacions"), 'error');
    }
});

add_filter('woocommerce_order_button_text', function () {
    return 'Confirma la inscripció';
});
