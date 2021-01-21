<?

include_once('variables.php');
include_once('settings.php');
include_once('lang/'.$Variables->Language .'/lang.php');

if (!empty($Variables->PDFGen))
{
	include_once('libs/fpdf.php');
	include_once('templates/'. $Variables->Template . '/pdfSettings.php');
	include_once('templates/'. $Variables->Template . '/pdfGenerator.php');
}
else 
{
	if (!class_exists('smarty'))
		include_once('libs/Smarty.class.php');
}

include_once('functions.php');

checkVariables();

if (empty($Variables->PDFGen))
{
	// Including common header
	include_once('templates/'. $Variables->Template .'/header.php');
}

$CalcContent = showForm();

if (empty($Variables->PDFGen))
{
	// Including common footer from the templates directory
	include_once('templates/'. $Variables->Template .'/footer.php');
}

function checkVariables()
{
	global $Variables, $Defaults;
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

	// Calculating values
	$periodPayment = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);
	$TotalPayment = $periodPayment * 12 * $Variables->Length;
	
	$options = new AmortizationOptions();
	$AmortizationTable = new AmortizationTable();	
	$options->PeriodPayment = $periodPayment + $Variables->AdditionalPayment;
	$AmortizationTable = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);
	$TotalPayment2 = $AmortizationTable->PaymentAmount;
	
	$vars['AmortizationTable'] = $AmortizationTable;
	
	if (!empty($Variables->PDFGen))
	{
		$pdf = new PDF('P', 'mm', $PdfSettings->PageSize);
		$pdf->SetFont($PdfSettings->FontName, '', 9);
		if (strtolower($PdfSettings->PageSize) == 'legal' || strtolower($PdfSettings->PageSize) == 'letter') $pdf->SetLeftMargin(13); else $pdf->SetLeftMargin(10);
		if (strtolower($PdfSettings->PageSize) == 'legal' || strtolower($PdfSettings->PageSize) == 'letter') $pdf->SetRightMargin(13); else $pdf->SetRightMargin(10);
		$pdf->SetCompression(false);
		$pdf->AddPage();
	
		// Calculator's header
		$pdf->SetHeaderMode();
		$pdf->Cell(190, 10, $lang['Calc11Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(90, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(95, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		// Schedule's header
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(130, 6, $lang['PaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		// Schedule's columns headers
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(30, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();

		// Schedule table
		$arr = $AmortizationTable->Schedule;
		$fill = false;
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(30, 5, ' ');
				$pdf->Cell(10, 5, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(30, 5, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(30, 5, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(30, 5, $period->PMI,              'L',  0, 'R', $fill);
				$pdf->Cell(30, 5, $period->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(30, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(10, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(30, 5, $AmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable->TotalPMI,              1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		// Calculator's footprint
		$pdf->SetFootprintMode();
		$pdf->MultiCell(190, 4, $PdfSettings->FootPrint);
		
		$pdf->Output();
	}
	else 
	{
		// Creating a Smarty class instance and assigning values array to it.
		$smarty = new Smarty();
		$smarty->assign('vars', $vars);
		$smarty->assign('lang', $Variables->LangVar);
		
		$content = $smarty->fetch($Variables->Template.'/form11.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>