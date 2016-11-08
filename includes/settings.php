<?php
	
//Create settings page
add_action('admin_menu', 'ctct_settings');
function ctct_settings(){
	add_options_page('CPO Content Types', 'CPO Content Types', 'manage_options', 'ctct_settings', 'ctct_settings_page');
}

//Render settings page
function ctct_settings_page(){
	echo '<div class="wrap">';
	echo '<h2>CPO Content Types</h2>';
	//settings_errors();
	echo '<form method="post" action="options.php">';
    settings_fields('ctct_settings');
    do_settings_sections('ctct_settings');          
    submit_button();
    echo '</form>';
	echo '</div>';
}


//Create settings fields
add_action('admin_init', 'ctct_settings_fields');
function ctct_settings_fields(){
	$option_values = get_option('ctct_settings');
	
	//Register new setting
	register_setting('ctct_settings', 'ctct_settings', 'ctct_flush_rewrite_rules');		
	
	//Add sections to the settings page
	$settings = ctct_metadata_sections();
	foreach($settings as $setting_id => $setting_data){
		add_settings_section($setting_id, $setting_data['label'], 'ctct_settings_section', 'ctct_settings');
	}
	
	//Add settings & controls
	$settings = ctct_metadata_settings();
	foreach($settings as $setting_id => $setting_data){
		$setting_data['id'] = $setting_id;
		$setting_data['value'] = isset($option_values[$setting_id]) ? $option_values[$setting_id] : '';
		add_settings_field($setting_id, $setting_data['label'], 'ctct_settings_field', 'ctct_settings' , $setting_data['section'], $setting_data);
	}
}


function ctct_settings_section($args){
	$settings = ctct_metadata_sections();
	foreach($settings as $setting_id => $setting_data){
		if($args['id'] == $setting_id)
			echo '<p>'.$setting_data['description'].'</p>';
	}
}


function ctct_settings_field($args){ 
	if(!isset($args['class'])) $args['class'] = '';
	if(!isset($args['placeholder'])) $args['placeholder'] = '';
	switch($args['type']){
		case 'text': 
		echo '<input name="ctct_settings['.$args['id'].']" type="text" id="'.$args['id'].'" value="'.$args['value'].'" placeholder="'.$args['placeholder'].'" class="'.$args['class'].'"/>';
		break;
		
		case 'checkbox':
		echo '<label for="'.$args['id'].'"><input name="ctct_settings['.$args['id'].']" type="checkbox" value="1" id="'.$args['id'].'" '.checked(1, $args['value'], false).'" placeholder="'.$args['placeholder'].'" class="'.$args['class'].'"/> '.$args['description'].'</label>';
		break;
	}
}


//Abstracted function for retrieving specific options inside option arrays
function ctct_get_option($option_name = '', $option_array = 'ctct_settings'){
	//Determines whether to grab current language, or original language's option
	$option_list_name = $option_array;
	$option_list = get_option($option_list_name, false);
	if($option_list && isset($option_list[$option_name]))
		$option_value = $option_list[$option_name];
	else
		$option_value = false;
	return $option_value;
}


//Flush rules on saving settings
function ctct_flush_rewrite_rules($value){
    flush_rewrite_rules();
	return $value;
}