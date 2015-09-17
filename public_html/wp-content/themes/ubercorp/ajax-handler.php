<?php
/*
 * Ajax Request handler
 */

/* ---------------------------------------------  */
// Function for processing contact form submission
/* ---------------------------------------------  */

add_action( 'wp_ajax_nopriv_contact_authentication', 'be_themes_contact_authentication' );
add_action( 'wp_ajax_contact_authentication', 'be_themes_contact_authentication' );
	
function be_themes_contact_authentication() {
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_comment = $_POST['contact_comment'];
	$contact_subject = $_POST['contact_subject'];
	if(empty($contact_name) || empty($contact_email) || empty($contact_comment) || empty($contact_subject) ) {
		$result['status']="error";
		$result['data']= __('All fields are required','be-themes');
	}
	else if(!preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $contact_email)) {
		$result['status']="error";
		$result['data']=__('Please enter a valid email address','be-themes');
	}
	else if(!empty($contact_name) && !empty($contact_email) && !empty($contact_comment) && !empty($contact_subject) ) {
		$to=get_settings('admin_email');
		$subject= $contatc_subject;
		$from = $contact_email;
		$headers = "From:" . $from;
		//mail($to,$subject,$contact_comment,$headers);
		$result['status']="sucess";
		$result['data']=__('Your message was sent sucessfully','be-themes');
	}
	header('Content-type: application/json');
	echo json_encode($result);
	die();
}
?>