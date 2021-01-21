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
	
	if ($Variables->Income <= 0)
	{
		$Variables->Income = $Defaults->Income;
		$Variables->OutVar["Income"] = number_format($Variables->Income, 2, '.', ',');
	}
	
	if ($Variables->Income2 < 0)
	{
		$Variables->Income2 = $Defaults->Income2;
		$Variables->OutVar["Income2"] = number_format($Variables->Income2, 2, '.', ',');
	}
	
	if ($Variables->Income3 < 0)
	{
		$Variables->Income3 = $Defaults->Income3;
		$Variables->OutVar["Income3"] = number_format($Variables->Income3, 2, '.', ',');
	}
	
	if ($Variables->Income4 < 0)
	{
		$Variables->Income4 = $Defaults->Income4;
		$Variables->OutVar["Income4"] = number_format($Variables->Income4, 2, '.', ',');
	}
	
	if ($Variables->Income5 < 0)
	{
		$Variables->Income5 = $Defaults->Income5;
		$Variables->OutVar["Income5"] = number_format($Variables->Income5, 2, '.', ',');
	}
	
	if ($Variables->DebtPayment < 0)
	{
		$Variables->DebtPayment = $Defaults->DebtPayment;
		$Variables->OutVar["DebtPayment"] = number_format($Variables->DebtPayment, 2, '.', ',');
	}
	
	if ($Variables->DebtPayment2 < 0)
	{
		$Variables->DebtPayment2 = $Defaults->DebtPayment2;
		$Variables->OutVar["DebtPayment2"] = number_format($Variables->DebtPayment2, 2, '.', ',');
	}
	
	if ($Variables->DebtPayment3 < 0)
	{
		$Variables->DebtPayment3 = $Defaults->DebtPayment3;
		$Variables->OutVar["DebtPayment3"] = number_format($Variables->DebtPayment3, 2, '.', ',');
	}
	
	if ($Variables->DebtPayment4 < 0)
	{
		$Variables->DebtPayment4 = $Defaults->DebtPayment4;
		$Variables->OutVar["DebtPayment4"] = number_format($Variables->DebtPayment4, 2, '.', ',');
	}
	
	if ($Variables->DebtPayment5 < 0)
	{
		$Variables->DebtPayment5 = $Defaults->DebtPayment5;
		$Variables->OutVar["DebtPayment5"] = number_format($Variables->DebtPayment5, 2, '.', ',');
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

function showForm() {
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

    $MonthlyIncome = $Variables->Income + $Variables->Income2 + $Variables->Income3 + $Variables->Income4 + $Variables->Income5;
	$MonthlyDebtPayments = $Variables->DebtPayment + $Variables->DebtPayment2 + $Variables->DebtPayment3 + $Variables->DebtPayment4 + $Variables->DebtPayment5;

	$EstMonthlyPayment = $Variables->FrontRatio * $MonthlyIncome / 100;
	
	$Amount = Calc::LoanAmount($EstMonthlyPayment, $Variables->Interest, $Variables->Length);
	
	$Offset = -$Variables->BackRatio;
	$BackValue = ($Variables->BackRatio + 0.25)* $MonthlyIncome / 100;
    $FrontValue = ($Variables->FrontRatio + 0.25)* $MonthlyIncome / 100 ; 

	$MonthlyTotal = 0;

    while ((( ($MonthlyTotal + $MonthlyDebtPayments) < $BackValue) && ($MonthlyTotal < $FrontValue) )) {
        $Offset += 0.01;
        $MonthlyPayment = ($Variables->FrontRatio + $Offset) * $MonthlyIncome / 100; 

        $Amount = Calc::LoanAmount($MonthlyPayment, $Variables->Interest, $Variables->Length);
        
        // Calculating DownPayment Value and Home Value based on
        // the estimated amount to be financed.
		if ($Variables->DownPaymentSel == '0')
		{
			$DownPaymentValue = $Variables->DownPayment;
			$HomeValue        = $Amount + $DownPaymentValue;
		}
		else 
		{
			$HomeValue        = $Amount / (1 - $Variables->DownPayment/100);
			$DownPaymentValue = $HomeValue - $Amount;
		}
		
		// Calculating an estimated property taxes based on previously
		// calculated Home Value.
		if ($Variables->PropertyTaxesSel == '0')
			$PropertyTaxes = $Variables->PropertyTaxes;
		else 
			$PropertyTaxes = $Variables->PropertyTaxes * $HomeValue / 100;
			
		// Calculating an estimated annual Insurance.
		if ($Variables->InsuranceSel == '0')
			$Insurance = $Variables->Insurance;
		else
			$Insurance = $HomeValue * $Variables->Insurance / 100;
	
		// Calculating an estimated annual PMI value.
		if ($Variables->PMISel == '0')
			$PMI = $Variables->PMI;
		else
			$PMI = $Amount * $Variables->PMI / 100;
	
		// Calculating monthly property taxes, insurance and PMI values.
		$MonthlyTaxes     = $PropertyTaxes / 12;
		$MonthlyInsurance = $Insurance / 12;
		$MonthlyPMI       = $PMI / 12;
		
		// Calculating LoanToValue percentage.
    	$LoanToValue  = $Amount / $HomeValue * 100;

    	// Calculating monthly total payment
        if ($LoanToValue > 80)
    		$MonthlyTotal = $MonthlyPayment + $MonthlyTaxes + $MonthlyInsurance + $MonthlyPMI;
    	else
    		$MonthlyTotal = $MonthlyPayment + $MonthlyTaxes + $MonthlyInsurance;

    	$Offset++;
    }
    
    // Rounding resulting values to the hundreds value.
    $Amount           = 100 * floor($Amount / 100);
    $DownPaymentValue = 100 * floor($DownPaymentValue / 100);
    $HomeValue        = $Amount + $DownPaymentValue;
    
    $ActualFrontRatio = 100 * $MonthlyTotal / $MonthlyIncome;
    $ActualBackRatio  = 100 * ($MonthlyTotal + $MonthlyDebtPayments) / $MonthlyIncome;
	
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
	
	$options = new AmortizationOptions();
	$options->PMI           = $PMI;
	$options->PropertyTaxes = $PropertyTaxes;
	$options->Insurance     = $Insurance;
	$options->PeriodPayment = $MonthlyPayment;
	
	$AmortizationTable = Calc::BuildAmortizationTable($HomeValue, $Amount, $Variables->Interest, $Variables->Length, $options);

	$vars['AmortizationTable'] = $AmortizationTable;
	
	$vars['MonthlyTaxes']     = number_format($MonthlyTaxes,    '2', '.', ',');
	$vars['MonthlyInsurance'] = number_format($MonthlyInsurance,'2', '.', ',');
	$vars['MonthlyPayment']   = number_format($MonthlyPayment,  '2', '.', ',');
	$vars['MonthlyPMI']       = number_format($MonthlyPMI,      '2', '.', ',');
	$vars['MonthsWithPMI']    = $AmortizationTable->TotalPeriodsWithPMI;
	$vars['MonthlyTotal']     = number_format($MonthlyTotal,    '2', '.', ',');
	
	$vars['MonthlyIncome']       = number_format($MonthlyIncome,    '2', '.', ',');
	$vars['MonthlyDebtPayments'] = number_format($MonthlyDebtPayments,    '2', '.', ',');
	
	$vars['ActualFrontRatio'] = number_format($ActualFrontRatio,'0', '.', ',');
	$vars['ActualBackRatio']  = number_format($ActualBackRatio, '0', '.', ',');
	
	$vars['HomeValue']        = number_format($HomeValue,    '2', '.', ',');
	$vars['DownPaymentValue'] = number_format($DownPaymentValue,    '2', '.', ',');
	$vars['Amount']           = number_format($Amount,    '2', '.', ',');
	
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
		$pdf->Cell(190, 10, $lang['Calc4Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(110, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(75, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(110, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['PeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(55, 6, $lang['DownPayment'], 1, 0, 'R', 1, '');
		if ($Variables->DownPaymentSel == 0)
			$pdf->Cell(55, 6, $CalcSettings->Currency . $vars['DownPayment'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(55, 6, $vars['DownPayment'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyPropertyTaxes'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyTaxes'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(55, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(55, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyInsurance'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyInsurance'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(55, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(55, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyPMI'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(55, 6, $lang['EstimatedFrontRatio'], 1, 0, 'R', 1, '');
		$pdf->Cell(55, 6, $vars['FrontRatio'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyTotal'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(55, 6, $lang['EstimatedBackRatio'], 1, 0, 'R', 1, '');
		$pdf->Cell(55, 6, $vars['BackRatio'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyIncome'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyIncome'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['IncomeInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(55, 6, $lang['DebtPaymentInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['MonthlyDebtPayments'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyDebtPayments'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(30, 6, $lang['Income'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['Income'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['AutoLoansPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['DebtPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['ActualFrontRatio'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['ActualFrontRatio'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(30, 6, $lang['Income2'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['Income2'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['StudentLoansPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['DebtPayment2'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['ActualBackRatio'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['ActualBackRatio'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(30, 6, $lang['Income3'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['Income3'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['InstallmentLoansPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['DebtPayment3'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');		
		$pdf->SetTableMode();
		$pdf->Ln();
				
		$pdf->Cell(30, 6, $lang['Income4'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['Income4'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['RevolvingAccountsPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['DebtPayment4'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['DownPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['DownPaymentValue'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(30, 6, $lang['Income5'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['Income5'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['OtherDebtPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['DebtPayment5'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(110, 6, $lang['TaxAndInsuranceInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(55, 6, $lang['AnnualPropertyTaxes'], 1, 0, 'R', 1, '');
		if ($Variables->PropertyTaxesSel == 0)
			$pdf->Cell(55, 6, $CalcSettings->Currency . $vars['PropertyTaxes'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(55, 6, $vars['PropertyTaxes'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(55, 6, $lang['AnnualInsurance'], 1, 0, 'R', 1, '');
		if ($Variables->InsuranceSel == 0)
			$pdf->Cell(55, 6, $CalcSettings->Currency . $vars['Insurance'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(55, 6, $vars['Insurance'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(55, 6, $lang['AnnualPMI'], 1, 0, 'R', 1, '');
		if ($Variables->PMISel == 0)
			$pdf->Cell(55, 6, $CalcSettings->Currency . $vars['PMI'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(55, 6, $vars['PMI'] . '%', 1, 0, 'C', 1, '');
			
		$pdf->Ln();
		$pdf->Ln();
		
		// Calculator's footprint
		$pdf->SetFootprintMode();
		$pdf->MultiCell(190, 4, $PdfSettings->FootPrint);


		$pdf->AddPage();
		$pdf->SetHeaderMode();
		$pdf->Cell(190, 10, $lang['Calc4Title'], 1, 1, 'C', 1, '');

		
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
		
		$content = $smarty->fetch($Variables->Template.'/form4.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>