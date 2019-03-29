<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Products extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(["ion_auth", "form_validation"]);
		$this->load->helper(["url"]);
		$this->load->model( "product_model" );
	}
	
	public $audience = [
		"Christian",
		"Muslim",
		"Buddhist",
		"Hindu",
		"Sikh",
		"Animist",
		"Secular",
	];
	
	public $product_types = [
		"book",
		"magabook",
		"booklet",
		"tract",
	];
	
	public $product_binding = [
		"Hardcover",
		"Perfect Bound",
		"Spiral Bound",
		"Saddle Stitch",
	];
	
	public $breadcrumbs = [
		[
			"label" => "Products",
			"url" => "/products",
		],
	];
	
	public function index( $product_id = null )
	{
		$data = [
			"products" => $this->product_model->getProducts(),
			"audience_options" => $this->audience,
			"product_types" => $this->product_types,
			"product_binding" => $this->product_binding,
		];
		$this->template->set( "title", "Products" );
		$this->breadcrumbs[] = [ "label" => "All Products"  ];
		$this->template->set( "breadcrumbs", $this->breadcrumbs );
		$this->template->load( "template", "products", $data );
	}
	
	public function detail( $product_id ) {
		$this->load->model( "project_model" );
		$product = $this->product_model->getProduct( $product_id );
		if( ! $product ) show_404();
		$attachments = $this->product_model->getAttachments( $product_id );
		$languages = [];
		foreach( $attachments as $attachment ) {
			$languages[$attachment["language_id"]]["language_name"] = $attachment["name"];
			$languages[$attachment["language_id"]]["attachments"][] = $attachment;
		}
		$projects = $this->project_model->getProjectsByProductId( $product_id );
		foreach( $projects as $project ) {
			if( ! array_key_exists( $project["language_id"], $languages ) ) {
				$languages[$project["language_id"]]["language_name"] = $project["language_name"];
				$languages[$project["language_id"]]["project"] = $project;
			}
		}
		$data = [
			"product" => $product,
			"languages" => $languages,
			"file_types" => $this->product_model->file_types,
		];
		$this->template->set( "title", $product["name"] );
		$this->breadcrumbs[] = [ "label" => $product["name"]  ];
		$this->template->set( "breadcrumbs", $this->breadcrumbs );
		$this->template->load( "template", "product", $data );
	}
	
	public function edit( $product_id ) {
		$product = $this->product_model->getProduct( $product_id );
		if( ! $product ) show_404();
		
		$data = [
			"product" => $product,
			"audience_options" => $this->audience,
			"product_types" => $this->product_types,
			"product_binding" => $this->product_binding,
		];
		$this->template->set( "title", "Edit Product" );
		$this->breadcrumbs[] = [
			"label" => $product["name"],
			"url" => "/products/" . $product["id"],
		];
		$this->breadcrumbs[] = [
			"label" => "Edit",
		];
		$this->template->set( "breadcrumbs", $this->breadcrumbs );
		$this->template->load( "template", "edit_product", $data );
	}
	
	public function save() {
		if( ! $this->ion_auth->is_admin() ) {
			show_404();
		}
		
		$this->output->set_content_type("application/json");
		
		$this->form_validation->set_rules( "name", "Title", "required" );
		$this->form_validation->set_rules( "audience", "Audience", "required" );
		$this->form_validation->set_rules( "page_count", "Page count", "required|numeric" );
		$this->form_validation->set_rules( "type", "Product type", "required" );
		
		if( $this->form_validation->run() === false ) {
			$this->output->set_output( json_encode( [ "error" => validation_errors() ] ) );
			return false;
		}
		$data = $this->input->post();
		
		$is_new = ! array_key_exists( "id", $data );
		
		if( ( array_key_exists( "id", $data ) && $_FILES["cover_image"]["name"] ) || $is_new ) {
			$cover_image = $this->_uploadCoverImage();
			if( ! $cover_image ) {
				$this->output->set_output( json_encode( [ "error" => "Error uploading cover image" ] ) );
				return false;
			}
			$data["cover_image"] = $cover_image["file_name"];
		}
		
		if( $is_new ) {
			/*$xliff_file = $this->_uploadXliff();
			if( ! $xliff_file ) {
				$this->output->set_output( json_encode( [ "error" => "Error uploading translation file" ] ) );
				return false;
			}*/
			//$data["xliff_file"] = $xliff_file["file_name"];
		}
		
		if( $is_new ) {
			$this->db->insert( "products", $data );
			$id = $this->db->insert_id();
			$this->output->set_output( json_encode( [ "redirect" => "/products/$id" ] ) );
		} else {
			$this->db->where( "id", $data["id"] );
			$this->db->update( "products", $data );
			if( $_FILES["cover_image"]["name"] ) {
				$this->output->set_output( json_encode( [ "redirect" => "/products/edit/" . $data["id"] ] ) );
			} else {
				$this->output->set_output( json_encode( [ "success" => "Product info updated" ] ) );
			}
		}
	}
	
	public function save_specs() {
		if( ! $this->ion_auth->is_admin() ) {
			show_404();
		}
		
		$this->output->set_content_type("application/json");
		$data = $this->input->post();
		$this->db->where( "id", $data["id"] );
		$this->db->update( "products", $data );
		$this->output->set_output( json_encode( [ "success" => "Product info updated" ] ) );
	}
	
	public function add_file() {
		if( ! $this->ion_auth->is_admin() ) {
			show_404();
		}
		
		$this->output->set_content_type("application/json");
		
		$this->form_validation->set_rules( "language_id", "Language", "required" );
		$this->form_validation->set_rules( "product_id", "Product ID", "required" );
		$this->form_validation->set_rules( "file_type", "File type", "required" );
		
		if( $this->form_validation->run() === false ) {
			$this->output->set_output( json_encode( [ "error" => validation_errors() ] ) );
			return false;
		}
		$data = $this->input->post();
		
		$attachment = $this->_uploadAttachment();
		if( ! $attachment ) {
			$this->output->set_output( json_encode( [ "error" => "Error uploading file" ] ) );
			return false;
		}
		
		$data["file"] = $attachment["file_name"];
		
		$this->db->insert( "product_attachments", $data );
		$id = $this->db->insert_id();
		$this->output->set_output( json_encode( [ "redirect" => "/products/" . $data["product_id"] ] ) );
	}
	
	private function _uploadCoverImage() {
		$config["upload_path"] = $_SERVER["DOCUMENT_ROOT"] . "/uploads";
		$config["allowed_types"] = "jpg|png";
		$config["max_size"] = 10000;
		$config["encrypt_name"] = true;

		$this->load->library( "upload", $config );

		if ( ! $this->upload->do_upload( "cover_image" ) ) {
			return false;
		}
		$image = $this->upload->data();
		$source_path = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $image["file_name"];
		$target_path = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
		
		$config_manip = [
			"image_library" => "gd2",
			"source_image" => $source_path,
			"maintain_ratio" => true,
			"width" => 768,
			"height" => 768,
			"quality" => "70%",
		];

		$this->load->library( "image_lib", $config_manip );
		if( ! $this->image_lib->resize() ) {
			return false;
		}

		$this->image_lib->clear();
		return $this->upload->data();
	}
	
	private function _uploadXliff() {
		$config["upload_path"] = $_SERVER["DOCUMENT_ROOT"] . "/uploads";
		$config["allowed_types"] = "xml";
		$config["max_size"] = 50000;
		$config["encrypt_name"] = true;

		$this->load->library( "upload", $config );

		if ( ! $this->upload->do_upload( "xliff_file" ) ) {
			return false;
		}
		
		$file = $this->upload->data();
		return $this->upload->data();
	}
	
	private function _uploadAttachment() {
		$config["upload_path"] = $_SERVER["DOCUMENT_ROOT"] . "/uploads";
		$config["allowed_types"] = "pdf";
		$config["max_size"] = 50000;
		$config["encrypt_name"] = true;

		$this->load->library( "upload", $config );

		if ( ! $this->upload->do_upload( "file" ) ) {
			return false;
		}
		
		$file = $this->upload->data();
		return $this->upload->data();
	}
}