<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public $breadcrumbs = [
		[
			"label" => "Home",
			"url" => "/",
		],
	];
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library( "ion_auth" );
		$this->load->model( "product_model" );
	}
	
	public function index()
	{
		$this->template->set( "title", "Certified Adventist Resources, Culturally Relevant" );
		$this->template->set( "is_home", true );
		$this->template->load( "template", "home" );
	}
	
	public function feedback()
	{
		$this->breadcrumbs[] = [ "label" => "Feedback" ];
		$this->template->set( "breadcrumbs", $this->breadcrumbs );
		$this->template->set( "title", "Feedback" );
		$this->template->load( "template", "feedback" );
	}
	
	public function send_feedback()
	{
		$this->output->set_content_type("application/json");
		$name = $this->input->post( "name" );
		$email = $this->input->post( "email" );
		$message = $this->input->post( "message" );
		$referer = $this->input->post( "referer" );
		$user_id = $this->input->post( "user_id" );
		$user_agent = $_SERVER["HTTP_USER_AGENT"] ?? "";
		$ip = $_SERVER["REMOTE_ADDR"] ?? "";
		
		$message = <<<EOT
			<b>Name</b>: {$name}<br/>
			<b>Email</b>: {$email}<br/>
			<b>Message</b>: {$message}<br/><br/>
			<b>User ID</b>: {$user_id}<br/>
			<b>User agent</b>: {$user_agent}<br/>
			<b>Referal page</b>: {$referer}<br/>
			<b>IP address</b>: {$ip}<br/>
EOT;
		
		$this->email->from( "info@adventistcommons.org", "Adventist Commons" );
		$this->email->to( "info@adventistcommons.org" );
		$this->email->subject( sprintf( "Adventist Commons feedback from %s", $name ) );
		$this->email->message( $message );
		$this->email->send();
		$this->output->set_output( json_encode( [ "success" => "Thanks! Feedback has been sent.", "redirect" => "/", "redirect_delay" => 2000 ] ) );
	}
}
