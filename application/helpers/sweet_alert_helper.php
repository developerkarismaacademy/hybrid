<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helper function to display SweetAlert message using session flash data.
 *
 * @param string $title The title of the SweetAlert.
 * @param string $message The message body of the SweetAlert.
 * @param string $type The type of the SweetAlert (success, error, warning, info).
 */
function sweet_alert_flash($title, $message, $type = 'success')
{
	$CI = &get_instance();

	// Check if flash data with the given key exists.
	if ($CI->session->flashdata($title) !== null) {
		// Get the flash data and show the SweetAlert.
		echo '<script>';
		echo '    document.addEventListener("DOMContentLoaded", function() {';
		echo '        Swal.fire({';
		echo "            title: '{$CI->session->flashdata($title)}',";
		echo "            text: '$message',";
		echo "            icon: '$type'";
		echo '        });';
		echo '    });';
		echo '</script>';
	}
}
