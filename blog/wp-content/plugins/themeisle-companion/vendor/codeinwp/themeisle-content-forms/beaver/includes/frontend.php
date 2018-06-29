<?php
/**
 * The module rendering file
 *
 * @$module object
 * @$settings object
 */
$form_settings = apply_filters( 'content_forms_config_for_' . $module->get_type(), array() );

/** == Fields Validation == */
$controls = $form_settings['controls'];

foreach ( $controls as $control_name => $control ) {
	$control_value = $module->get_setting( $control_name );
	if ( isset( $control['required'] ) && $control['required'] && empty( $control_value ) ) { ?>
		<div class="content-forms-required">
			<?php
			printf(
				esc_html__( 'The %s setting is required!', 'themeisle-companion' ),
				'<strong>' . $control['label'] . '</strong>'
			); ?>
		</div>
		<?php
	}
}

/** == FORM HEADER == */
$module->render_form_header( $module->node );

/** == FORM FIELDS == */
$fields = $module->get_setting( 'fields' );

foreach ( $fields as $key => $field ) {
	$module->render_form_field( (array)$field );
}

$controls = $form_settings['controls'];

/** == FORM SUBMIT BUTTON == */
$btn_label = esc_html__( 'Submit', 'themeisle-companion' );

if ( ! empty( $settings->submit_label ) ) {
	$btn_label = $settings->submit_label;
} ?>
<fieldset>
	<button type="submit" name="submit" value="submit-<?php echo $module->get_type(); ?>-<?php echo $module->node; ?>">
		<?php echo $btn_label; ?>
	</button>
</fieldset>
<?php

/** == FORM FOOTER == */
$module->render_form_footer();