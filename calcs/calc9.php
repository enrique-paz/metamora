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
	
	if ($Variables->DownPayment < 0 || ($Variables->DownPayment > 100 && $Variables->DownPaymentSel == 1)) {
		$Variables->DownPayment = $Defaults->DownPayment;
		$Variables->DownPaymentSel = $Defaults->DownPaymentSel;
		$Variables->OutVar['DownPayment'] = number_format($Variables->DownPayment, 3, '.', ',');
		$Variables->OutVar['DownPaymentSel'] = $Defaults->DownPaymentSel;
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
	
	if ($Variables->FrontRatio <= 0)
	{
		$Variables->FrontRatio = $Defaults->FrontRatio;
		$Variables->OutVar["FrontRatio"] = number_format($Variables->FrontRatio, 3, '.', ',');
	}
	
	if ($Variables->BackRatio <= 0)
	{
		$Variables->BackRatio = $Defaults->BackRatio;
		$Variables->OutVar["BackRatio"] = number_format($Variables->BackRatio, 3, '.', ',');
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
	
    // Calculating DownPayment Value and Home Value based on
    // the estimated amount to be financed.
	if ($Variables->DownPaymentSel == '0')
	{
		$DownPaymentValue = $Variables->DownPayment;
		$Amount           = $Variables->HomeValue - $DownPaymentValue;
	}
	else 
	{
		$DownPaymentValue = $Variables->HomeValue * $Variables->DownPayment / 100;
		$Amount           = $Variables->HomeValue - $DownPaymentValue;
	}

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
		$PMI = $Amount * $Variables->PMI / 100;

	$MonthlyTaxes     = $PropertyTaxes / 12;
	$MonthlyInsurance = $Insurance / 12;
	$MonthlyPMI       = $PMI / 12;
	
	// Calculating an actual monthly payment, including interest during the life of loan
	$MonthlyPayment = Calc::PeriodPayment($Amount, $Variables->Interest, $Variables->Length);

	// Calculating LTV ratio in percent.
	$LoanToValue = ($Amount / $Variables->HomeValue) * 100;

	// If LTV ratio is greater than 80% (i.e. downpayment is less than 20%), then 
	// PMI (Personal Mortgage Insurance) must be applied. 
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
    
    $RequiredIncome = $MonthlyTotal / $Variables->FrontRatio * 100;
    $AllowedDebts   = $RequiredIncome - $MonthlyTotal / $Variables->BackRatio * 100;

	$options = new AmortizationOptions();
	$options->PMI           = $PMI;
	$options->PropertyTaxes = $PropertyTaxes;
	$options->Insurance     = $Insurance;
	
	$AmortizationTable = Calc::BuildAmortizationTable($Variables->HomeValue, $Amount, $Variables->Interest, $Variables->Length, $options);

	$vars['AmortizationTable'] = $AmortizationTable;
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['MonthlyTaxes']     = number_format($MonthlyTaxes,    '2', '.', ',');
	$vars['MonthlyInsurance'] = number_format($MonthlyInsurance,'2', '.', ',');
	$vars['MonthlyPayment']   = number_format($MonthlyPayment,  '2', '.', ',');
	$vars['MonthlyPMI']       = number_format($MonthlyPMI,      '2', '.', ',');
	$vars['MonthsWithPMI']    = $AmortizationTable->TotalPeriodsWithPMI;
	$vars['MonthlyTotal']     = number_format($MonthlyTotal,    '2', '.', ',');
	
	$vars['RequiredIncome']   = number_format($RequiredIncome,  '2', '.', ',');
	$vars['AllowedDebts']     = number_format($AllowedDebts,    '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc9Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(90, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(95, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['PropertyInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(50, 6, $lang['MonthlyPI'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(50, 6, $lang['MonthlyPropertyTaxes'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['MonthlyTaxes'], 1, 0, 'C', 1, '');
		$pdf->Ln();
			
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(50, 6, $lang['MonthlyInsurance'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['MonthlyInsurance'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['DownPayment'], 1, 0, 'R', 1, '');
		if ($Variables->DownPaymentSel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['DownPayment'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['DownPayment'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(50, 6, $lang['LTV'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['LoanToValue'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(50, 6, $lang['MonthsWithPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['MonthsWithPMI'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(50, 6, $lang['MonthlyPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['MonthlyPMI'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['EstimatedFrontRatio'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['FrontRatio'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(50, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['MonthlyTotal'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['EstimatedBackRatio'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['BackRatio'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(50, 6, $lang['AllowableDebtPayments'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['AllowedDebts'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['TaxAndInsuranceInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(50, 6, $lang['RequiredIncome'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['RequiredIncome'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['AnnualPropertyTaxes'], 1, 0, 'R', 1, '');
		if ($Variables->PropertyTaxesSel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['PropertyTaxes'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['PropertyTaxes'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		

		$pdf->Cell(45, 6, $lang['AnnualInsurance'], 1, 0, 'R', 1, '');
		if ($Variables->InsuranceSel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['Insurance'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['Insurance'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['AnnualPMI'], 1, 0, 'R', 1, '');
		if ($Variables->PMISel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['PMI'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['PMI'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln(8);
		
		// Schedule's header
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(130, 6, $lang['PaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		// Schedule's columns headers
		$pdf->Cell(30, 4, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->SetFontSize(7);
		$pdf->Cell(10, 4, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(30, 4, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 4, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(30, 4, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(30, 4, $lang['RemainingBalance'], 1,  0, 'R', 1);
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
				$pdf->Cell(30, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->PMI,              'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->Cell(30, 4, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->SetFontSize(7);
		$pdf->Cell(10, 4, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(30, 4, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 4, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(30, 4, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(30, 4, $lang['RemainingBalance'], 1,  0, 'R', 1);
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
		$pdf->Ln(5);
		
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
		
		$content = $smarty->fetch($Variables->Template.'/form9.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>