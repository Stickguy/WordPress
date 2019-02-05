/* Add to functions.php */

/**
 * Add custom email field to specific custom template type
 */
class Gok_Meta_Box {
	private $screens = array(
		'page',
	);
	private $fields = array(
		array(
			'id' => 'email',
			'label' => 'Email',
			'type' => 'email',
		),
	);

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
	global $post;
  
  /* Add meta box to pages with the template: lander-one.php */
  
		foreach ( $this->screens as $screen ) {
	 if ( 'lander-one.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
       			add_meta_box(
				'contact-email',
				__( 'Contact Email', 'Rev_2018' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'side',
				'high'
			);
    }	

		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'contact_email_data', 'contact_email_nonce' );
		echo 'Email Address Contact Form should send to';
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'contact_email_' . $field['id'], true );
			switch ( $field['type'] ) {
				default:
					$input = sprintf(
						'<input id="%s" name="%s" type="%s" value="%s">',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= '<p>' . $label . '<br>' . $input . '</p>';
		}
		echo $output;
	}

	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['contact_email_nonce'] ) )
			return $post_id;

		$nonce = $_POST['contact_email_nonce'];
		if ( !wp_verify_nonce( $nonce, 'contact_email_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'contact_email_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'contact_email_' . $field['id'], '0' );
			}
		}
	}
}
new Gok_Meta_Box;

/*---------------------------------------------------------
*-------- Send Auto Responder to email in post meta field Gravity Form 3      ---------
*---------------------------------------------------------*/

function before_email( $email, $message_format, $notification, $entry ) {
	if ( $entry['form_id'] != '3' ) {
        return $email;
    } else {
    $post_id = get_the_ID();
    $myemail = get_post_meta( $post_id, 'contact_email_email', true );
    $email['to'] = $myemail;
    return $email;
	}

}
add_filter( 'gform_pre_send_email', 'before_email', 10, 4 );
