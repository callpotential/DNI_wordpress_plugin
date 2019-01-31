<?php
	/*
	Plugin Name: Dynamic Number Insertion
	Plugin URL: https://github.com/codal-sjariwala/dynamic-number-insertion.git
	description: Dynamic Number Insertion Wordpress Plugin
	Version: 1.0
	Author: Sahil Jariwala
	Author URI: https://github.com/codal-sjariwala/
	License: GPL2
	*/

	if ( !function_exists( 'add_action' ) ) {
		echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
		exit;
	}

	add_action( 'init', 'dni_post_type', 0 );
	function dni_post_type() {
	 
	   $labels = array(
	    'name' => __( 'DNI', 'dni' ),
	    'singular_name' => __( 'DNI', 'dni' ),
	    'all_items' => __('All DNI Sources', 'dni'),
	    'add_new' => __('Add new DNI Source', 'dni'),
	    'add_new_item' => __('Add new DNI Source', 'dni'),
	    'edit_item' => __('Edit DNI Source', 'dni'),
	    'new_item' => __('New DNI Source', 'video'),
	    'view_item' => __('View DNI Source', 'dni'),
	    'search_items' => __('Search DNI Source', 'dni'),
	    'not_found' =>  __('No DNI Source Found', 'dni'),
	    'not_found_in_trash' => __('No DNI Sources Found in Trash', 'dni'), 
	    'parent_item_colon' => __('DNI Source Parent:', 'dni'),
	    'menu_name' => __('DNI', 'dni'),
	    );
	    $args = array(
	    'labels' => $labels,
	    'hierarchical' => true,
	    'description' => 'Register DNI Source',
	    'supports'  => array( 'title' ),
	    'public' => false,
	    'has_archive' => true,
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'menu_position' => 6,
	    'menu_icon' => 'dashicons-post-status',
	    'rewrite' => array('slug' => 'dni'),
	    'show_in_nav_menus' => false,
	    'publicly_queryable' => false,
	    'exclude_from_search' => true,
	    'query_var' => true,
	    'can_export' => true,   
	    );
	 
	    register_post_type( 'dni', $args);
	}

	add_action( 'add_meta_boxes', 'add_dni_metaboxes' );

	function add_dni_metaboxes() {
		add_meta_box(
			'dni_source',
			'Source',
			'dni_source',
			'dni',
			'normal',
			'default'
		);
		add_meta_box(
			'dni_medium',
			'Medium',
			'dni_medium',
			'dni',
			'normal',
			'default'
		);
		add_meta_box(
			'dni_search_number',
			'Search Number',
			'dni_search_number',
			'dni',
			'normal',
			'default'
		);
		add_meta_box(
			'dni_replace_number',
			'Replace Number',
			'dni_replace_number',
			'dni',
			'normal',
			'default'
		);
	}

	function dni_source() {
		global $post;
		wp_nonce_field( basename( __FILE__ ), 'dni' );
		$source = get_post_meta( $post->ID, 'source', true );
		echo '<input type="text" name="source" value="' . esc_textarea( $source )  . '" class="widefat">';
	}

	function dni_save_source_meta( $post_id, $post ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		if ( ! isset( $_POST['source'] ) || ! wp_verify_nonce( $_POST['dni'], basename(__FILE__) ) ) {
			return $post_id;
		}
		$dni_meta['source'] = esc_textarea( $_POST['source'] );
		foreach ( $dni_meta as $key => $value ) :
			if ( 'revision' === $post->post_type ) {
				return;
			}
			if ( get_post_meta( $post_id, $key, false ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				add_post_meta( $post_id, $key, $value);
			}
			if ( ! $value ) {
				delete_post_meta( $post_id, $key );
			}
		endforeach;
	}
	add_action( 'save_post', 'dni_save_source_meta', 1, 2 );

	function dni_medium() {
		global $post;
		wp_nonce_field( basename( __FILE__ ), 'dni' );
		$medium = get_post_meta( $post->ID, 'medium', true );
		echo '<input type="text" name="medium" value="' . esc_textarea( $medium )  . '" class="widefat">';
	}

	function dni_save_medium_meta( $post_id, $post ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		if ( ! isset( $_POST['medium'] ) || ! wp_verify_nonce( $_POST['dni'], basename(__FILE__) ) ) {
			return $post_id;
		}
		$dni_meta['medium'] = esc_textarea( $_POST['medium'] );
		foreach ( $dni_meta as $key => $value ) :
			if ( 'revision' === $post->post_type ) {
				return;
			}
			if ( get_post_meta( $post_id, $key, false ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				add_post_meta( $post_id, $key, $value);
			}
			if ( ! $value ) {
				delete_post_meta( $post_id, $key );
			}
		endforeach;
	}
	add_action( 'save_post', 'dni_save_medium_meta', 1, 2 );

	function dni_search_number() {
		global $post;
		wp_nonce_field( basename( __FILE__ ), 'dni' );
		$searchNumber = get_post_meta( $post->ID, 'searchNumber', true );
		echo '<input type="text" name="searchNumber" value="' . esc_textarea( $searchNumber )  . '" class="widefat">';
	}

	function dni_save_search_number_meta( $post_id, $post ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		if ( ! isset( $_POST['searchNumber'] ) || ! wp_verify_nonce( $_POST['dni'], basename(__FILE__) ) ) {
			return $post_id;
		}
		$dni_meta['searchNumber'] = esc_textarea( $_POST['searchNumber'] );
		foreach ( $dni_meta as $key => $value ) :
			if ( 'revision' === $post->post_type ) {
				return;
			}
			if ( get_post_meta( $post_id, $key, false ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				add_post_meta( $post_id, $key, $value);
			}
			if ( ! $value ) {
				delete_post_meta( $post_id, $key );
			}
		endforeach;
	}
	add_action( 'save_post', 'dni_save_search_number_meta', 1, 2 );

	function dni_replace_number() {
		global $post;
		wp_nonce_field( basename( __FILE__ ), 'dni' );
		$replaceNumber = get_post_meta( $post->ID, 'replaceNumber', true );
		echo '<input type="text" name="replaceNumber" value="' . esc_textarea( $replaceNumber )  . '" class="widefat">';
	}

	function dni_save_replace_number_meta( $post_id, $post ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		if ( ! isset( $_POST['replaceNumber'] ) || ! wp_verify_nonce( $_POST['dni'], basename(__FILE__) ) ) {
			return $post_id;
		}
		$dni_meta['replaceNumber'] = esc_textarea( $_POST['replaceNumber'] );
		foreach ( $dni_meta as $key => $value ) :
			if ( 'revision' === $post->post_type ) {
				return;
			}
			if ( get_post_meta( $post_id, $key, false ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				add_post_meta( $post_id, $key, $value);
			}
			if ( ! $value ) {
				delete_post_meta( $post_id, $key );
			}
		endforeach;
	}
	add_action( 'save_post', 'dni_save_replace_number_meta', 1, 2 );

	function add_dni_columns($columns) {
	    return array_merge($columns,
	              array('dni_source' => __('Source'),
	                    'dni_medium' =>__('Medium'),
	                	'dni_search_number' => __('Search Number'),
	                	'dni_replace_number' => __('Replace Number')));
	}
	add_filter('manage_dni_posts_columns' , 'add_dni_columns');

	function custom_dni_column( $column, $post_id ) {
	    switch ( $column ) {
	      case 'dni_source':
	        echo get_post_meta( $post_id , 'source' , true );
	        break;
	      case 'dni_medium':
	        echo get_post_meta( $post_id , 'medium' , true );
	        break;
	      case 'dni_search_number':
	        echo get_post_meta( $post_id , 'searchNumber' , true );
	        break;
	      case 'dni_replace_number':
	        echo get_post_meta( $post_id , 'replaceNumber' , true );
	        break;
	    }
	}
	add_action( 'manage_dni_posts_custom_column' , 'custom_dni_column', 10, 2);

	function register_sortable_columns( $columns ) {
		$sortable_columns[ 'title' ] = 'title';
		$sortable_columns[ 'date' ] = 'date';
	    $sortable_columns[ 'dni_source' ] = 'dni_source';
	    $sortable_columns[ 'dni_medium' ] = 'dni_medium';
	    $sortable_columns[ 'dni_search_number' ] = 'dni_search_number';
	    $sortable_columns[ 'dni_replace_number' ] = 'dni_replace_number';
	    return $sortable_columns;
	}
	add_filter( 'manage_edit-dni_sortable_columns', 'register_sortable_columns' );

	function get_DNI_data(){

		$getDNIArgs = array('post_type' => 'dni','posts_per_page'=>'-1');
		$getDNI_query = new WP_Query($getDNIArgs);

		echo "<script type=\"text/javascript\">";
		echo "var dniData = {\"dniDictionary\": [";
		while($getDNI_query->have_posts()) : $getDNI_query->the_post();
			if ($getDNI_query->current_post +1 == $getDNI_query->post_count) {
			    echo "{
			    	utm_source: \"".get_post_meta( get_the_ID(), 'source', true )."\",
			    	utm_medium: \"".get_post_meta( get_the_ID(), 'medium', true )."\",
			    	searchNumber: \"".get_post_meta( get_the_ID(), 'searchNumber', true )."\",
			    	replaceNumber: \"".get_post_meta( get_the_ID(), 'replaceNumber', true )."\"
			    }";
			}else{
				echo "{
					utm_source: \"".get_post_meta( get_the_ID(), 'source', true )."\",
					utm_medium: \"".get_post_meta( get_the_ID(), 'medium', true )."\",
					searchNumber: \"".get_post_meta( get_the_ID(), 'searchNumber', true )."\",
					replaceNumber: \"".get_post_meta( get_the_ID(), 'replaceNumber', true )."\"
				},";
			}
		endwhile;
		echo "]};";
		echo "</script>";
		wp_reset_postdata();
	}
	
	add_action('wp_head', 'get_DNI_data');


	function dni_js(){
		echo "
		<script type=\"text/javascript\">
			function getParameterByName(name, url) {
			    if (!url) url = window.location.href;
			    name = name.replace(/[\[\]]/g, \"\\$&\");
			    var regex = new RegExp(\"[?&]\" + name + \"(=([^&#]*)|&|#|$)\"),
			        results = regex.exec(url);
			    if (!results) return null;
			    if (!results[2]) return '';
			    return decodeURIComponent(results[2].replace(/\+/g, \" \"));
			}
			var gclid = getParameterByName(\"gclid\", window.location.href);
			if(gclid) {
				var utmSource = 'google';
				var utmMedium = 'adwords';
			} else {
				var utmSource = getParameterByName(\"utm_source\", window.location.href);
				var utmMedium = getParameterByName(\"utm_medium\", window.location.href);
			}
			var referralURL = document.referrer;
			if(referralURL.includes(\"google\")){
			    createCookie('referral-source','google');
				if (utmMedium === \"\" || utmMedium === null) {
					utmMedium = 'organic';
					createCookie('utm-medium',utmMedium);
				}
			    createCookie('utm-medium',utmMedium);
			}else if(referralURL.includes(\"facebook\")){
			    createCookie('referral-source','facebook');
			}else if(referralURL.includes(\"yelp\")){
			    createCookie('referral-source','yelp');
			}
			var referralSource = getCookie('referral-source');
			if(utmSource === \"\" || utmSource === null){
			    utmSource = referralSource;
			    if(referralSource === \"google\"){
					utmMedium = getCookie('utm-medium');
			    } else if(referralSource === \"facebook\"){
			        utmMedium = \"social\";
			    } else if(referralSource === \"yelp\"){
			        utmMedium = \"local\";
			    }
			}
			try{

				// check if the incoming traffic is from referral and if data exists in DNI
				if(utmSource !== null && utmMedium !== null && dniData.dniDictionary.length){ 

					// run the dniDictionary

					for(var i = 0; i < dniData.dniDictionary.length; i++){
					    if(dniData.dniDictionary[i].utm_source.toLowerCase() === utmSource.toLowerCase() && dniData.dniDictionary[i].utm_medium.toLowerCase() === utmMedium.toLowerCase()){


					    	// check if phone number exists regardless for pattern

					        var dniPattern = /(\d{3}[-\.\s]??\d{3}[-\.\s]??\d{4}|\(\d{3}\)\s*\d{3}[-\.\s]??\d{4}|\d{3}[-\.\s]??\d{4})/gm;

					        var match, results=[];
					        do {
					            match = dniPattern.exec(document.body.innerHTML);
					            if (match) {
					                results.push(match[1]);
					            }
					        } while (match);

					        // if number exists then verify the document.body number with the search number in dictionary 

					        if(results.length){

					        	for(var j = 0; j < results.length; j++){

					        		// unmask the number from document.body and DNI's search number

					        		var numberInContent = results[j].replace(/\D+/g,'');
					        		var unmaskedSearchNumber = dniData.dniDictionary[i].searchNumber.replace(/\D+/g,'');

					        		// if number matches with search number then replace the number

					        		if(numberInContent === unmaskedSearchNumber){

					        			// unmask DNI replace number and add xxx xxx xxxx masking

					        			var dniReplaceNumber = dniData.dniDictionary[i].replaceNumber.replace(/[^\d]+/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
					        			document.body.innerHTML = document.body.innerHTML.split(results[j]).join(dniReplaceNumber);
					        		}
					        	}
					        }
					    }
					}
				}
			} catch(error){
				console.log(\"An Error occured: \", error);
			}
			function getCookie(cookie_name) {
			    var name = cookie_name + \"=\";
			    var decodedCookie = decodeURIComponent(document.cookie);
			    var cookies = decodedCookie.split(';');
			    for(var i = 0; i < cookies.length; i++) {
			        var cookie_param = cookies[i];
			        while (cookie_param.charAt(0) == ' ') {
			           cookie_param = cookie_param.substring(1);
			        }
			        if (cookie_param.indexOf(name) == 0) {
			            return cookie_param.substring(name.length, cookie_param.length);
			        }
			    }
			    return '';
			}
			function createCookie(name,value,minutes=30) { //Default cookie expired time
			    var date = new Date();
			    date.setTime(date.getTime()+(minutes * 60 * 1000));
			    var expires = '; expires='+date.toGMTString();
			    document.cookie = name+'='+value+expires;
			}
		</script>";
	}

	add_action('wp_footer', 'dni_js');
?>
