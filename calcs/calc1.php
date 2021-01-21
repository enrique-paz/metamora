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
	if ($Variables->Amount <= 0)
	{
		$Variables->Amount = $Defaults->Amount;
		$Variables->OutVar["Amount"] = number_format($Variables->Amount, 2, '.', ',');
	}

	if ($Variables->Interest <= 0)
	{
		$Variables->Interest = $Defaults->Interest;
		$Variables->OutVar["Interest"] = number_format($Variables->Interest, 2, '.', ',');
	}

	if ($Variables->Length <= 0)
	{
		$Variables->Length = $Defaults->Length;
		$Variables->OutVar["Length"] = number_format($Variables->Length, 0, '.', ',');
	}
	
	if ($Variables->HomeValue <= 0)
	{
		$Variables->HomeValue = $Defaults->HomeValue;
		$Variables->OutVar["HomeValue"] = number_format($Variables->HomeValue, 2, '.', ',');
	}
	
	if ($Variables->Amount > $Variables->HomeValue) {
		$Variables->Amount = $Defaults->Amount;
		$Variables->OutVar["Amount"] = number_format($Variables->Amount, 2, '.', ',');
		$Variables->HomeValue = $Defaults->HomeValue;
		$Variables->OutVar["HomeValue"] = number_format($Variables->HomeValue, 2, '.', ',');
	}
	
	if ($Variables->PropertyTaxes < 0 || ($Variables->PropertyTaxes > 100 && $Variables->PropertyTaxesSel == 1)) {
		$Variables->PropertyTaxes = $Defaults->PropertyTaxes;
		$Variables->PropertyTaxesSel = $Defaults->PropertyTaxesSel;
		$Variables->OutVar['PropertyTaxes'] = number_format($Variables->PropertyTaxes, 2, '.', ',');
		$Variables->OutVar['PropertyTaxesSel'] = $Defaults->PropertyTaxesSel;
	}

	if ($Variables->Insurance < 0 || ($Variables->Insurance > 100 && $Variables->InsuranceSel == 1)) {
		$Variables->Insurance = $Defaults->Insurance;
		$Variables->InsuranceSel = $Defaults->InsuranceSel;
		$Variables->OutVar['Insurance'] = number_format($Variables->Insurance, 2, '.', ',');
		$Variables->OutVar['InsuranceSel'] = $Defaults->InsuranceSel;
	}

	if ($Variables->PMI < 0 || ($Variables->PMI > 100 && $Variables->PMISel == 1)) {
		$Variables->PMI = $Defaults->PMI;
		$Variables->PMISel = $Defaults->PMISel;
		$Variables->OutVar['PMI'] = number_format($Variables->PMI, 3, '.', ',');
		$Variables->OutVar['PMISel'] = $Defaults->PMISel;
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

	if ($Variables->PropertyTaxesSel == '0')
		$PropertyTaxes = $Variables->PropertyTaxes;
	else 
		$PropertyTaxes = $Variables->PropertyTaxes * $Variables->HomeValue / 100;
		
	if ($Variables->InsuranceSel == '0')
		$Insurance = $Variables->Insurance;
	else
		$Insurance = $Variables->HomeValue * $Variables->Insurance / 100;

	if ($Variables->PMISel == '0')
		$PMI = $Variables->PMI;
	else
		$PMI = $Variables->Amount * $Variables->PMI / 100;

	$MonthlyTaxes     = $PropertyTaxes / 12;
	$MonthlyInsurance = $Insurance / 12;
	$MonthlyPMI       = $PMI / 12;
	
	// Calculating an actual monthly payment, including interest during the life of loan
	$MonthlyPayment =  Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);

	// Calculating LTV ratio in percent.
	$LoanToValue = ($Variables->Amount / $Variables->HomeValue) * 100;

	// If LTV ratio is greater than 80% (i.e. downpayment is less than 20%), then 
	// PMI (Personal Mortgage Insurance) must be applied. Check GetPMIByLTV for 
	// used PMI ratios.
    if ($LoanToValue > 80) {
        $vars['MonthlyPMI']  = number_format($MonthlyPMI, '2', '.', ',');
        $vars['LoanToValue'] = number_format($LoanToValue, '2', '.', ',');
    }
	else
	{
		$MonthlyPMI = 0;
		$PMI        = 0;
	}

    $MonthlyTotal = $MonthlyPayment + $MonthlyTaxes + $MonthlyInsurance + $MonthlyPMI;

	$options = new AmortizationOptions();
	$options->PMI           = $PMI;
	$options->PropertyTaxes = $PropertyTaxes;
	$options->Insurance     = $Insurance;
	
	$AmortizationTable = Calc::BuildAmortizationTable($Variables->HomeValue, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

	$vars['AmortizationTable'] = $AmortizationTable;
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['MonthlyTaxes']     = number_format($MonthlyTaxes,    '2', '.', ',');
	$vars['MonthlyInsurance'] = number_format($MonthlyInsurance,'2', '.', ',');
	$vars['MonthlyPayment']   = number_format($MonthlyPayment,  '2', '.', ',');
	$vars['MonthlyPMI']       = number_format($MonthlyPMI,      '2', '.', ',');
	$vars['MonthsWithPMI']    = $AmortizationTable->TotalPeriodsWithPMI;
	$vars['MonthlyTotal']     = number_format($MonthlyTotal,    '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc1Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(90, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(95, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetCaptionMode();
		$pdf->Cell(90, 5, $lang['LoanInfo'], 1, 0, 'C', 1);
		$pdf->Cell(5, 5, ' ');
		$pdf->SetTableMode();
		$pdf->Cell(55, 5, $lang['MonthlyPI'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 5, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 5, ' ');
		$pdf->Cell(55, 5, $lang['MonthlyPropertyTaxes'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['MonthlyTaxes'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 5, $vars['Interest'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 5, ' ');
		$pdf->Cell(55, 5, $lang['MonthlyInsurance'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['MonthlyInsurance'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 5, $vars['Length'] . ' '. $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 5, ' ');
		$pdf->Cell(55, 5, $lang['LTV'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $vars['LoanToValue'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->SetCaptionMode();
		$pdf->Cell(90, 5, $lang['HomeValue'], 1, 0, 'C', 1);
		$pdf->SetTableMode();
		$pdf->Cell(5, 5, ' ');
		$pdf->Cell(55, 5, $lang['MonthsWithPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $vars['MonthsWithPMI'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 5, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 5, ' ');
		$pdf->Cell(55, 5, $lang['MonthlyPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['MonthlyPMI'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetCaptionMode();
		$pdf->Cell(90, 5, $lang['TaxAndInsuranceInfo'], 1, 0, 'C', 1);
		$pdf->SetTableMode();
		$pdf->Cell(5, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 5, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 5, $lang['Currency'] . $vars['MonthlyTotal'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode();
		$pdf->Cell(45, 5, $lang['PropertyTaxes'], 1, 0, 'R', 1, '');
		if ($Variables->PropertyTaxesSel == 0)
			$pdf->Cell(45, 5, $CalcSettings->Currency . $vars['PropertyTaxes'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 5, $vars['PropertyTaxes'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['Insurance'], 1, 0, 'R', 1, '');
		if ($Variables->InsuranceSel == 0)
			$pdf->Cell(45, 5, $CalcSettings->Currency . $vars['Insurance'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 5, $vars['Insurance'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 5, $lang['PMI'], 1, 0, 'R', 1, '');
		if ($Variables->PMISel == 0)
			$pdf->Cell(45, 5, $CalcSettings->Currency . $vars['PMI'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 5, $vars['PMI'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		$pdf->Ln();
		
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(130, 6, $lang['PaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(30, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();

		$pdf->SetFontSize(7);
		$arr = $AmortizationTable->Schedule;
		$fill = false;
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(30, 4, ' ');
				$pdf->Cell(10, 4, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(30, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->PMI,              'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
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
		
		$content = $smarty->fetch($Variables->Template.'/form1.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>