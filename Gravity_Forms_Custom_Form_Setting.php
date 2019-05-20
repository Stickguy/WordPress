/* Add custom setting checkbox to Gravity Forms > Form Settings > Form Options
 * This will allow later functions determine whether they should fire */

function my_custom_form_setting( $settings, $form ) {
 $enable_donation_entry = ( rgar( $form, 'mysetting_entry' ) ) ? 'checked="checked"' : "";
        $settings['Form Options']['mysetting_entry'] = '
            <tr>
                <th>' . __( "Enable Donation Form", "gravityforms" ) . ' ' . gform_tooltip( "mysetting_entry", "", true ) . '</th>
                <td>
                    <input type="checkbox" id="donation_entry" name="mysetting_entry" value="1" ' . $enable_mysetting_entry . ' />
                    <label for="donation_entry">' . __( "Enable This Setting", "gravityforms" ) . '</label>
                </td>
            </tr>';
        return $settings;
}
add_filter( 'gform_form_settings', 'my_custom_form_setting', 10, 2 );

/* save custom form setting when form is updated */
function save_my_custom_form_setting($form) {
    $form['mysetting_entry'] = rgpost( 'mysetting_entry' );
    return $form;
}
add_filter( 'gform_pre_form_settings_save', 'save_my_custom_form_setting' );
