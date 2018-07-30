 <?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class General extends Espacionombres{

		function __construct(){
       		//parent::__construct();
    	}

    	public $UblVersionId="2.0";
    	public $CustomizationId="1.0";
    	public $Id;
    	public $IssueDate;
    

    	public function setId($Id){
    		$this->Id=$Id;
    	}
    	public function setIssueDate($IssueDate){
    		$this->IssueDate=$IssueDate;
    	}
    	public function getId(){
    		return $this->Id;
    	}
    	public function getIssueDate(){
    		return $this->IssueDate;
    	}
	}
?>