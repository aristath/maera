<?php

if ( ! class_exists( 'EDD_SL_Theme_Updater' ) ) {
	include( dirname( __FILE__ ) . '/EDD_SL_Theme_Updater.php' );
}

function maera_theme_updater() {

	$edd_updater = new EDD_SL_Theme_Updater( array(
			'remote_api_url' 	=> 'http://press.codes/',
			'version' 			=> '1.0-beta1',
			'license' 			=> 'c5305a091a9e61268c5be6096bfa3d38',
			'item_name' 		=> 'Maera',
			'author'			=> 'aristath, fovoc'
		)
	);
}
add_action( 'admin_init', 'maera_theme_updater' );


function maera_theme_activate_license() {
	global $wp_version;

	// If the license is valid there's no need to process this further.
	if ( get_transient( 'maera_theme_license_status' ) == 'valid' ) {
		return;
	}

	$api_params = array(
		'edd_action' => 'activate_license',
		'license'    => 'c5305a091a9e61268c5be6096bfa3d38',
		'item_name'  => urlencode( 'Maera' )
	);

	// Get the server response
	$response = wp_remote_get( add_query_arg( $api_params, 'http://press.codes/' ), array( 'timeout' => 15, 'sslverify' => false ) );

	// Make sure no error has occured
	if ( is_wp_error( $response ) ) {
		return false;
	}

	// Get the license data
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if ( 'valid' == $license_data->license ) {
		// Set a 24-hour transient.
		set_transient( 'maera_theme_license_status', $license_data->license, 24 * 60 * 60 );
	}
}
add_action('admin_init', 'maera_theme_activate_license');
