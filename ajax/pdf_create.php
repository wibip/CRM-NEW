<?php
header("Cache-Control: no-cache, must-revalidate");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);
session_start();

/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();
include_once '../classes/systemPackageClass.php';
$package_functions = new package_functions();
include_once '../classes/CommonFunctions.php';
$system_package = $package_functions->getPackage($_SESSION['user_name']);

$module_array = array('home');

if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    return false;
}

require_once '../plugins/fpdf/fpdf.php';

class PDF extends FPDF
{
    function onboarding(array $arr){
        $this->SetFont('Arial','B',18);
        $this->SetTextColor(0,0,0);
        $this->Cell(60,15,'Onboarding Wi-Fi');
        $this->SetFont('Arial','B',14);
        $this->Ln();
        foreach ($arr as $value) {
            if(strlen($value)>0){
                $w1 = $this->GetStringWidth($value)+6;
                $this->SetTextColor(51,51,51);
                $this->Cell($w1,10,$value);
                $this->Ln();
            }
        }
        $this->Ln();
    }    

    function resident(array $arr,$wired){
        $this->SetFont('Arial','B',18);
        $this->SetTextColor(0,0,0);
        if ($wired == 1) {
            $this->Cell(60,15,'Resident Network');
        }else{
            $this->Cell(60,15,'Resident Wi-Fi');
        }
        $this->SetFont('Arial','B',14);
        $this->Ln();
        foreach ($arr as $value) {
            if(strlen($value)>0){
                $w1 = $this->GetStringWidth($value)+6;
                $this->SetTextColor(51,51,51);
                $this->Cell($w1,10,$value);
                $this->Ln();
            }
        }
        $this->Ln();
    } 

    function guest(array $arr){
        $this->SetFont('Arial','B',18);
        $this->SetTextColor(0,0,0);
        $this->Cell(60,15,'Guest Wi-Fi');
        $this->SetFont('Arial','B',14);
        $this->Ln();
        foreach ($arr as $value) {
            if(strlen($value)>0){
                $w1 = $this->GetStringWidth($value)+6;
                $this->SetTextColor(51,51,51);
                $this->Cell($w1,10,$value);
                $this->Ln();
            }
        }
        $this->Ln();
    }    
}
ob_start();
$pdf = new PDF();
$pdf->AddPage();

if(isset($_POST['guest'])){
    $pdf->guest($_POST['guest']);
}
if(isset($_POST['resident'])){
    if (isset($_POST['wired'])) {
        $pdf->resident($_POST['resident'],'1');
    }else{
        $pdf->resident($_POST['resident'],'2');
    }
}
if(isset($_POST['onboard'])){
    $pdf->onboarding($_POST['onboard']);
}

if (isset($_POST['wired'])) {
    $pdf->Output('Network Information.pdf','D');
}else{
    $pdf->Output('Wi-Fi Information.pdf','D');
}
ob_end_flush(); 
?>