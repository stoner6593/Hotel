 <?php
    include("Espacionombres.php");

    class General extends Espacionombres{

       

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