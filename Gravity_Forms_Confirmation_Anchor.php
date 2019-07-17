/*-------------------------------------------------------------
* After Gravity Forms submits scroll to confirmation message
* Add this snippet to the functions.php file
*--------------------------------------------------------------*/

add_filter( 'gform_confirmation_anchor', '__return_true' );
