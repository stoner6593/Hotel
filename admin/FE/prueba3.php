<?php
$cert = "LLAMA-PE-CERTIFICADO-DEMO-20545756022.pfx"; 
$key = file_get_contents($cert); 
openssl_pkcs12_read($key,$x509certdata,'20545756022'); 

$pub = $x509certdata['cert']; 
$key = $x509certdata['pkey']; 
file_put_contents('pubkey.pem',$x509certdata['cert']); 
file_put_contents('prikey.pem',$x509certdata['pkey']); 
file_put_contents('cert.pem',$x509certdata['pkey']."\r\n".$x509certdata['cert']); 


//Trata Certificado tirando INICIO -----BEGIN CERTIFICATE----- e FIM -----END CERTIFICATE----- 
$pub_tratado = explode('-----BEGIN CERTIFICATE-----',$pub); 
$pub_tratado = $pub_tratado['1']; 
$pub_tratado = explode('-----END CERTIFICATE-----',$pub_tratado); 
$pub_tratado = $pub_tratado['0']; 

//FIM Trata Certificado tirando INICIO -----BEGIN CERTIFICATE----- e FIM -----END CERTIFICATE----- 

/** 
* __validCerts 
* Valida&#258;&sect;ao do cerificado digital, al&#258;&Scaron;m de indicar 
* a validade, este metodo carrega a propriedade 
* mesesToexpire da classe que indica o numero de 
* meses que faltam para expirar a validade do mesmo 
* esta informacao pode ser utilizada para a gestao dos 
* certificados de forma a garantir que sempre estejam validos 
* 
* @name __validCerts 
* @version 1.00 
* @package NFePHP 
* @author Roberto L. Machado <linux> 
* @param string $cert Certificado digital no formato pem 
* @return array ['status'=>true,'meses'=>8,'dias'=>245] 
*/ 

$data = openssl_x509_read($pub); 
$cert_data = openssl_x509_parse($data); 
// reformata a data de validade; 
$ano = substr($cert_data['validTo'],0,2); 
$mes = substr($cert_data['validTo'],2,2); 
$dia = substr($cert_data['validTo'],4,2); 
//obtem o timeestamp da data de validade do certificado 
$dValid = gmmktime(0,0,0,$mes,$dia,$ano); 
// obtem o timestamp da data de hoje 
$dHoje = gmmktime(0,0,0,date("m"),date("d"),date("Y")); 
// compara a data de validade com a data atual 
if ($dValid)/* <dHoje>certMonthsToExpire = */$monthsToExpire; 
//$this->certDaysToExpire = $daysToExpire; 
// return array('status'=>$flagOK,'error'=>$errorMsg,'meses'=>$monthsToExpire,'dias'=>$daysToExpire); 
//echo "<br>Dias para Expirar".$daysToExpire."<br>"; 
//fim __validCerts 



$pubKey = file_get_contents('pubkey.pem'); 
//inicializa variavel 
$dat = ''; 
//carrega o certificado em um array usando o LF como referencia 
$arCert = explode("\n", $pubKey); 
foreach ($arCert AS $curData) { 
//remove a tag de inicio e fim do certificado 
if (strncmp($curData, '-----BEGIN CERTIFICATE', 22) != 0 && strncmp($curData, '-----END CERTIFICATE', 20) != 0 ) { 
//carrega o resultado numa string 
$dat .= trim($curData); 
//echo $data; 
} 
} 
// return $data; 
?>