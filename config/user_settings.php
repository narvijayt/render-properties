<?php

// Provide defaults for user settings to be used by the user->settings
// relationship to provide a default settings model if one does not
// exist
return [
	'match_by_exp_min'								=> 0,
	'match_by_exp_max'								=> 100,
	'match_by_sales_total_min'						=> 0,
	'match_by_sales_total_max'						=> 1000,
	'match_by_sales_value_min'						=> 0,
	'match_by_sales_value_max'						=> 80000000,

	'email_receive_conversation_messages' 			=> true,
	'email_receive_match_requests' 					=> true,
	'email_receive_match_suggestions' 				=> true,
	'email_receive_review_messages' 				=> true,
	'email_receive_weekly_update_email'				=> true,
	'email_receive_email_confirmation_reminders'	=> true,
];;