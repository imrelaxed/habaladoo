<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('application_settings', function(Blueprint $table)
		{
			$table->increments('id');

			// General Settings
			$table->string('name');
			$table->string('mailing_list_id');

			// Company Details
			$table->string('customer_support_email');
			$table->string('company_address');

			// Service API Keys
			$table->string('service_stripe_api_key_publishable');
			$table->string('service_google_analytics_api_key');
			$table->string('service_google_site_verification_key');
			$table->string('service_heap_analytics_api_key');
			$table->string('service_olark_api_key');
			$table->string('service_bugsnag_api_key');
			$table->string('service_keen_io_project_id');
			$table->string('service_keen_io_read_key');

			// Social Media Connections
			$table->string('social_facebook_app_id');
			$table->string('social_twitter_app_id');
			$table->string('social_twitter_handle');
			$table->string('social_google_plus_id');
			$table->string('social_google_play_app_id');

			// Payment Widget Details
			$table->string('payment_widget_company_name');
			$table->string('payment_widget_description');
			$table->string('payment_widget_plan_price');
			$table->string('payment_widget_button_text');
			$table->string('payment_widget_purchase_button_text');
			
			// Legal Mumbo Jumbo
			$table->text('legal_terms_of_use');
			$table->text('legal_privacy_policy');

			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('application_settings');
	}

}
