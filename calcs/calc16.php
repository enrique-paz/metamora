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
	
	if ($Variables->HomeValue <= 0)
	{
		$Variables->HomeValue = $Defaults->HomeValue;
		$Variables->OutVar["HomeValue"] = number_format($Variables->HomeValue, 2, '.', ',');
	}
	
	if ($Variables->Amount <= 0)
	{
		$Variables->Amount = $Defaults->Amount;
		$Variables->OutVar["Amount"] = number_format($Variables->Amount, 2, '.', ',');
	}
	
	if ($Variables->Amount > $Variables->HomeValue) {
		$Variables->Amount = $Defaults->Amount;
		$Variables->OutVar["Amount"] = number_format($Variables->Amount, 2, '.', ',');
		$Variables->HomeValue = $Defaults->HomeValue;
		$Variables->OutVar["HomeValue"] = number_format($Variables->HomeValue, 2, '.', ',');
	}
	
	if ($Variables->Interest <= 0)
	{
		$Variables->Interest = $Defaults->Interest;
		$Variables->OutVar["Interest"] = number_format($Variables->Interest, 3, '.', ',');
	}
	
	if ($Variables->Length <= 0)
	{
		$Variables->Length = $Defaults->Length;
		$Variables->OutVar["Length"] = number_format($Variables->Length, 0, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;
	
	// Calculating downpayment, monthly taxes and insurance payments.
	$DownPayment       = $Variables->HomeValue - $Variables->Amount;
	
	if ($Variables->HomeValue > 400000)
		$RequiredDownPayment = 0.35 * $Variables->HomeValue;
	else
		$RequiredDownPayment = 0.25 * $Variables->HomeValue;
		
	// Calculating an actual monthly payment, including interest during the life of loan
	$MonthlyPayment = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length, 12, 2);
	
	$RequiredIncome = 12 * 100 * $MonthlyPayment / 32;

	$options = new AmortizationOptions();
	$options->Compounds     = 2;
	
	$AmortizationTable = Calc::BuildAmortizationTable($Variables->HomeValue, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

	$vars['AmortizationTable'] = $AmortizationTable;
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['MonthlyPayment']       = number_format($MonthlyPayment,  '2', '.', ',');
	$vars['DownPayment']          = number_format($DownPayment,  '2', '.', ',');
	$vars['RequiredDownPayment']  = number_format($RequiredDownPayment,  '2', '.', ',');
	$vars['RequiredIncome']       = number_format($RequiredIncome,  '2', '.', ',');

	if (!empty($Variables->PDFGen))
	{
		$pdf = new PDF('P', 'mm', $PdfSettings->PageSize);
		$pdf->AllowFooter = true;
		$pdf->SetFont($PdfSettings->FontName, '', 9);
		if (strtolower($PdfSettings->PageSize) == 'legal' || strtolower($PdfSettings->PageSize) == 'letter') $pdf->SetLeftMargin(13); else $pdf->SetLeftMargin(10);
		if (strtolower($PdfSettings->PageSize) == 'legal' || strtolower($PdfSettings->PageSize) == 'letter') $pdf->SetRightMargin(13); else $pdf->SetRightMargin(10);
		$pdf->SetCompression(false);
		$pdf->AddPage();
	
		// Calculator's header
		$pdf->SetHeaderMode();
		$pdf->Cell(190, 10, $lang['Calc16Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(90, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(95, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetCaptionMode();
		$pdf->Cell(90, 5, $lang['HomeValue'], 1, 0, 'C', 1);
		$pdf->SetTableMode();
		$pdf->Cell(5, 5, ' ');
		$pdf->Cell(55, 5, $lang['MonthlyPI'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $AmortizationTable->TotalPaymentAmount, 1, 0, 'C', 1, '');
		$pdf->Ln();	
		
		$pdf->SetCaptionMode();
		$pdf->Cell(90, 5, $lang['LoanInfo'], 1, 0, 'C', 1);
		$pdf->SetTableMode();
		$pdf->Cell(5, 5, ' ');
		$pdf->Cell(55, 5, $lang['TotalInterestPaid'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $AmortizationTable->TotalInterestPaid, 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 5, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 5, $lang['DownPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['DownPayment'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 5, $vars['Interest'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 5, $lang['RequiredDownPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['RequiredDownPayment'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 5, $vars['Length'] . ' '. $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 5, $lang['RequiredIncome'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['RequiredIncome'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
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
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();

		$pdf->SetFontSize(7);
		// Schedule table
		$arr = $AmortizationTable->Schedule;
		$fill = false;
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(30, 4, ' ');
				$pdf->Cell(10, 4, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(40, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(10, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form16.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>