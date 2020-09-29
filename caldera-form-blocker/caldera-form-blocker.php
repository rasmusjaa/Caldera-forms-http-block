<?php
/**
 * Plugin Name: Caldera block message containing http
 * Plugin URI:        https://github.com/rasmusjaa/caldera-forms-http-block
 * Description:       Help with spam by blocking sending of forms that contain "http" in any form.
 * Version:           1.0.0
 * Author:            Rasmus Jaakonmäki
 * Author URI:        https://lense.fi/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */
add_filter('caldera_forms_get_form_processors', 'message_field_cf_validator_processor');

/**
 * Add a custom processor for field validation
 *
 * @uses 'message_field_cf_validator_processor'
 *
 * @param array $processors Processor configs
 *
 * @return array
 */
function message_field_cf_validator_processor($processors){
    $processors['message_field_cf_validator'] = array(
        'name' => __('Estä http sisältävä kenttä', 'my-text-domain' ),
        'description' => '',
        'pre_processor' => 'message_field_validator',
        'template' => dirname(__FILE__) . '/config.php'

    );

    return $processors;
}

/**
 * Run field validation
 *
 * @param array $config Processor config
 * @param array $form Form config
 *
 * @return array|void Error array if needed, else void.
 */
function message_field_validator( array $config, array $form ){

    //Processor data object
    $data = new Caldera_Forms_Processor_Get_Data( $config, $form, message_field_cf_validator_fields() );

    //Value of field to be validated
    $value = $data->get_value( 'field-to-validate' );

    //if not valid, return an error
    if( false == message_field_cf_validator_is_valid( $value ) ){

        //get ID of field to put error on
        $fields = $data->get_fields();
        $field_id = $fields[ 'field-to-validate' ][ 'config_field' ];

        //Get label of field to use in error message above form
        $field = $form[ 'fields' ][ $field_id ];
        $label = $field[ 'label' ];

        //this is error data to send back
        return array(
            'type' => 'error',
            //this message will be shown above form
            'note' => sprintf( 'Korjaa kenttä %s', $label ),
            //Add error messages for any form field
            'fields' => array(
                //This error message will be shown below the field that we are validating
                $field_id => __( 'Verkko-osoitteet viestissä kielletty', 'text-domain' )
            )
        );
    }

    //If everything is good, don't return anything!

}


/**
 * Check if value is valid
 *
 * @return bool
 */
function message_field_cf_validator_is_valid( $value ){
    return stripos($value, 'http') === false;
}

/**
 * Processor fields
 *
 * @return array
 */
function message_field_cf_validator_fields(){
    return array(
        array(
            'id' => 'field-to-validate',
            'type' => 'text',
            'required' => true,
            'magic' => true,
            'label' => __( 'Valitse viestikentän magic tag', 'my-text-domain' ) // message shown when choosing field magic tag
        ),
    );
}