<?php
 class Espacionombres{

		
		
		public $xmlnsRetention = "urn:sunat:names:specification:ubl:peru:schema:xsd:Retention-1";
        public $xmlnsInvoice = "urn:oasis:names:specification:ubl:schema:xsd:Invoice-2";
        public $xmlnsCreditNote = "urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2";
        public $xmlnsDebitNote = "urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2";
        public $xmlnsVoidedDocuments = "urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1";
        public $xmlnsSummaryDocuments = "urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1";
        public $sac = "urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1";
        public $cac = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";                    
        public $cbc = "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2";
        public $udt = "urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2";
        public $ccts = "urn:un:unece:uncefact:documentation:2";
        public $ext = "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2";
        public $qdt = "urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2";
        public $ds = "http://www.w3.org/2000/09/xmldsig#";
        public $xsi = "http://www.w3.org/2001/XMLSchema-instance";
        public $ar = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
        public $wssecurity =
            "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

        public $nodoId = "/ar:ApplicationResponse/cbc:ID";
        public $nodoResponseDate = "/ar:ApplicationResponse/cbc:ResponseDate";
        public $nodoResponseTime = "ar:ApplicationResponse/cbc:ResponseTime";
        public $nodoResponseCode =
            "/ar:ApplicationResponse/cac:DocumentResponse/cac:Response/cbc:ResponseCode";
        public $nodoDescription =
            "/ar:ApplicationResponse/cac:DocumentResponse/cac:Response/cbc:Description";
	}
 ?>   