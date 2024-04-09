<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_calendar', 'ovaem_calendar');
function ovaem_calendar($atts, $content = null) {

		// Calendar
		wp_enqueue_script('moment', OVAEM_PLUGIN_URI.'/assets/libs/fullcalendar/moment.min.js', array('jquery'),null,true);
		wp_enqueue_script('fullcalendar', OVAEM_PLUGIN_URI.'assets/libs/fullcalendar/fullcalendar.min.js', array('jquery'),null,true);
		wp_enqueue_script('locale', OVAEM_PLUGIN_URI.'/assets/libs/fullcalendar/locale-all.js', array('jquery'),null,true);

		// Calendar
		wp_enqueue_style('fullcalendar', OVAEM_PLUGIN_URI.'assets/libs/fullcalendar/fullcalendar.min.css', array(), null );		

      $atts = extract( shortcode_atts(
	    array(
	    	'filter' => '',
	    	'cat' => '',
	    	'show_past'	=> 'true',
	    	'local' => 'en',
	    	'time_zone' => '',
	    	'first_day' => '0',
	      	'class'   => '',
	    ), $atts) );

    $prefix = OVAEM_Settings::$prefix;

	$array_event = array();

	$eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count = -1, $cat, $orderby = 'date', $order = 'ASC', $show_past );
	$i = 0;
	if( $eventlist->have_posts() ): while( $eventlist->have_posts() ): $eventlist->the_post();
		
		$start = get_post_meta( get_the_id(), $prefix.'_date_start_time', true );
		$end = get_post_meta( get_the_id(), $prefix.'_date_end_time', true );

		if( $start && $end ){
			$array_event[$i]['title'] = get_the_title();
			$array_event[$i]['start'] = date( 'Y-m-d', $start );
			$array_event[$i]['end'] = date( 'Y-m-d', $end+24*60*60 );
			$array_event[$i]['url'] = get_the_permalink();
			$i++;	
		}

		
	endwhile;endif; wp_reset_query();

	$unique = uniqid();

	if( $array_event ){
		wp_localize_script( 'ovaem_script', 'ovaem_list_event'.$unique, $array_event );
		wp_enqueue_script( 'ovaem_script' );
	}

	// Calendar header
	$header_left 	= apply_filters( 'ovaft_header_left_calendar', 'prev,next today' );
	$header_center 	= apply_filters( 'ovaft_header_center_calendar', 'title, prevYear, nextYear' );
	$header_right 	= apply_filters( 'ovaft_header_right_calendar', 'month,agendaWeek,agendaDay,listWeek' );

	$html = '<div class="'.$class.'">';
       $html .=  '<div class="event_calendar" data-listevent="ovaem_list_event'.$unique.'" data-local="'.$local.'" data-time_zone="'.$time_zone.'" data-first-day="'.$first_day.'" data-header-left="'.$header_left.'" data-header-center="'.$header_center.'" data-header-right="'.$header_right.'"></div>';
    $html .= '</div>';

	return $html;

}



if(function_exists('vc_map')){

    	$cats = apply_filters('ovaem_get_categories', 10);
    	$cats_arr = array( '' => esc_html__('--- Select Category ---', 'ovaem-events-manager') );
    	foreach ($cats as $key => $value) {
    		$cats_arr[$value->slug] = $value->name;
    	}
    	


    	$local_arr = array(
    		'en' => 'en','af' => 'af','ar-dz' => 'ar-dz','ar-kw' => 'ar-kw','ar-ly' => 'ar-ly','ar-ma' => 'ar-ma','ar-sa' => 'ar-sa','ar-tn' => 'ar-tn','ar' => 'ar','bg' => 'bg','bs' => 'bs','ca' => 'ca','cs' => 'cs','da' => 'da','de-at' => 'de-at','de-ch' => 'de-ch','de' => 'de','el' => 'el','en-au' => 'en-au','en-ca' => 'en-ca','en-gb' => 'en-gb','en-ie' => 'en-ie','en-nz' => 'en-nz','es-do' => 'es-do','es-us' => 'es-us','es' => 'es','et' => 'et','eu' => 'eu','fa' => 'fa','fi' => 'fi','fr-ca' => 'fr-ca','fr-ch' => 'fr-ch','fr' => 'fr','gl' => 'gl','he' => 'he','hi' => 'hi','hr' => 'hr','hu' => 'hu','id' => 'id','is' => 'is','it' => 'it','ja' => 'ja','ka' => 'ka','kk' => 'kk','ko' => 'ko','lb' => 'lb','lt' => 'lt','lv' => 'lv','mk' => 'mk','ms-my' => 'ms-my','ms' => 'ms','nb' => 'nb','nl-be' => 'nl-be','nl' => 'nl','nn' => 'nn','pl' => 'pl','pt-br' => 'pt-br','pt' => 'pt','ro' => 'ro','ru' => 'ru','sk' => 'sk','sl' => 'sl','sq' => 'sq','sr-cyrl' => 'sr-cyrl','sr' => 'sr','sv' => 'sv','th' => 'th','tr' => 'tr','uk' => 'uk','vi' => 'vi','zh-cn' => 'zh-cn','zh-tw' => 'zh-tw'
    	);

    	$time_zone_arr = array(
        '' => 'none',
        'local' => 'local',
        'UTC' => 'UTC',
      'Africa/Abidjan' => 'Africa/Abidjan','Africa/Accra' => 'Africa/Accra','Africa/Addis_Ababa' => 'Africa/Addis_Ababa','Africa/Algiers' => 'Africa/Algiers','Africa/Asmara' => 'Africa/Asmara','Africa/Bamako' => 'Africa/Bamako','Africa/Bangui' => 'Africa/Bangui','Africa/Banjul' => 'Africa/Banjul','Africa/Bissau' => 'Africa/Bissau','Africa/Blantyre' => 'Africa/Blantyre','Africa/Brazzaville' => 'Africa/Brazzaville','Africa/Bujumbura' => 'Africa/Bujumbura','Africa/Cairo' => 'Africa/Cairo','Africa/Casablanca' => 'Africa/Casablanca','Africa/Ceuta' => 'Africa/Ceuta','Africa/Conakry' => 'Africa/Conakry','Africa/Dakar' => 'Africa/Dakar','Africa/Dar_es_Salaam' => 'Africa/Dar_es_Salaam','Africa/Djibouti' => 'Africa/Djibouti','Africa/Douala' => 'Africa/Douala','Africa/El_Aaiun' => 'Africa/El_Aaiun','Africa/Freetown' => 'Africa/Freetown','Africa/Gaborone' => 'Africa/Gaborone','Africa/Harare' => 'Africa/Harare','Africa/Johannesburg' => 'Africa/Johannesburg','Africa/Juba' => 'Africa/Juba','Africa/Kampala' => 'Africa/Kampala','Africa/Khartoum' => 'Africa/Khartoum','Africa/Kigali' => 'Africa/Kigali','Africa/Kinshasa' => 'Africa/Kinshasa','Africa/Lagos' => 'Africa/Lagos','Africa/Libreville' => 'Africa/Libreville','Africa/Lome' => 'Africa/Lome','Africa/Luanda' => 'Africa/Luanda','Africa/Lubumbashi' => 'Africa/Lubumbashi','Africa/Lusaka' => 'Africa/Lusaka','Africa/Malabo' => 'Africa/Malabo','Africa/Maputo' => 'Africa/Maputo','Africa/Maseru' => 'Africa/Maseru','Africa/Mbabane' => 'Africa/Mbabane','Africa/Mogadishu' => 'Africa/Mogadishu','Africa/Monrovia' => 'Africa/Monrovia','Africa/Nairobi' => 'Africa/Nairobi','Africa/Ndjamena' => 'Africa/Ndjamena','Africa/Niamey' => 'Africa/Niamey','Africa/Nouakchott' => 'Africa/Nouakchott','Africa/Ouagadougou' => 'Africa/Ouagadougou','Africa/Porto-Novo' => 'Africa/Porto-Novo','Africa/Sao_Tome' => 'Africa/Sao_Tome','Africa/Tripoli' => 'Africa/Tripoli','Africa/Tunis' => 'Africa/Tunis','Africa/Windhoek' => 'Africa/Windhoek','America/Adak' => 'America/Adak','America/Anchorage' => 'America/Anchorage','America/Anguilla' => 'America/Anguilla','America/Antigua' => 'America/Antigua','America/Araguaina' => 'America/Araguaina','America/Argentina/Buenos_Aires' => 'America/Argentina/Buenos_Aires','America/Argentina/Catamarca' => 'America/Argentina/Catamarca','America/Argentina/Cordoba' => 'America/Argentina/Cordoba','America/Argentina/Jujuy' => 'America/Argentina/Jujuy','America/Argentina/La_Rioja' => 'America/Argentina/La_Rioja','America/Argentina/Mendoza' => 'America/Argentina/Mendoza','America/Argentina/Rio_Gallegos' => 'America/Argentina/Rio_Gallegos','America/Argentina/Salta' => 'America/Argentina/Salta','America/Argentina/San_Juan' => 'America/Argentina/San_Juan','America/Argentina/San_Luis' => 'America/Argentina/San_Luis','America/Argentina/Tucuman' => 'America/Argentina/Tucuman','America/Argentina/Ushuaia' => 'America/Argentina/Ushuaia','America/Aruba' => 'America/Aruba','America/Asuncion' => 'America/Asuncion','America/Atikokan' => 'America/Atikokan','America/Bahia' => 'America/Bahia','America/Bahia_Banderas' => 'America/Bahia_Banderas','America/Barbados' => 'America/Barbados','America/Belem' => 'America/Belem','America/Belize' => 'America/Belize','America/Blanc-Sablon' => 'America/Blanc-Sablon','America/Boa_Vista' => 'America/Boa_Vista','America/Bogota' => 'America/Bogota','America/Boise' => 'America/Boise','America/Cambridge_Bay' => 'America/Cambridge_Bay','America/Campo_Grande' => 'America/Campo_Grande','America/Cancun' => 'America/Cancun','America/Caracas' => 'America/Caracas','America/Cayenne' => 'America/Cayenne','America/Cayman' => 'America/Cayman','America/Chicago' => 'America/Chicago','America/Chihuahua' => 'America/Chihuahua','America/Costa_Rica' => 'America/Costa_Rica','America/Creston' => 'America/Creston','America/Cuiaba' => 'America/Cuiaba','America/Curacao' => 'America/Curacao','America/Danmarkshavn' => 'America/Danmarkshavn','America/Dawson' => 'America/Dawson','America/Dawson_Creek' => 'America/Dawson_Creek','America/Denver' => 'America/Denver','America/Detroit' => 'America/Detroit','America/Dominica' => 'America/Dominica','America/Edmonton' => 'America/Edmonton','America/Eirunepe' => 'America/Eirunepe','America/El_Salvador' => 'America/El_Salvador','America/Fort_Nelson' => 'America/Fort_Nelson','America/Fortaleza' => 'America/Fortaleza','America/Glace_Bay' => 'America/Glace_Bay','America/Godthab' => 'America/Godthab','America/Goose_Bay' => 'America/Goose_Bay','America/Grand_Turk' => 'America/Grand_Turk','America/Grenada' => 'America/Grenada','America/Guadeloupe' => 'America/Guadeloupe','America/Guatemala' => 'America/Guatemala','America/Guayaquil' => 'America/Guayaquil','America/Guyana' => 'America/Guyana','America/Halifax' => 'America/Halifax','America/Havana' => 'America/Havana','America/Hermosillo' => 'America/Hermosillo','America/Indiana/Indianapolis' => 'America/Indiana/Indianapolis','America/Indiana/Knox' => 'America/Indiana/Knox','America/Indiana/Marengo' => 'America/Indiana/Marengo','America/Indiana/Petersburg' => 'America/Indiana/Petersburg','America/Indiana/Tell_City' => 'America/Indiana/Tell_City','America/Indiana/Vevay' => 'America/Indiana/Vevay','America/Indiana/Vincennes' => 'America/Indiana/Vincennes','America/Indiana/Winamac' => 'America/Indiana/Winamac','America/Inuvik' => 'America/Inuvik','America/Iqaluit' => 'America/Iqaluit','America/Jamaica' => 'America/Jamaica','America/Juneau' => 'America/Juneau','America/Kentucky/Louisville' => 'America/Kentucky/Louisville','America/Kentucky/Monticello' => 'America/Kentucky/Monticello','America/Kralendijk' => 'America/Kralendijk','America/La_Paz' => 'America/La_Paz','America/Lima' => 'America/Lima','America/Los_Angeles' => 'America/Los_Angeles','America/Lower_Princes' => 'America/Lower_Princes','America/Maceio' => 'America/Maceio','America/Managua' => 'America/Managua','America/Manaus' => 'America/Manaus','America/Marigot' => 'America/Marigot','America/Martinique' => 'America/Martinique','America/Matamoros' => 'America/Matamoros','America/Mazatlan' => 'America/Mazatlan','America/Menominee' => 'America/Menominee','America/Merida' => 'America/Merida','America/Metlakatla' => 'America/Metlakatla','America/Mexico_City' => 'America/Mexico_City','America/Miquelon' => 'America/Miquelon','America/Moncton' => 'America/Moncton','America/Monterrey' => 'America/Monterrey','America/Montevideo' => 'America/Montevideo','America/Montserrat' => 'America/Montserrat','America/Nassau' => 'America/Nassau','America/New_York' => 'America/New_York','America/Nipigon' => 'America/Nipigon','America/Nome' => 'America/Nome','America/Noronha' => 'America/Noronha','America/North_Dakota/Beulah' => 'America/North_Dakota/Beulah','America/North_Dakota/Center' => 'America/North_Dakota/Center','America/North_Dakota/New_Salem' => 'America/North_Dakota/New_Salem','America/Ojinaga' => 'America/Ojinaga','America/Panama' => 'America/Panama','America/Pangnirtung' => 'America/Pangnirtung','America/Paramaribo' => 'America/Paramaribo','America/Phoenix' => 'America/Phoenix','America/Port-au-Prince' => 'America/Port-au-Prince','America/Port_of_Spain' => 'America/Port_of_Spain','America/Porto_Velho' => 'America/Porto_Velho','America/Puerto_Rico' => 'America/Puerto_Rico','America/Rainy_River' => 'America/Rainy_River','America/Rankin_Inlet' => 'America/Rankin_Inlet','America/Recife' => 'America/Recife','America/Regina' => 'America/Regina','America/Resolute' => 'America/Resolute','America/Rio_Branco' => 'America/Rio_Branco','America/Santarem' => 'America/Santarem','America/Santiago' => 'America/Santiago','America/Santo_Domingo' => 'America/Santo_Domingo','America/Sao_Paulo' => 'America/Sao_Paulo','America/Scoresbysund' => 'America/Scoresbysund','America/Sitka' => 'America/Sitka','America/St_Barthelemy' => 'America/St_Barthelemy','America/St_Johns' => 'America/St_Johns','America/St_Kitts' => 'America/St_Kitts','America/St_Lucia' => 'America/St_Lucia','America/St_Thomas' => 'America/St_Thomas','America/St_Vincent' => 'America/St_Vincent','America/Swift_Current' => 'America/Swift_Current','America/Tegucigalpa' => 'America/Tegucigalpa','America/Thule' => 'America/Thule','America/Thunder_Bay' => 'America/Thunder_Bay','America/Tijuana' => 'America/Tijuana','America/Toronto' => 'America/Toronto','America/Tortola' => 'America/Tortola','America/Vancouver' => 'America/Vancouver','America/Whitehorse' => 'America/Whitehorse','America/Winnipeg' => 'America/Winnipeg','America/Yakutat' => 'America/Yakutat','America/Yellowknife' => 'America/Yellowknife','Antarctica/Casey' => 'Antarctica/Casey','Antarctica/Davis' => 'Antarctica/Davis','Antarctica/DumontDUrville' => 'Antarctica/DumontDUrville','Antarctica/Macquarie' => 'Antarctica/Macquarie','Antarctica/Mawson' => 'Antarctica/Mawson','Antarctica/McMurdo' => 'Antarctica/McMurdo','Antarctica/Palmer' => 'Antarctica/Palmer','Antarctica/Rothera' => 'Antarctica/Rothera','Antarctica/Syowa' => 'Antarctica/Syowa','Antarctica/Troll' => 'Antarctica/Troll','Antarctica/Vostok' => 'Antarctica/Vostok','Arctic/Longyearbyen' => 'Arctic/Longyearbyen','Asia/Aden' => 'Asia/Aden','Asia/Almaty' => 'Asia/Almaty','Asia/Amman' => 'Asia/Amman','Asia/Anadyr' => 'Asia/Anadyr','Asia/Aqtau' => 'Asia/Aqtau','Asia/Aqtobe' => 'Asia/Aqtobe','Asia/Ashgabat' => 'Asia/Ashgabat','Asia/Atyrau' => 'Asia/Atyrau','Asia/Baghdad' => 'Asia/Baghdad','Asia/Bahrain' => 'Asia/Bahrain','Asia/Baku' => 'Asia/Baku','Asia/Bangkok' => 'Asia/Bangkok','Asia/Barnaul' => 'Asia/Barnaul','Asia/Beirut' => 'Asia/Beirut','Asia/Bishkek' => 'Asia/Bishkek','Asia/Brunei' => 'Asia/Brunei','Asia/Chita' => 'Asia/Chita','Asia/Choibalsan' => 'Asia/Choibalsan','Asia/Colombo' => 'Asia/Colombo','Asia/Damascus' => 'Asia/Damascus','Asia/Dhaka' => 'Asia/Dhaka','Asia/Dili' => 'Asia/Dili','Asia/Dubai' => 'Asia/Dubai','Asia/Dushanbe' => 'Asia/Dushanbe','Asia/Famagusta' => 'Asia/Famagusta','Asia/Gaza' => 'Asia/Gaza','Asia/Hebron' => 'Asia/Hebron','Asia/Ho_Chi_Minh' => 'Asia/Ho_Chi_Minh','Asia/Hong_Kong' => 'Asia/Hong_Kong','Asia/Hovd' => 'Asia/Hovd','Asia/Irkutsk' => 'Asia/Irkutsk','Asia/Jakarta' => 'Asia/Jakarta','Asia/Jayapura' => 'Asia/Jayapura','Asia/Jerusalem' => 'Asia/Jerusalem','Asia/Kabul' => 'Asia/Kabul','Asia/Kamchatka' => 'Asia/Kamchatka','Asia/Karachi' => 'Asia/Karachi','Asia/Kathmandu' => 'Asia/Kathmandu','Asia/Khandyga' => 'Asia/Khandyga','Asia/Kolkata' => 'Asia/Kolkata','Asia/Krasnoyarsk' => 'Asia/Krasnoyarsk','Asia/Kuala_Lumpur' => 'Asia/Kuala_Lumpur','Asia/Kuching' => 'Asia/Kuching','Asia/Kuwait' => 'Asia/Kuwait','Asia/Macau' => 'Asia/Macau','Asia/Magadan' => 'Asia/Magadan','Asia/Makassar' => 'Asia/Makassar','Asia/Manila' => 'Asia/Manila','Asia/Muscat' => 'Asia/Muscat','Asia/Nicosia' => 'Asia/Nicosia','Asia/Novokuznetsk' => 'Asia/Novokuznetsk','Asia/Novosibirsk' => 'Asia/Novosibirsk','Asia/Omsk' => 'Asia/Omsk','Asia/Oral' => 'Asia/Oral','Asia/Phnom_Penh' => 'Asia/Phnom_Penh','Asia/Pontianak' => 'Asia/Pontianak','Asia/Pyongyang' => 'Asia/Pyongyang','Asia/Qatar' => 'Asia/Qatar','Asia/Qyzylorda' => 'Asia/Qyzylorda','Asia/Riyadh' => 'Asia/Riyadh','Asia/Sakhalin' => 'Asia/Sakhalin','Asia/Samarkand' => 'Asia/Samarkand','Asia/Seoul' => 'Asia/Seoul','Asia/Shanghai' => 'Asia/Shanghai','Asia/Singapore' => 'Asia/Singapore','Asia/Srednekolymsk' => 'Asia/Srednekolymsk','Asia/Taipei' => 'Asia/Taipei','Asia/Tashkent' => 'Asia/Tashkent','Asia/Tbilisi' => 'Asia/Tbilisi','Asia/Tehran' => 'Asia/Tehran','Asia/Thimphu' => 'Asia/Thimphu','Asia/Tokyo' => 'Asia/Tokyo','Asia/Tomsk' => 'Asia/Tomsk','Asia/Ulaanbaatar' => 'Asia/Ulaanbaatar','Asia/Urumqi' => 'Asia/Urumqi','Asia/Ust-Nera' => 'Asia/Ust-Nera','Asia/Vientiane' => 'Asia/Vientiane','Asia/Vladivostok' => 'Asia/Vladivostok','Asia/Yakutsk' => 'Asia/Yakutsk','Asia/Yangon' => 'Asia/Yangon','Asia/Yekaterinburg' => 'Asia/Yekaterinburg','Asia/Yerevan' => 'Asia/Yerevan','Atlantic/Azores' => 'Atlantic/Azores','Atlantic/Bermuda' => 'Atlantic/Bermuda','Atlantic/Canary' => 'Atlantic/Canary','Atlantic/Cape_Verde' => 'Atlantic/Cape_Verde','Atlantic/Faroe' => 'Atlantic/Faroe','Atlantic/Madeira' => 'Atlantic/Madeira','Atlantic/Reykjavik' => 'Atlantic/Reykjavik','Atlantic/South_Georgia' => 'Atlantic/South_Georgia','Atlantic/St_Helena' => 'Atlantic/St_Helena','Atlantic/Stanley' => 'Atlantic/Stanley','Australia/Adelaide' => 'Australia/Adelaide','Australia/Brisbane' => 'Australia/Brisbane','Australia/Broken_Hill' => 'Australia/Broken_Hill','Australia/Currie' => 'Australia/Currie','Australia/Darwin' => 'Australia/Darwin','Australia/Eucla' => 'Australia/Eucla','Australia/Hobart' => 'Australia/Hobart','Australia/Lindeman' => 'Australia/Lindeman','Australia/Lord_Howe' => 'Australia/Lord_Howe','Australia/Melbourne' => 'Australia/Melbourne','Australia/Perth' => 'Australia/Perth','Australia/Sydney' => 'Australia/Sydney','Europe/Amsterdam' => 'Europe/Amsterdam','Europe/Andorra' => 'Europe/Andorra','Europe/Astrakhan' => 'Europe/Astrakhan','Europe/Athens' => 'Europe/Athens','Europe/Belgrade' => 'Europe/Belgrade','Europe/Berlin' => 'Europe/Berlin','Europe/Bratislava' => 'Europe/Bratislava','Europe/Brussels' => 'Europe/Brussels','Europe/Bucharest' => 'Europe/Bucharest','Europe/Budapest' => 'Europe/Budapest','Europe/Busingen' => 'Europe/Busingen','Europe/Chisinau' => 'Europe/Chisinau','Europe/Copenhagen' => 'Europe/Copenhagen','Europe/Dublin' => 'Europe/Dublin','Europe/Gibraltar' => 'Europe/Gibraltar','Europe/Guernsey' => 'Europe/Guernsey','Europe/Helsinki' => 'Europe/Helsinki','Europe/Isle_of_Man' => 'Europe/Isle_of_Man','Europe/Istanbul' => 'Europe/Istanbul','Europe/Jersey' => 'Europe/Jersey','Europe/Kaliningrad' => 'Europe/Kaliningrad','Europe/Kiev' => 'Europe/Kiev','Europe/Kirov' => 'Europe/Kirov','Europe/Lisbon' => 'Europe/Lisbon','Europe/Ljubljana' => 'Europe/Ljubljana','Europe/London' => 'Europe/London','Europe/Luxembourg' => 'Europe/Luxembourg','Europe/Madrid' => 'Europe/Madrid','Europe/Malta' => 'Europe/Malta','Europe/Mariehamn' => 'Europe/Mariehamn','Europe/Minsk' => 'Europe/Minsk','Europe/Monaco' => 'Europe/Monaco','Europe/Moscow' => 'Europe/Moscow','Europe/Oslo' => 'Europe/Oslo','Europe/Paris' => 'Europe/Paris','Europe/Podgorica' => 'Europe/Podgorica','Europe/Prague' => 'Europe/Prague','Europe/Riga' => 'Europe/Riga','Europe/Rome' => 'Europe/Rome','Europe/Samara' => 'Europe/Samara','Europe/San_Marino' => 'Europe/San_Marino','Europe/Sarajevo' => 'Europe/Sarajevo','Europe/Saratov' => 'Europe/Saratov','Europe/Simferopol' => 'Europe/Simferopol','Europe/Skopje' => 'Europe/Skopje','Europe/Sofia' => 'Europe/Sofia','Europe/Stockholm' => 'Europe/Stockholm','Europe/Tallinn' => 'Europe/Tallinn','Europe/Tirane' => 'Europe/Tirane','Europe/Ulyanovsk' => 'Europe/Ulyanovsk','Europe/Uzhgorod' => 'Europe/Uzhgorod','Europe/Vaduz' => 'Europe/Vaduz','Europe/Vatican' => 'Europe/Vatican','Europe/Vienna' => 'Europe/Vienna','Europe/Vilnius' => 'Europe/Vilnius','Europe/Volgograd' => 'Europe/Volgograd','Europe/Warsaw' => 'Europe/Warsaw','Europe/Zagreb' => 'Europe/Zagreb','Europe/Zaporozhye' => 'Europe/Zaporozhye','Europe/Zurich' => 'Europe/Zurich','Indian/Antananarivo' => 'Indian/Antananarivo','Indian/Chagos' => 'Indian/Chagos','Indian/Christmas' => 'Indian/Christmas','Indian/Cocos' => 'Indian/Cocos','Indian/Comoro' => 'Indian/Comoro','Indian/Kerguelen' => 'Indian/Kerguelen','Indian/Mahe' => 'Indian/Mahe','Indian/Maldives' => 'Indian/Maldives','Indian/Mauritius' => 'Indian/Mauritius','Indian/Mayotte' => 'Indian/Mayotte','Indian/Reunion' => 'Indian/Reunion','Pacific/Apia' => 'Pacific/Apia','Pacific/Auckland' => 'Pacific/Auckland','Pacific/Bougainville' => 'Pacific/Bougainville','Pacific/Chatham' => 'Pacific/Chatham','Pacific/Chuuk' => 'Pacific/Chuuk','Pacific/Easter' => 'Pacific/Easter','Pacific/Efate' => 'Pacific/Efate','Pacific/Enderbury' => 'Pacific/Enderbury','Pacific/Fakaofo' => 'Pacific/Fakaofo','Pacific/Fiji' => 'Pacific/Fiji','Pacific/Funafuti' => 'Pacific/Funafuti','Pacific/Galapagos' => 'Pacific/Galapagos','Pacific/Gambier' => 'Pacific/Gambier','Pacific/Guadalcanal' => 'Pacific/Guadalcanal','Pacific/Guam' => 'Pacific/Guam','Pacific/Honolulu' => 'Pacific/Honolulu','Pacific/Johnston' => 'Pacific/Johnston','Pacific/Kiritimati' => 'Pacific/Kiritimati','Pacific/Kosrae' => 'Pacific/Kosrae','Pacific/Kwajalein' => 'Pacific/Kwajalein','Pacific/Majuro' => 'Pacific/Majuro','Pacific/Marquesas' => 'Pacific/Marquesas','Pacific/Midway' => 'Pacific/Midway','Pacific/Nauru' => 'Pacific/Nauru','Pacific/Niue' => 'Pacific/Niue','Pacific/Norfolk' => 'Pacific/Norfolk','Pacific/Noumea' => 'Pacific/Noumea','Pacific/Pago_Pago' => 'Pacific/Pago_Pago','Pacific/Palau' => 'Pacific/Palau','Pacific/Pitcairn' => 'Pacific/Pitcairn','Pacific/Pohnpei' => 'Pacific/Pohnpei','Pacific/Port_Moresby' => 'Pacific/Port_Moresby','Pacific/Rarotonga' => 'Pacific/Rarotonga','Pacific/Saipan' => 'Pacific/Saipan','Pacific/Tahiti' => 'Pacific/Tahiti','Pacific/Tarawa' => 'Pacific/Tarawa','Pacific/Tongatapu' => 'Pacific/Tongatapu','Pacific/Wake' => 'Pacific/Wake','Pacific/Wallis' => 'Pacific/Wallis'
    	);


		vc_map( array(
			 "name" => esc_html__("Event Calendar", 'ovaem-events-manager'),
			 "base" => "ovaem_calendar",
			 "class" => "",
			 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
			 "icon" => "icon-qk",   
			  "params" => array(

			  	array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Filter",'ovaem-events-manager'),
			       "param_name" => "filter",
			       "value" => array(
			       		esc_html__( "All", "ovaem-events-manager")	=> "",
			       		esc_html__( "Upcoming", "ovaem-events-manager") => "upcomming",
			       		esc_html__( "Upcoming/Showing", "ovaem-events-manager") => "upcomming_showing",
			       		esc_html__( "Featured", "ovaem-events-manager")	=> "featured",
			       		esc_html__( "Past", "ovaem-events-manager")	=> "past",
			       	),
			       "default" => ""
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Category",'ovaem-events-manager'),
			       "param_name" => "cat",
			       "value" => array_flip($cats_arr),
			       "default" => ""
			       
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show past",'ovaem-events-manager'),
			       "param_name" => "show_past",
			       "value" => array(
			       		esc_html__( "True", "ovaem-events-manager") => "true",
			       		esc_html__( "False", "ovaem-events-manager")	=> "false"
			       	),
			       "default" => "true"
			    ),

			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Local",'ovaem-events-manager'),
			       "param_name" => "local",
			       "value" => $local_arr,
			       "default" => "en"
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Time Zone",'ovaem-events-manager'),
			       "param_name" => "time_zone",
			       "value" => $time_zone_arr,
			       "default" => ""
			    ),

			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("First day of week",'ovaem-events-manager'),
			       "description" => esc_html__( "Monday: 1, Tuesday: 2, Wednesday:3 , Thursday: 4, Friday: 5, Saturday: 6, Sunday: 0", 'ovaem-events-manager' ),
			       "param_name" => "first_day",
			       "value" => array(
			            '1' => esc_html__('1', 'ovaem-events-manager'),
			            '2' => esc_html__('2', 'ovaem-events-manager'),
			            '3' => esc_html__('3', 'ovaem-events-manager'),
			            '4' => esc_html__('4', 'ovaem-events-manager'),
			            '5' => esc_html__('5', 'ovaem-events-manager'),
			            '6' => esc_html__('6', 'ovaem-events-manager'),
			            '0' => esc_html__('0', 'ovaem-events-manager'),
			        ),
			       "default" => "0"
			    ),

			    
			    
			  	array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Class",'ovaem-events-manager'),
			       "param_name" => "class"
			       
			    )
			  )
			 ));

} 