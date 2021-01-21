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
	
	if ($Variables->YearsBeforeSell <= 0)
	{
		$Variables->YearsBeforeSell = $Defaults->YearsBeforeSell;
		$Variables->OutVar["YearsBeforeSell"] = number_format($Variables->YearsBeforeSell, 0, '.', ',');
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
	
	if ($Variables->Points < 0)
	{
		$Variables->Points = $Defaults->Points;
		$Variables->OutVar["Points"] = number_format($Variables->Points, 3, '.', ',');
	}
	
	if ($Variables->Closing < 0)
	{
		$Variables->Closing = $Defaults->Closing;
		$Variables->OutVar["Closing"] = number_format($Variables->Closing, 2, '.', ',');
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
	
	if ($Variables->Taxes < 0)
	{
		$Variables->Taxes = $Defaults->Taxes;
		$Variables->OutVar["Taxes"] = number_format($Variables->Taxes, 3, '.', ',');
	}
	
	if ($Variables->StateTax < 0)
	{
		$Variables->StateTax = $Defaults->StateTax;
		$Variables->OutVar["StateTax"] = number_format($Variables->StateTax, 3, '.', ',');
	}
	
	if ($Variables->Deductions < 0)
	{
		$Variables->Deductions = $Defaults->Deductions;
		$Variables->OutVar["Deductions"] = number_format($Variables->Deductions, 2, '.', ',');
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

	$Taxes = $Variables->Taxes + $Variables->StateTax;
	
	$PointsValue = $Variables->Amount * $Variables->Points / 100;
	
	$AmountFinanced = $Variables->Amount;
	
	$MonthlyTaxes     = $PropertyTaxes / 12;
	$MonthlyInsurance = $Insurance / 12;
	$MonthlyPMI       = $PMI / 12;
	
	// Calculating an actual monthly payment, including interest during the life of loan
	$MonthlyPayment = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);

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
	$options->Taxes         = $Taxes;

	$AmortizationTable      = Calc::BuildAmortizationTable($Variables->HomeValue, $AmountFinanced, $Variables->Interest, $Variables->Length, $options);
	$AmortizationTable2     = Calc::BuildAmortizationTable($Variables->HomeValue, $AmountFinanced, $Variables->Interest, $Variables->YearsBeforeSell, $options);
	
	$InterestAndPoints      = $PointsValue + $AmortizationTable->InterestPaid;
	$InterestAndPoints2     = $PointsValue + $AmortizationTable2->InterestPaid;
	
	$TotalPropertyTaxes     = $PropertyTaxes * $Variables->Length;
	$TotalPropertyTaxes2    = $PropertyTaxes * $Variables->YearsBeforeSell;
	
	$TotalDeductions        = $InterestAndPoints + $TotalPropertyTaxes;
	$TotalDeductions2       = $InterestAndPoints2 + $TotalPropertyTaxes2;
	
	$TaxSavings             = $Taxes * $TotalDeductions / 100;
	$TaxSavings2            = $Taxes * $TotalDeductions2 / 100;
	
	$MonthlyTaxSavings      = $TaxSavings / $Variables->Length / 12;
	$MonthlyTaxSavings2     = $TaxSavings2 / $Variables->YearsBeforeSell / 12;
	
	$AveragePayment         = $MonthlyTotal - $MonthlyTaxSavings;
	$AveragePayment2        = $MonthlyTotal - $MonthlyTaxSavings2;
	
	// Assembling an array for output.	
	$vars['AmortizationTable']  = $AmortizationTable;
	$vars['AmortizationTable2'] = $AmortizationTable2;

	$vars['AmountFinanced']     = number_format($AmountFinanced, '2', '.', ',');
	// Assigning calculated values to the output array.
	$vars['MonthlyTaxes']       = number_format($MonthlyTaxes,    '2', '.', ',');
	$vars['MonthlyInsurance']   = number_format($MonthlyInsurance,'2', '.', ',');
	$vars['MonthlyPayment']     = number_format($MonthlyPayment,  '2', '.', ',');
	$vars['MonthlyPMI']         = number_format($MonthlyPMI,      '2', '.', ',');
	$vars['MonthsWithPMI']      = $AmortizationTable->TotalPeriodsWithPMI;
	$vars['MonthlyTotal']       = number_format($MonthlyTotal,    '2', '.', ',');
	
	$vars['InterestAndPoints']  = number_format($InterestAndPoints,    '2', '.', ',');
	$vars['InterestAndPoints2'] = number_format($InterestAndPoints2,    '2', '.', ',');
	
	$vars['TotalPropertyTaxes'] = number_format($TotalPropertyTaxes,    '2', '.', ',');
	$vars['TotalPropertyTaxes2']= number_format($TotalPropertyTaxes2,    '2', '.', ',');

	$vars['TotalDeductions']    = number_format($TotalDeductions,    '2', '.', ',');
	$vars['TotalDeductions2']   = number_format($TotalDeductions2,    '2', '.', ',');

	$vars['TaxSavings']         = number_format($TaxSavings,    '2', '.', ',');
	$vars['TaxSavings2']        = number_format($TaxSavings2,    '2', '.', ',');

	$vars['AveragePayment']     = number_format($AveragePayment,    '2', '.', ',');
	$vars['AveragePayment2']    = number_format($AveragePayment2,    '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc5Title'], 1, 1, 'C', 1, '');
		
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
		$pdf->Cell(45, 6, $lang['AmountFinanced'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['AmountFinanced'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		

		$pdf->Cell(45, 6, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['YearsBeforeSell'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['YearsBeforeSell'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyPropertyTaxes'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['MonthlyTaxes'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyInsurance'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['MonthlyInsurance'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['LTV'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $vars['LoanToValue'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthsWithPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $vars['MonthsWithPMI'], 1, 0, 'C', 1, '');		
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['MonthlyPMI'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['MonthlyTotal'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['ClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['Closing'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, ' ', 1, 0, '', 1);
		$pdf->SetTableMode(true);
		$pdf->Cell(25, 6, $lang['FirstYears'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Total'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['TaxAndInsuranceInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['InterestAndPoints'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['InterestAndPoints2'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['InterestAndPoints'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['AnnualPropertyTaxes'], 1, 0, 'R', 1, '');
		if ($Variables->PropertyTaxesSel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['PropertyTaxes'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['PropertyTaxes'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['TotalPropertyTaxes'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalPropertyTaxes2'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalPropertyTaxes'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['AnnualInsurance'], 1, 0, 'R', 1, '');
		if ($Variables->InsuranceSel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['Insurance'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['Insurance'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['TotalDeductions'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalDeductions2'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalDeductions'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['AnnualPMI'], 1, 0, 'R', 1, '');
		if ($Variables->PMISel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['PMI'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['PMI'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['TaxSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TaxSavings2'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TaxSavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['YourTaxRatesAndDeductions'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['AveragePaymentAfterTaxes'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['AveragePayment2'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['AveragePayment'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['TaxRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Taxes'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['StateTaxRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['StateTax'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Deductions'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['Deductions'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		$pdf->Ln();

		// Calculator's footprint
		$pdf->SetFootprintMode();
		$pdf->MultiCell(190, 4, $PdfSettings->FootPrint);
		$pdf->AddPage();

		$pdf->SetHeaderMode();
		$pdf->Cell(190, 10, $lang['Calc5Title'], 1, 1, 'C', 1, '');
		
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
		$pdf->Cell(24, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['TaxSavings'],       1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
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
				$pdf->Cell(24, 5, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(24, 5, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(24, 5, $period->TaxSavings,       'L',  0, 'R', $fill);
				$pdf->Cell(24, 5, $period->PMI,              'L',  0, 'R', $fill);
				$pdf->Cell(24, 5, $period->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(24, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['TaxSavings'],       1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(24, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(10, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(24, 5, $AmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(24, 5, $AmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(24, 5, $AmortizationTable->TotalTaxSavings,       1,  0, 'R', 1);
		$pdf->Cell(24, 5, $AmortizationTable->TotalPMI,              1,  0, 'R', 1);
		$pdf->Cell(24, 5, $AmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
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
		
		$content = $smarty->fetch($Variables->Template.'/form5.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>