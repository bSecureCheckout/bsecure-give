<?php
/**
 * The file that contains bsecure api features.
 *
 * @link       https://www.bsecure.pk
 * @since      1.4.9
 *
 * @package    Bsecure_Give
 * @subpackage Bsecure_Give/includes
 */
/**
 * The core plugin class.
 *
 * bsecure checkout features
 *
 * @since      1.0.0
 * @package    Bsecure_Give
 * @subpackage Bsecure_Give/includes
 * @author     bSecure <info@bsecure.pk>
 */

class Bsecure_Give_Admin extends Bsecure_Give {	

	const GIVE_BSECURE_PLUGIN_STATUS_NEW = 1;

    const GIVE_BSECURE_PLUGIN_STATUS_DISBALED = 3;

	public function __construct(){	             

        add_action( 'wp_ajax_give_bsecure_deactivation_popup', array($this, 'give_bsecure_deactivation_popup'));
        add_action( 'wp_ajax_nopriv_give_bsecure_deactivation_form_submit', array($this, 'give_bsecure_deactivation_form_submit' ));
		add_action( 'wp_ajax_give_bsecure_deactivation_form_submit', array($this, 'give_bsecure_deactivation_form_submit'));
		add_action( 'wp_loaded',  array($this, 'loadThickBox')); 

	}

	/**
	 * Renders the Give bSecure Deactivation Survey Form.
	 * Note: only for internal use
	 *
	 * @since 2.2
	*/
	public function give_bsecure_deactivation_popup() {
		// Bailout.
		if ( ! current_user_can( 'delete_plugins' ) ) {
			wp_die();
		}

		$results = array();

		// Start output buffering.
		ob_start();
		?>

		<div class="wrapper-deactivation-survey">
			<form class="bsecure-deactivation-survey-form" method="POST">
				
				<p class="generalMainText"><?php esc_html_e( 'If you have a moment, please let us know why you are deactivating Give bSecure. All submissions are anonymous and we only use this feedback to improve this plugin.', 'bsecure-give' ); ?></p>

				<div class="bSecureoptionsBoxes">
					<label class="bsecure-field-description">
						<input type="radio" name="give_bsecure-survey-radios" value="1">
						<?php esc_html_e( "I no longer need the plugin", 'bsecure-give' ); ?>
					</label>
				</div>		

				<div class="bSecureoptionsBoxes">
					<label class="bsecure-field-description">
						<input type="radio" name="give_bsecure-survey-radios" value="2" data-has-field="true">
						<?php esc_html_e( 'I found a better plugin', 'bsecure-give' ); ?>
					</label>

					<div class="bsecure-survey-extra-field reason-box2 hidden">
						<p>
						<?php
							printf(
								'%1$s',
								
								__( 'Can you provide the name of plugin?', 'bsecure-give' )
							);
						?>
						</p>
						<textarea disabled name="user-reason" class="widefat" rows="4" ></textarea>
					</div>
					
				</div>

				<div class="bSecureoptionsBoxes">
					<label class="bsecure-field-description">
						<input type="radio" name="give_bsecure-survey-radios" value="3" data-has-field="true">
						<?php esc_html_e( 'I couldn\'t get the plugin to work', 'bsecure-give' ); ?>
						
						
					</label>	
					<div class="bsecure-survey-extra-field reason-box3 hidden">
						<p>
						<?php
							printf(
								'%1$s %2$s %3$s',
								__( "We're sorry to hear that, check", 'bsecure-give' ),
								'<a href="https://wordpress.org/support/plugin/give-bsecure">Give bSecure Support</a>.',
								__( 'Can you describe the issue?', 'bsecure-give' )
							);
						?>
						</p>
						<textarea disabled name="user-reason" class="widefat" rows="4"></textarea>
					</div>			
				</div>

				<div class="bSecureoptionsBoxes">
					<label class="bsecure-field-description">
						<input type="radio" name="give_bsecure-survey-radios" value="4">
						<?php esc_html_e( 'It\'s a temporary deactivation', 'bsecure-give' ); ?>
					</label>
				</div>

				<div class="bSecureoptionsBoxes">
					<label class="bsecure-field-description">
						<input type="radio" name="give_bsecure-survey-radios" value="5" data-has-field="true">
						<?php esc_html_e( 'The plugin broke my site', 'bsecure-give' ); ?>
					</label>

					<div class="bsecure-survey-extra-field reason-box5 hidden">
						<p>
						<?php
							printf(
								'%1$s %2$s %3$s',
								__( "We're sorry to hear that, check", 'bsecure-give' ),
								'<a href="https://wordpress.org/support/plugin/give-bsecure">bSecure Support</a>.',
								__( 'Can you describe the issue?', 'bsecure-give' )
							);
						?>
						</p>
						<textarea disabled name="user-reason" class="widefat" rows="4"></textarea>
					</div>
				</div>

				<div class="bSecureoptionsBoxes">
					<label class="bsecure-field-description">
						<input type="radio" name="give_bsecure-survey-radios" value="6" data-has-field="true">
						<?php esc_html_e( 'The plugin suddenly stopped working', 'bsecure-give' ); ?>
					</label>

					<div class="bsecure-survey-extra-field reason-box6 hidden">
						<p>
						<?php
							printf(
								'%1$s %2$s %3$s',
								__( "We're sorry to hear that, check", 'bsecure-give' ),
								'<a href="https://wordpress.org/support/plugin/give-bsecure">bSecure Support</a>.',
								__( 'Can you describe the issue?', 'bsecure-give' )
							);
						?>
						</p>
						<textarea disabled name="user-reason" class="widefat" rows="4"></textarea>
					</div>
				</div>

				<div class="bSecureoptionsBoxes">
					<label class="bsecure-field-description">
						<input type="radio" name="give_bsecure-survey-radios" value="7" data-has-field="true">
						<?php esc_html_e( 'Other', 'bsecure-give' ); ?>
					</label>

					<div class="bsecure-survey-extra-field reason-box7 hidden">
						<p><?php esc_html_e( "Please describe why you're deactivating Give bSecure", 'bsecure-give' ); ?></p>
						<textarea disabled name="user-reason" class="widefat" rows="4"></textarea>
					</div>
				</div>

				
				<?php
					$current_user       = wp_get_current_user();
					$current_user_email = $current_user->user_email;
					$current_user_name = $current_user->display_name;
				?>
				<input type="hidden" name="current-user-email" value="<?php echo sanitize_email($current_user_email); ?>">
				<input type="hidden" name="current-user-name" value="<?php echo sanitize_text_field($current_user_name); ?>">
				<input type="hidden" name="current-site-url" value="<?php echo esc_url( get_bloginfo( 'url' ) ); ?>">
				
				<input type="hidden" name="action" value="give_bsecure_deactivation_form_submit">
							
				<?php wp_nonce_field( 'give_bsecure_ajax_export', 'give_bsecure_ajax_export' ); ?>

				<div class="bsecure-modal__controls">

					
					<a class="bsecure-skip-deactivate-survey" href="#deactivation-link-show"><?php echo __('Skip and Deactivate'); ?></a>

					<div class="bSecureRightSideBtns">
						<button class="button button-primary bsecure-popup-close-button" type="button" onclick="jQuery('#TB_closeWindowButton').trigger('click');">
							<?php echo __('Cancel'); ?>
						</button>

						<button class="button button-primary bsecure-popup-form-submit-button">

							<?php echo __('Submit and Deactivate'); ?>
						</button>
					</div>
					<div class="spinner"></div>
				</div>
				<div class="mainAjaxBox"><p class="ajax-msg"></p></div>
			</form>
		</div>
		<?php

		// Echo content (deactivation form) from the output buffer.
		$output = ob_get_clean();

		$results['html'] = $output;

		wp_send_json( $results );
	}


	/**
	 * Ajax callback after the deactivation survey form has been submitted.
	 * Note: only for internal use
	 *
	 * @since 1.4.9
	 */
	public function give_bsecure_deactivation_form_submit() {		

		if ( ! check_ajax_referer( 'give_bsecure_ajax_export', 'give_bsecure_ajax_export', false ) ) {
			wp_send_json_error();
		}
		$give_options = give_get_settings();

		$reasons = [
				'1' => __( "I no longer need the plugin", 'bsecure-give' ),
				'2' => __( "I found a better plugin", 'bsecure-give' ),
				'3' => __( "I couldn't get the plugin to work", 'bsecure-give' ),
				'4' => __( "It's a temporary deactivation", 'bsecure-give' ),
				'5' => __( "The plugin broke my site", 'bsecure-give' ),
				'6' => __( "The plugin suddenly stopped working", 'bsecure-give' ),
				'7' => __( "Other", 'bsecure-give' ),
				];

		

		$form_data = ( wp_parse_args( $_POST ) );
		
		// Get the selected radio value.
		$reason = isset( $form_data['give_bsecure-survey-radios'] ) ? sanitize_text_field($form_data['give_bsecure-survey-radios']) : 0;

		// Get the reason if any radio button has an optional text field.
		$reason_message = isset( $form_data['give_user-reason'] ) ? sanitize_text_field($form_data['user-reason']) : '';

		// Get the email of the user who deactivated the plugin.
		$user_email = isset( $form_data['current-user-email'] ) ? sanitize_text_field($form_data['current-user-email']) : '';

		// Get the name of the user who deactivated the plugin.
		$user_name = isset( $form_data['current-user-name'] ) ? sanitize_text_field($form_data['current-user-name']) : '';

		// Get the URL of the website on which bSecure plugin is being deactivated.
		$site_url = isset( $form_data['current-site-url'] ) ? sanitize_text_field($form_data['current-site-url']) : '';

		if(empty($reason)){

			wp_send_json_error(	__('Please select one of the option from list! ', 'bsecure-give'));
		}

		$request_data = [
				
				'store_id' => $give_options['bsecure_store_id'],
				'status' => Bsecure_Admin::GIVE_BSECURE_PLUGIN_STATUS_DISBALED,
				'reason' => $reasons[$reason],
				'description' => $reason_message,
				'user_name' => $user_name,
				'user_email' => $user_email,
			];


		$response = $this->bsecureGetOauthToken();	
			
		$validateResponse = $this->validateResponse($response,'token_request');

		if( $validateResponse['error'] ){		
			
			wp_send_json_error(	__('Response Error: ', 'bsecure-give').$validateResponse['msg']);		

		} else {

			// Get Order //
			$access_token =  $response->access_token;

			//$headers =	'Authorization: Bearer '.$access_token;			
			$headers =  $this->getApiHeaders($access_token);				   			

			$params = 	[
							'method' => 'POST',
							'body' => $request_data,
							'headers' => $headers,					

						];	

			//$config = $this->getBsecureConfig();  	        
	    	$survey_endpoint = $give_options['bsecure_base_url'] . '/plugin/status';

			$response = $this->bsecureSendCurlRequest( $survey_endpoint, $params);			

			$validateResponse = $this->validateResponse($response);	

			if($validateResponse['error']){			
				
				wp_send_json_error(	__('Response Error: ', 'bsecure-give').$validateResponse['msg']);			

			}else{

				if (!empty($response->body)) {

					update_option("give_bsecure_activated", 0);
					wp_send_json_success(
						$response->body
					);
				} else {

					wp_send_json_error(	 __("No response from bSecure server",'bsecure-give') );

				}			
				
			}
		}
		
	}

	/**
	* Load thickbox popup for bSecure plugin decativation servey
	*
	* @since 1.4.9
	*/
	public function loadThickBox(){

		add_thickbox();
	}


	/**
	* Send plugin activation status to bSecure server
	*
	* @since 1.4.9
	*/
	public function plugin_activate_deactivate($type = 'activate'){

		$give_options = give_get_settings();

		$current_user       = wp_get_current_user();
		$current_user_email = $current_user->user_email;
		$current_user_name = $current_user->display_name;
		$bsecure_store_id = $give_options['bsecure_store_id'];


		// check if store id not saved
		if(empty($bsecure_store_id)){

			return false;
		}

		$status = Bsecure_Admin::GIVE_BSECURE_PLUGIN_STATUS_NEW;
		$descriptions = __('Plugin activated');
		$isActivate = 1;

		if(($type == 'deactivate')){

			$status =  Bsecure_Admin::GIVE_BSECURE_PLUGIN_STATUS_DISBALED;
			$descriptions = __('Plugin deactivated and survey skipped');
			$isActivate = 0;
		}
		
		

	   	$request_data = [
				
				'store_id' => $bsecure_store_id,
				'status' => $status,
				'reason' => $descriptions,
				'description' => $descriptions,
				'user_name' => $current_user_name,
				'user_email' => $current_user_email,
			];


		$response = $this->bsecureGetOauthToken();	
			
		$validateResponse = $this->validateResponse($response,'token_request');

		if( $validateResponse['error'] ){		
			
			//error_log(	__('Response Error: ', 'bsecure-give').$validateResponse['msg']);
			return false;		

		} else {

			// Get Order //
			$access_token =  $response->access_token;

			//$headers =	'Authorization: Bearer '.$access_token;	
			$headers =   $this->getApiHeaders($access_token);						   			

			$params = 	[
							'method' => 'POST',
							'body' => $request_data,
							'headers' => $headers,					

						];	
			
			$config = $this->getBsecureConfig();
	    	$survey_endpoint = !empty($config->pluginStatus) ? $config->pluginStatus :
                              $give_options['bsecure_base_url'] . '/plugin/status';

			$response = $this->bsecureSendCurlRequest( $survey_endpoint, $params);			

			$validateResponse = $this->validateResponse($response);	

			if($validateResponse['error']){			
				
				//error_log(	__('Response Error: ', 'bsecure-give').$validateResponse['msg']);	
				return false;		

			}else{

				update_option('give_bsecure_activated', $isActivate);				

				if (!empty($response->body)) {

					//error_log(json_encode([$response->body]));
					return true;

				} else {

					//error_log(__("No response from bSecure server",'bsecure-give') );
					return false;

				}			
				
			}
		}
	}

}

