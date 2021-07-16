<?php
/*
Plugin Name: Custom Registration Fields
Plugin URI:
Description:
Version: 1.2
Author: Megha
Author URI:
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Front end registration
 */

add_action( 'register_form', 'crf_registration_form' );
function crf_registration_form() {

	$name = ! empty( $_POST['name'] ) ? intval( $_POST['name'] ) : '';
	$file = ! empty( $_POST['file'] ) ? intval( $_POST['file'] ) : '';

	?>
	<p>
		<label for="name"><?php esc_html_e( 'name', 'crf' ) ?><br/>
			<input type="text"
			       id="name"
			       name="name"
			       value="<?php echo esc_attr( $name ); ?>"
			       class="input"
			/>
		</label>
		<label for="file"><?php esc_html_e( 'file', 'crf' ) ?><br/>
			<input type="file"
			       id="file"
			       name="file"
			       value="<?php echo esc_attr( $file ); ?>"
			       class="input"
			/>
		</label>
	</p>
	<?php
}

// validating the fields

add_filter( 'registration_errors', 'crf_registration_errors', 10, 3 );
function crf_registration_errors( $errors, $sanitized_user_login, $user_email ) {

	if ( empty( $_POST['name'] ) ) {
		$errors->add( 'name', __( '<strong>ERROR</strong>: Please enter your name', 'crf' ) );
	}
	if ( empty( $_POST['file'] ) ) {
		$errors->add( 'file', __( '<strong>ERROR</strong>: Please upload your file', 'crf' ) );
	}
	return $errors;
}

//Sanitizing and saving the field

add_action( 'user_register', 'crf_user_register' ); //Action ‘user_register‘ fires after a user is inserted into the database. Only now can we store their data as we needed the user ID in order to work with user metadata
function crf_user_register( $user_id ) {
	if ( ! empty( $_POST['name'] ) ) {
		update_user_meta( $user_id, 'name', intval( $_POST['name'] ) );
	}
	if ( ! empty( $_POST['email'] ) ) {
		update_user_meta( $user_id, 'email', intval( $_POST['email'] ) );
	}
}
