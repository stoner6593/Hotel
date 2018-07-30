<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentoelectronico extends General
{
	public function __construct()
	{
		//parent::__construct();
		//$this->CI = get_instance(); //servirá para acceder a clases de CI
		 
	} 

	public $InvoiceTypeCode;//="01"; //Factura =01
	public $DocumentCurrencyCode;//Tipo de moneda
	public $IdentificationCode="PE"; //Código de pais
	private $Encabezado = array();
	private $InvoiceLine=array();
	private $Discrepancia=array();
	private $DocRelacionado=array();




	private $CI;
	//private $TipoDocumento;
	private $RUCEmisor;
    private $IdDocumento;
    private $FechaEmision;
    private $Moneda;
    private $Gravadas;
    private $Gratuitas;
    private $Inafectas;
    private $Exoneradas;

    private $DescuentoGlobal;

    private $TotalVenta;
    private $TotalIgv;
    private $TotalIsc;
    private $TotalOtrosTributos;

    private $MontoEnLetras;
    private $TipoOperacion;
    private $PlacaVehiculo;

    private $CalculoIgv;
    private $CalculoIsc;
    private $CalculoDetraccion;

    private $MontoPercepcion;
    private $MontoDetraccion;

    private $TipoDocAnticipo;
    private $DocAnticipo;
    private $MonedaAnticipo;
    private $MontoAnticipo;

    private $SunatTransaction;


 	

	//GETTER
	public function getDocRelacionado(){
	 	return $this->DocRelacionado;
	}
	public function getDiscrepancia(){
	 	return $this->Discrepancia;
	}

	 public function getSunatTransaction(){
	 	return $this->SunatTransaction;
	}
    public function getRUCEmisor(){
	 	return $this->RUCEmisor;
	}

	public function getEncabezado(){
	 	return $this->Encabezado;
	}
	public function getInvoiceLine(){
	 	return $this->InvoiceLine;
	}
	
	public function getIdDocumento(){
	 	return $this->IdDocumento;
	}
	public function getFechaEmision(){
	 	return $this->FechaEmision;
	}
	public function getMoneda(){
	 	return $this->Moneda;
	}
	public function getGravadas(){
	 	return $this->Gravadas;
	}
	public function getGratuitas(){
	 	return $this->Gratuitas;
	}
	public function getInafectas(){
	 	return $this->Inafectas;
	}
	public function getExoneradas(){
	 	return $this->Exoneradas;
	}
	public function getDescuentoGlobal(){
	 	return $this->DescuentoGlobal;
	}
	public function getTotalVenta(){
	 	return $this->TotalVenta;
	}
	public function getTotalIgv(){
	 	return $this->TotalIgv;
	}
	public function getTotalIsc(){
	 	return $this->TotalIsc;
	}
	public function getTotalOtrosTributos(){
	 	return $this->TotalOtrosTributos;
	}
	public function getMontoEnLetras(){
	 	return $this->MontoEnLetras;
	}
	public function getTipoOperacion(){
	 	return $this->TipoOperacion;
	}
	public function getPlacaVehiculo(){
	 	return $this->PlacaVehiculo;
	}
	public function getCalculoIgv(){
	 	return $this->CalculoIgv;
	}
	public function getCalculoIsc(){
	 	return $this->CalculoIsc;
	}
	public function getCalculoDetraccion(){
	 	return $this->CalculoDetraccion;
	}
	public function getMontoPercepcion(){
	 	return $this->MontoPercepcion;
	}
	public function getMontoDetraccion(){
	 	return $this->MontoDetraccion;
	}
	public function getTipoDocAnticipo(){
	 	return $this->TipoDocAnticipo;
	}
	public function getDocAnticipo(){
	 	return $this->DocAnticipo;
	}
	public function getMonedaAnticipo(){
	 	return $this->MonedaAnticipo;
	}
	public function getMontoAnticipo(){
	 	return $this->MontoAnticipo;
	}

	//SETTER
	public function setDocRelacionado($DocRelacionado){
	 	$this->DocRelacionado=$DocRelacionado;
	}
	public function setDiscrepancia($Discrepancia){
	 	$this->Discrepancia=$Discrepancia;
	}

	public function setSunatTransaction($SunatTransaction){
	 	$this->SunatTransaction=$SunatTransaction;
	}
	public function setEncabezado($Encabezado){
	 	$this->Encabezado=$Encabezado;
	}
	public function setInvoiceLine($InvoiceLine){
	 	$this->InvoiceLine=$InvoiceLine;
	}
	public function setIdDocumento($IdDocumento){
	 	$this->IdDocumento=$IdDocumento;
	}
	public function setFechaEmision($FechaEmision){
	 	$this->FechaEmision=$FechaEmision;
	}
	public function setMoneda($Moneda){
	 	$this->Moneda=$Moneda;
	}
	public function setGravadas($Gravadas){
	 	$this->Gravadas=$Gravadas;
	}
	public function setGratuitas($Gratuitas){
	 	$this->Gratuitas=$Gratuitas;
	}
	public function setInafectas($Inafectas){
	 	$this->Inafectas=$Inafectas;
	}
	public function setExoneradas($Exoneradas){
	 	$this->Exoneradas=$Exoneradas;
	}
	public function setDescuentoGlobal($DescuentoGlobal){
	 	$this->DescuentoGlobal=$DescuentoGlobal;
	}
	public function setTotalVenta($TotalVenta){
	 	$this->TotalVenta=$TotalVenta;
	}
	public function setTotalIgv($TotalIgv){
	 	$this->TotalIgv=$TotalIgv;
	}
	public function setTotalIsc($TotalIsc){
	 	$this->TotalIsc=$TotalIsc;
	}
	public function setTotalOtrosTributos($TotalOtrosTributos){
	 	$this->TotalOtrosTributos=$TotalOtrosTributos;
	}
	public function setMontoEnLetras($MontoEnLetras){
	 	$this->MontoEnLetras=$MontoEnLetras;
	}
	public function setTipoOperacion($TipoOperacion){
	 	$this->TipoOperacion=$TipoOperacion;
	}
	public function setPlacaVehiculo($PlacaVehiculo){
	 	$this->PlacaVehiculo=$PlacaVehiculo;
	}
	public function setCalculoIgv($CalculoIgv){
	 	$this->CalculoIgv=$CalculoIgv;
	}
	public function setCalculoIsc($CalculoIsc){
	 	$this->CalculoIsc=$CalculoIsc;
	}
	public function setCalculoDetraccion($CalculoDetraccion){
	 	$this->CalculoDetraccion=$CalculoDetraccion;
	}
	public function setMontoPercepcion($MontoPercepcion){
	 	$this->MontoPercepcion=$MontoPercepcion;
	}
	public function setMontoDetraccion($MontoDetraccion){
	 	$this->MontoDetraccion=$MontoDetraccion;
	}
	public function setTipoDocAnticipo($TipoDocAnticipo){
	 	$this->TipoDocAnticipo=$TipoDocAnticipo;
	}
	public function setDocAnticipo($DocAnticipo){
	 	$this->DocAnticipo=$DocAnticipo;
	}
	public function setMonedaAnticipo($MonedaAnticipo){
	 	$this->MonedaAnticipo=$MonedaAnticipo;
	}
	public function setMontoAnticipo($MontoAnticipo){
	 	$this->MontoAnticipo=$MontoAnticipo;
	}

}
?>