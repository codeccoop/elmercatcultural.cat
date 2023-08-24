<?php
/* Remove billing fields */
add_filter('woocommerce_checkout_fields', 'elmercatcultural_remove_checkout_fields');
function elmercatcultural_remove_checkout_fields($fields)
{
	// Billing fields
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_address_1']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_city']);

	// Shipping fields
	unset($fields['shipping']['shipping_state']);
	unset($fields['shipping']['shipping_country']);
	unset($fields['shipping']['shipping_address_1']);
	unset($fields['shipping']['shipping_address_2']);
	unset($fields['shipping']['shipping_city']);

	// Order fields
	return $fields;
}

/* Unrequire billing fields */
add_filter('woocommerce_checkout_fields', 'unrequire_checkout_fields');
function unrequire_checkout_fields($fields)
{
	$fields['billing']['billing_city']['required'] = false;
	$fields['billing']['billing_city']['class'] = array('field-remove');
	$fields['billing']['billing_country']['required'] = false;
	$fields['billing']['billing_country']['class'] = array('field-remove');
	$fields['billing']['billing_state']['required'] = false;
	$fields['billing']['billing_state']['class'] = array('field-remove');
	$fields['billing']['billing_address_1']['required'] = false;
	$fields['billing']['billing_address_1']['class'] = array('field-remove');
	$fields['billing']['billing_address_2']['required'] = false;
	$fields['billing']['billing_address_2']['class'] = array('field-remove');

	$fields['shipping']['shipping_city']['required'] = false;
	$fields['shipping']['shipping_city']['class'] = array('field-remove');
	$fields['shipping']['shipping_country']['required'] = false;
	$fields['shipping']['shipping_country']['class'] = array('field-remove');
	$fields['shipping']['shipping_state']['required'] = false;
	$fields['shipping']['shipping_state']['class'] = array('field-remove');
	$fields['shipping']['shipping_address_1']['required'] = false;
	$fields['shipping']['shipping_address_1']['class'] = array('field-remove');
	$fields['shipping']['shipping_address_2']['required'] = false;
	$fields['shipping']['shipping_address_2']['class'] = array('field-remove');

	return $fields;
}

/* Add custom billing fields */
add_filter('woocommerce_checkout_fields', 'elmercatcultural_override_checkout_fields');
function elmercatcultural_override_checkout_fields($fields)
{
	$fields['billing']['billing_DNI'] = array(
		'placeholder'   => _x('DNI', 'placeholder', 'woocommerce'),
		'required'  => true,
		'class'     => array('form-row-wide'),
		'clear'     => true,
		'priority' => 9
	);
	$fields['billing']['billing_birthday'] = array(
		'placeholder'   => _x('DATA NAIXEMENT (dd/mm/aaaa)', 'placeholder', 'woocommerce'),
		'required'  => true,
		'class'     => array('form-row-wide'),
		'clear'     => true,
		'maxlength' => 10
	);
	//add placeholder to native fields

	$fields['billing']['billing_first_name'] = array(
		'placeholder'   => _x('NOM', 'placeholder', 'woocommerce'),
		'required'  => true
	);
	$fields['billing']['billing_last_name'] = array(
		'placeholder'   => _x('COGNOMS', 'placeholder', 'woocommerce'),
		'required'  => true
	);
	$fields['billing']['billing_email'] = array(
		'placeholder'   => _x('CORREU ELECTRÒNIC', 'placeholder', 'woocommerce'),
		'required'  => true
	);
	$fields['billing']['billing_phone'] = array(
		'placeholder'   => _x('TELÈFON', 'placeholder', 'woocommerce'),
		'required'  => true
	);
	$fields['billing']['billing_postcode'] = array(
		'placeholder'   => _x('CODI POSTAL', 'placeholder', 'woocommerce'),
		'class'     => array('form-row-wide'),
		'required'  => false
	);

	return $fields;
}

// Create radio button
add_action('radio_input_veina', 'elmercatcultural_new_radio_field');
function elmercatcultural_new_radio_field($checkout)
{
	woocommerce_form_field('billing_neighbour', array(
		'type' => 'radio',
		'class' => array('veina-radio-input', 'form-row-wide', 'update_totals_on_change'),
		'options' => array('1' => 'Si', '2' => 'No',),
		'label'  => __("VEÏNA DELS BARRIS DE MUNTANYA?"),
		'required' => true,
	), $checkout->get_value('billing_neighbour'));
}


/* Add gender custom field and display conditonally depending on post meta */
add_filter('woocommerce_checkout_fields', 'elmercatcultural_filter_checkout_fields');
function elmercatcultural_filter_checkout_fields($fields)
{
	$fields['extra_fields'] = array(
		'billing_gender_mixta' => array(
			'type' => 'select',
			'class' => array('form-row-wide'),
			'options' => array('a' => __('Home Cis'), 'b' => __('Home Trans'), 'c' => __('Dona Cis'), 'd' => __('Dona Trans'), 'e' => __('Persona No Binaria'), 'f' => __('Altres/Prefereixo no respondre')),
			'label'  => __("GÈNERE"),
			'required' => true
		),
		'billing_gender_no_mixta' => array(
			'type' => 'select',
			'class' => array('form-row-wide'),
			'options' => array('a' => ('Home Trans'), 'b' => __('Dona Cis'), 'c' => __('Dona Trans'), 'd' => __('Persona No Binaria'), 'e' => __('Altres/Prefereixo no respondre')),
			'label'  => __("GÈNERE"),
			'required' => true,
		)
	);

	return $fields;
}

add_action('woocommerce_checkout_after_customer_details', 'elmercatcultural_extra_checkout_fields');
function elmercatcultural_extra_checkout_fields()
{
	foreach (WC()->cart->get_cart() as $cart_item) {
		// Get the WC_Product object (instance)
		$product = $cart_item['data'];
		$meta = get_post_meta($product->get_id());
	}

	// because of this foreach, everything added to the array in the previous function will display automagically
	if (!isset($meta['genere'])) {
		return;
	}
	if ($meta['genere'][0] == 'Activitat per a homes cis') : ?>
		<div class="extra-fields">
			<?php woocommerce_form_field('billing_gender_mixta', array(
				'type' => 'select',
				'class' => array('form-row-wide'),
				'options' => array('Home Cis' => 'Home Cis', 'Home Trans' => 'Home Trans', 'Dona Cis' => 'Dona Cis', 'Dona Trans' => 'Dona Trans', 'Persona No Binaria' => 'Persona No Binaria', 'Altres/Prefereixo no respondre' => 'Altres/Prefereixo no respondre'),
				'label'  => __("GÈNERE"),
				'required' => true,
			)); ?>
		</div>
	<?php elseif ($meta['genere'][0] == 'Activitat no mixta') : ?>
		<div class="extra-fields">
			<?php woocommerce_form_field('billing_gender_no_mixta', array(
				'type' => 'select',
				'class' => array('form-row-wide'),
				'options' => array('Home Trans' => 'Home Trans', 'Dona Cis' => 'Dona Cis', 'Dona Trans' => 'Dona Trans', 'Persona No Binaria' => 'Persona No Binaria', 'Altres/Prefereixo no respondre' => 'Altres/Prefereixo no respondre'),
				'label'  => __("GÈNERE"),
				'required' => true,
			)); ?>
		</div>
	<?php endif;
}

/* Save the extra data */
add_action('woocommerce_checkout_create_order', 'elmercatcultural_save_extra_checkout_fields', 10, 2);
function elmercatcultural_save_extra_checkout_fields($order, $data)
{
	// don't forget appropriate sanitization if you are using a different field type
	if (isset($data['billing_gender_mixta'])) {
		$note = sanitize_text_field($data['billing_gender_mixta']);
		$order->update_meta_data('billing_gender_mixta', $note);
		// $order->add_order_note( $note );
		// $order->save();
	}
	if (isset($data['billing_gender_no_mixta'])) {
		$note = sanitize_text_field($data['billing_gender_no_mixta']);
		$order->update_meta_data('billing_gender_no_mixta', $note);
		// $order->add_order_note( $note );
		// $order->save();
	}
}

/* Display extra data in admin */
add_action('woocommerce_admin_order_data_after_order_details', 'elmercatcultural_display_order_data_in_admin');
function elmercatcultural_display_order_data_in_admin($order)
{
	if ($order->get_meta('billing_gender_mixta')) : ?>
		<h4><?php _e('Informació sobre el gènere de la persona inscrita', 'woocommerce'); ?></h4>

	<?php
		echo '<p><strong>' . __('Gènere') . ':</strong>' . $order->get_meta('billing_gender_mixta') . '</p>';
	elseif ($order->get_meta('billing_gender_no_mixta')) : ?>
		<h4><?php _e('Informació sobre el gènere de la persona inscrita', 'woocommerce'); ?></h4>
<?php echo '<p><strong>' . __('Gènere') . ':</strong>' . $order->get_meta('billing_gender_no_mixta') . '</p>';
	endif;
}

/* ADD CHECKBOX FIELD AND WARNING FOR PRIVACY POLICY */
add_action('woocommerce_review_order_before_submit', 'elmercatcultural_add_checkout_checkbox', 10);
function elmercatcultural_add_checkout_checkbox()
{

	woocommerce_form_field('privacy_checkbox', array( // CSS ID
		'type'          => 'checkbox',
		'class'         => array('emc_privacy_checkbox'), // CSS Class
		'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
		'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
		'required'      => true, // Mandatory or Optional
		'label'         => "Accepto la <a href='/politica-de-privacitat' target='_blank' rel='noopener'>Política de Privacitat</a>. Les dades personals s'utilitzaran per processar la comanda, millorar l'experiència d'usuari en aquest lloc web.", // Label and Link
	));
	woocommerce_form_field('newsletter_checkbox', array( // CSS ID
		'type'          => 'checkbox',
		'class'         => array('emc_newsletter_checkbox'), // CSS Class
		'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox newsletter'),
		'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox newsletter-checkbox'),
		'required'      => false, // Mandatory or Optional
		'label'         => "Vull rebre els correus de elMercat i subscriure'm a la newsletter", // Label and Link
	));
}

/* DISPLAY CUSTOM MESSAGES WHEN FIELDS ARE EMPTY */
add_action('woocommerce_after_checkout_validation', 'quadlayers', 9999, 2);
function quadlayers($fields, $errors)
{
	// in case any validation errors
	if (!empty($errors->get_error_codes())) {

		// omit all existing error messages
		foreach ($errors->get_error_codes() as $code) {
			$errors->remove($code);
		}
		// display custom single error message
		$errors->add('validation', '');
	}
}

/* Checkout validation notices */
add_action('woocommerce_checkout_process', 'elmercatcultural_checkout_field_process');
function elmercatcultural_checkout_field_process()
{
	$isvalid = true;

	if (!$_POST['billing_first_name']) {
		$isvalid = false;
		wc_add_notice(__('És obligatori introduir el NOM'), 'error');
	}

	if (!$_POST['billing_last_name']) {
		$isvalid = false;
		wc_add_notice(__('És obligatori introduir els COGNOMS'), 'error');
	}

	if (!$_POST['billing_email']) {
		$isvalid = false;
		wc_add_notice(__('És obligatori introduir un CORREU ELECTRÒNIC vàlid'), 'error');
	}

	if (!$_POST['billing_neighbour']) {
		$isvalid = false;
		wc_add_notice(__('És obligatori marcar una opció a la pregunta VEÏNA DELS BARRIS DE MUNTANYA?'), 'error');
	}

	if (!$_POST['billing_DNI']) {
		$isvalid = false;
		wc_add_notice(__('És obligatori introduir el DNI'), 'error');
	} else {
		$validation = elmercatcultural_validate_id($_POST['billing_DNI']);
		if (!$validation['valid']) {
			$isvalid = false;
			wc_add_notice(__('El valor del camp DNI és invàlid'), 'error');
		}
	}

	if (!$_POST['billing_birthday']) {
		$isvalid = false;
		wc_add_notice(__('És obligatori introduir la DATA DE NAIXEMENT'), 'error');
	} else {
		$dateFormat = '/^\d{2}\/[0-1]{1}[1-9]{1}\/\d{4}$/';
		if (!preg_match($dateFormat, $_POST['billing_birthday'])) {
			$isvalid = false;
			wc_add_notice(__('El valor del camp DATA DE NAIXEMENT és invàlid'), 'error');
		}
	}

	if (!isset($_POST['privacy_checkbox'])) {
		$isvalid = false;
		wc_add_notice(__("Heu d'acceptar la política de privadesa"), 'error');
	}

	if ($isvalid && isset($_POST['newsletter_checkbox'])) {
		try {
			elmercatcultural_submit_email_to_newsletter();
		} catch (Exception $e) {
			wc_add_notice(__("No us heu pogut subscriure a la Newsletter: " . $e->getMessage()), 'notice');
		}
	}
}

add_action('woocommerce_checkout_update_order_meta', 'elmercatcultural_update_order_meta');
function elmercatcultural_update_order_meta($order_id)
{
	if (!empty($_POST['billing_birthday'])) {
		update_post_meta($order_id, 'DATA NAIXEMENT', sanitize_text_field($_POST['customised_field_name']));
	}
}
