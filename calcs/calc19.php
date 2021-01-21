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
	
	if ($Variables->PeriodRent <= 0)
	{
		$Variables->PeriodRent = $Defaults->PeriodRent;
		$Variables->OutVar["PeriodRent"] = number_format($Variables->PeriodRent, 2, '.', ',');
	}
	
	if ($Variables->AnnualRentIncrease <= 0)
	{
		$Variables->AnnualRentIncrease = $Defaults->AnnualRentIncrease;
		$Variables->OutVar["AnnualRentIncrease"] = number_format($Variables->AnnualRentIncrease, 3, '.', ',');
	}
	
	if ($Variables->HomeValue <= 0)
	{
		$Variables->HomeValue = $Defaults->HomeValue;
		$Variables->OutVar["HomeValue"] = number_format($Variables->HomeValue, 2, '.', ',');
	}
	
	if ($Variables->AnnualMaintanance < 0)
	{
		$Variables->AnnualMaintanance = $Defaults->AnnualMaintanance;
		$Variables->OutVar["AnnualMaintanance"] = number_format($Variables->AnnualMaintanance, 2, '.', ',');
	}
	
	if ($Variables->AnnualAppreciation < 0)
	{
		$Variables->AnnualAppreciation = $Defaults->AnnualAppreciation;
		$Variables->OutVar["AnnualAppreciation"] = number_format($Variables->AnnualAppreciation, 3, '.', ',');
	}
	
	if ($Variables->YearsBeforeSell <= 0)
	{
		$Variables->YearsBeforeSell = $Defaults->YearsBeforeSell;
		$Variables->OutVar["YearsBeforeSell"] = number_format($Variables->YearsBeforeSell, 0, '.', ',');
	}
	
	if ($Variables->SellingCost < 0)
	{
		$Variables->SellingCost = $Defaults->SellingCost;
		$Variables->OutVar["SellingCost"] = number_format($Variables->SellingCost, 3, '.', ',');
	}
	
	if ($Variables->Amount <= 0)
	{
		$Variables->Amount = $Defaults->Amount;
		$Variables->OutVar["Amount"] = number_format($Variables->Amount, 2, '.', ',');
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
	
	if ($Variables->Taxes <= 0)
	{
		$Variables->Taxes = $Defaults->Taxes;
		$Variables->OutVar["Taxes"] = number_format($Variables->Taxes, 3, '.', ',');
	}
	
	if ($Variables->PropertyTaxes < 0 || ($Variables->PropertyTaxes > 100 && $Variables->PropertyTaxesSel == 1)) {
		$Variables->PropertyTaxes = $Defaults->PropertyTaxes;
		$Variables->PropertyTaxesSel = $Defaults->PropertyTaxesSel;
		$Variables->OutVar['PropertyTaxes'] = number_format($Variables->PropertyTaxes, 3, '.', ',');
		$Variables->OutVar['PropertyTaxesSel'] = $Defaults->PropertyTaxesSel;
	}
	
	if ($Variables->Insurance < 0 || ($Variables->Insurance > 100 && $Variables->InsuranceSel == 1)) {
		$Variables->Insurance = $Defaults->Insurance;
		$Variables->InsuranceSel = $Defaults->InsuranceSel;
		$Variables->OutVar['Insurance'] = number_format($Variables->Insurance, 3, '.', ',');
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

	$DownPayment       = $Variables->HomeValue - $Variables->Amount;
	$PointsValue = $Variables->Points * $Variables->Amount / 100;

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
		$PMI = ($Variables->Amount) * $Variables->PMI / 100;

	$PeriodTaxes     = $PropertyTaxes / 12;
	$PeriodInsurance = $Insurance / 12;
	$PeriodPMI       = $PMI / 12;

	// Calculating LTV ratio in percent.
	$LoanToValue = ($Variables->Amount / $Variables->HomeValue) * 100;

	// If LTV ratio is greater than 80% (i.e. downpayment is less than 20%), then 
	// PMI (Personal Mortgage Insurance) must be applied. 
    if ($LoanToValue > 80) {
        $vars['PeriodPMI']   = number_format($PeriodPMI,   '2', '.', ',');
        $vars['LoanToValue'] = number_format($LoanToValue, '2', '.', ',');
    }
	else
	{
		$PeriodPMI  = 0;
		$PMI        = 0;
	}

	$options = new AmortizationOptions();
	$options->PMI           = $PMI;
	$options->PropertyTaxes = $PropertyTaxes;
	$options->Insurance     = $Insurance;
	$options->PaidPeriods   = $Variables->YearsBeforeSell * 12;
	$AmortizationTable2 = Calc::BuildAmortizationTable($Variables->HomeValue, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

	$TotalTaxes         = $PropertyTaxes * $Variables->YearsBeforeSell;
	$TotalInsurance     = $Insurance * $Variables->YearsBeforeSell;
	$TotalPMI2          = $AmortizationTable2->PMI;
	$TotalTaxesAndInsurance2 = $TotalTaxes + $TotalInsurance;
	$TotalMaintanance2  = $Variables->AnnualMaintanance * $Variables->YearsBeforeSell;
	
	// Calculating an actual Period payment, including interest during the life of loan
	$PeriodPayment2 = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);

	$i = $Variables->AnnualRentIncrease/100;
	$TotalPaymentAmount   = 12 * $Variables->PeriodRent * ((pow(1+$i, $Variables->YearsBeforeSell) -1) / ($i));
	$TotalPaymentAmount2  = 12 * $Variables->YearsBeforeSell * $PeriodPayment2 + $TotalTaxesAndInsurance2 + $TotalMaintanance2 + $TotalPMI2;

	$AveragePeriodPayment  = $TotalPaymentAmount / 12 / $Variables->YearsBeforeSell;
	$AveragePeriodPayment2 = $TotalPaymentAmount2 / 12 / $Variables->YearsBeforeSell;

	$PeriodRentSavings  = $AveragePeriodPayment2 - $AveragePeriodPayment;
	$TotalRentSavings   = $PeriodRentSavings * $Variables->YearsBeforeSell * 12 - $TaxSavings2;

	$TaxSavings2 = $Variables->Taxes / 100 * ($TotalTaxes + $PointsValue);

	$HouseAppreciationValue = $Variables->HomeValue * (pow(1+$Variables->AnnualAppreciation / 100, $Variables->YearsBeforeSell));
	$ProceedsMinusCost      = $HouseAppreciationValue * (1 - ($Variables->SellingCost / 100));
	
	$LoanBalance = $AmortizationTable2->RemainingBalance;

	$EquityAppreciation     = $ProceedsMinusCost - $LoanBalance;
	$HomePurchaseBenefits   = $EquityAppreciation - $TotalRentSavings;

	$vars['AmortizationTable2'] = $AmortizationTable2;
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['TotalTaxesAndInsurance2'] = number_format($TotalTaxesAndInsurance2,    '2', '.', ',');
	$vars['TotalPMI2']               = number_format($TotalPMI2,    '2', '.', ',');
	$vars['TotalMaintanance2']       = number_format($TotalMaintanance2,    '2', '.', ',');
	$vars['TotalPaymentAmount']      = number_format($TotalPaymentAmount,    '2', '.', ',');
	$vars['TotalPaymentAmount2']     = number_format($TotalPaymentAmount2,    '2', '.', ',');
	$vars['AveragePeriodPayment']    = number_format($AveragePeriodPayment,    '2', '.', ',');
	$vars['AveragePeriodPayment2']   = number_format($AveragePeriodPayment2,    '2', '.', ',');
	$vars['PeriodRentSavings']       = number_format($PeriodRentSavings,    '2', '.', ',');
	$vars['TaxSavings2']             = number_format($TaxSavings2,    '2', '.', ',');
	$vars['TotalRentSavings']        = number_format($TotalRentSavings,    '2', '.', ',');
	$vars['HouseAppreciationValue']  = number_format($HouseAppreciationValue,    '2', '.', ',');
	$vars['ProceedsMinusCost']       = number_format($ProceedsMinusCost,    '2', '.', ',');
	$vars['LoanBalance']             = number_format($LoanBalance,    '2', '.', ',');
	$vars['EquityAppreciation']      = number_format($EquityAppreciation,    '2', '.', ',');
	$vars['HomePurchaseBenefits']    = number_format($HomePurchaseBenefits,    '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc19Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(90, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(95, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['RentInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, ' ', 1, 0, 'C', 1);
		$pdf->Cell(25, 6, $lang['Rent'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Buy'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['PeriodRent'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['PeriodRent'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['TaxesAndInsurance'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . '0.00', 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalTaxesAndInsurance2'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['AnnualRentIncrease'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['AnnualRentIncrease'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['TotalPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . '0.00', 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalPMI2'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['PropertyInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['TotalMaintanance'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . '0.00', 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalMaintanance2'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['TotalPaymentAmount'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalPaymentAmount'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TotalPaymentAmount2'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['AnnualMaintanance'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['AnnualMaintanance'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['AveragePeriodPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['AveragePeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['AveragePeriodPayment2'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['AnnualAppreciation'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['AnnualAppreciation'] . ' %' , 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['PeriodRentSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['PeriodRentSavings'], 1, 0, 'C', 1, '');
		$pdf->Ln();
			
		$pdf->Cell(45, 6, $lang['YearsBeforeSell'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['YearsBeforeSell'] . ' ' .$lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['TaxSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . '0.00', 1, 0, 'C', 1, '');
		$pdf->Cell(25, 6, $lang['Currency'] . $vars['TaxSavings2'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['SellingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['SellingCost'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['TotalRentSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['TotalRentSavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['HouseAppreciationValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['HouseAppreciationValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['ProceedsMinusCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['ProceedsMinusCost'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['LoanBalance'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['LoanBalance'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(45, 6, $lang['EquityAppreciation'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['EquityAppreciation'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(45, 6, $lang['HomePurchaseBenefits'], 1, 0, 'R', 1, '');
		$pdf->Cell(50, 6, $lang['Currency'] . $vars['HomePurchaseBenefits'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['TaxAndInsuranceInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
			
		$pdf->Cell(45, 6, $lang['YourTaxRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Taxes'] . ' %', 1, 0, 'C', 1, '');
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
		$pdf->Cell(30, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['PMI'],              1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->SetFontSize(7);

		// Schedule table
		$arr = $AmortizationTable2->Schedule;
		$fill = false;
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(30, 5, ' ');
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
		$pdf->Cell(30, 5, $AmortizationTable2->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable2->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable2->TotalPMI,              1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable2->TotalRemainingBalance, 1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form19.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>