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
		$Variables->OutVar["Interest"] = number_format($Variables->Interest, 3, '.', ',');
	}
	
	if ($Variables->Interest2 <= 0)
	{
		$Variables->Interest2 = $Defaults->Interest2;
		$Variables->OutVar["Interest2"] = number_format($Variables->Interest2, 3, '.', ',');
	}
	
	if ($Variables->Length <= 0)
	{
		$Variables->Length = $Defaults->Length;
		$Variables->OutVar["Length"] = number_format($Variables->Length, 0, '.', ',');
	}
	
	if ($Variables->Length2 <= 0)
	{
		$Variables->Length2 = $Defaults->Length2;
		$Variables->OutVar["Length2"] = number_format($Variables->Length2, 0, '.', ',');
	}
	
	if ($Variables->PaidPeriods <= 0)
	{
		$Variables->PaidPeriods = $Defaults->PaidPeriods;
		$Variables->OutVar["PaidPeriods"] = number_format($Variables->PaidPeriods, 0, '.', ',');
	}
	
	if ($Variables->YearsBeforeSell <= 0)
	{
		$Variables->YearsBeforeSell = $Defaults->YearsBeforeSell;
		$Variables->OutVar["YearsBeforeSell"] = number_format($Variables->YearsBeforeSell, 0, '.', ',');
	}
	
	if ($Variables->Points < 0)
	{
		$Variables->Points = $Defaults->Points;
		$Variables->OutVar["Points"] = number_format($Variables->Points, 3, '.', ',');
	}
	
	if ($Variables->Origination < 0)
	{
		$Variables->Origination = $Defaults->Origination;
		$Variables->OutVar["Origination"] = number_format($Variables->Origination, 3, '.', ',');
	}
	
	if ($Variables->Closing < 0)
	{
		$Variables->Closing = $Defaults->Closing;
		$Variables->OutVar["Closing"] = number_format($Variables->Closing, 2, '.', ',');
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
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

	// Total deductible tax rate
	$TotalTaxRate = $Variables->Taxes + $Variables->StateTax;

	// Monthly payment for original loan
	$MonthlyPayment    = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);

	// Calculating balance at the moment of refinance
	$options  = new AmortizationOptions();
	$options->PaidPeriods   = $Variables->PaidPeriods;
	$options->PeriodPayment = $MonthlyPayment;
	$Variables->Amount;
	$Table    = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);
	$InterestBeforeRefinance = $Table->InterestPaid;

	// Original loan balance at refinance
	$BalanceAtRefinance = $Table->RemainingBalance;

	$PointsValue       = $BalanceAtRefinance * $Variables->Points / 100;
	$OriginationValue  = $BalanceAtRefinance * $Variables->Origination / 100;
	$TotalClosingCost  = $PointsValue + $OriginationValue + $Variables->Closing;

	// Amount financed by the new loan
	$AmountFinanced    = $BalanceAtRefinance;

	// Monthly payment for the refinanced loan
	$MonthlyPayment2 = Calc::PeriodPayment($AmountFinanced, $Variables->Interest2, $Variables->Length2);
	
	// Total PITI for both: original and refinanced loans
	$TotalMonthlyPayment     = $MonthlyPayment * $Variables->YearsBeforeSell * 12;
	$TotalMonthlyPayment2    = $MonthlyPayment2 * $Variables->YearsBeforeSell * 12;
	
	// Savings on payments
	$MonthlyPaymentSavings   = $TotalMonthlyPayment - $TotalMonthlyPayment2;
	//if ($MonthlyPaymentSavings < 0)
	//	$MonthlyPaymentSavings = 0;
		

	// Original loan balance at sale
	$options  = new AmortizationOptions();
	$options->PaidPeriods   = $Variables->PaidPeriods + $Variables->YearsBeforeSell * 12;
	$options->PeriodPayment = $MonthlyPayment;
	$AmortizationTable  = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);
	$BalanceAtSale      = $AmortizationTable->RemainingBalance;

	// Refinanced loan balance at sale
	$options  = new AmortizationOptions();
	$options->PaidPeriods   = $Variables->YearsBeforeSell * 12;
	$options->PeriodPayment = $MonthlyPayment2;
	$AmortizationTable2 = Calc::BuildAmortizationTable($AmountFinanced, $AmountFinanced, $Variables->Interest2, $Variables->Length2, $options);
	$BalanceAtSale2     = $AmortizationTable2->RemainingBalance;

	// Calculating interest paid for original and refinanced loans for period AFTER refinance and BEFORE sale
	$InterestPaid   = $AmortizationTable->InterestPaid - $InterestBeforeRefinance;
	$InterestPaid2  = $AmortizationTable2->InterestPaid;

	// Tax savings
	$TaxSavings     = $InterestPaid * $TotalTaxRate / 100;
	$TaxSavings2    = $InterestPaid2 * $TotalTaxRate / 100;

	$TaxSavingsLosses = $TaxSavings - $TaxSavings2;
	$BalanceLosses    = $BalanceAtSale2 - $BalanceAtSale;

	$TotalLosses   = $BalanceLosses + $TaxSavingsLosses;

	$TotalBenefit  = $MonthlyPaymentSavings - $TotalLosses - $TotalClosingCost;

	$vars['AmortizationTable'] = $AmortizationTable;
	$vars['AmortizationTable2'] = $AmortizationTable2;
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['MonthlyPayment']          = number_format($MonthlyPayment,   '2', '.', ',');
	$vars['MonthlyPayment2']         = number_format($MonthlyPayment2,  '2', '.', ',');

	$vars['TotalMonthlyPayment']     = number_format($TotalMonthlyPayment,    '2', '.', ',');
	$vars['TotalMonthlyPayment2']    = number_format($TotalMonthlyPayment2,   '2', '.', ',');
	$vars['MonthlyPaymentSavings']   = number_format($MonthlyPaymentSavings,  '2', '.', ',');

	$vars['InterestPaid']            = number_format($InterestPaid,   '2', '.', ',');
	$vars['InterestPaid2']           = number_format($InterestPaid2,  '2', '.', ',');
	$vars['TaxSavings']              = number_format($TaxSavings,   '2', '.', ',');
	$vars['TaxSavings2']             = number_format($TaxSavings2,  '2', '.', ',');
	$vars['TaxSavingsLosses']        = number_format($TaxSavingsLosses,  '2', '.', ',');

	$vars['PointsValue']             = number_format($PointsValue,  '2', '.', ',');
	$vars['AmountFinanced']          = number_format($AmountFinanced,  '2', '.', ',');
	$vars['BalanceAtRefinance']      = number_format($BalanceAtRefinance,  '2', '.', ',');

	$vars['BalanceAtSale']           = number_format($BalanceAtSale,  '2', '.', ',');
	$vars['BalanceAtSale2']          = number_format($BalanceAtSale2,  '2', '.', ',');
	$vars['BalanceLosses']           = number_format($BalanceLosses,  '2', '.', ',');

	$vars['TotalLosses']             = number_format($TotalLosses,  '2', '.', ',');
	$vars['TotalClosingCost']        = number_format($TotalClosingCost,  '2', '.', ',');
	$vars['TotalBenefit']            = number_format($TotalBenefit,  '2', '.', ',');


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
		$pdf->Cell(190, 10, $lang['Calc6Title'], 1, 1, 'C', 1, '');
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(140, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, ' ', 1, 0, '', 1);
		$pdf->Cell(35, 6, $lang['OriginalLoan'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $lang['RefinancedLoan'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $vars['Interest2'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $vars['Length2'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['MonthsPaid'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $vars['PaidPeriods'] . ' ' . $lang['Months'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, '-', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['YearsBeforeSell'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $vars['YearsBeforeSell'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, '-', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(140, 6, $lang['RefinancingFees'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['OriginationFees'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $vars['Origination'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['ClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['Closing'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(140, 6, $lang['YourTaxRates'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['TaxRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $vars['Taxes'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['StateTaxRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $vars['StateTax'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		$pdf->Ln();
		
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(140, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, ' ', 1, 0, '', 1);
		$pdf->Cell(35, 6, $lang['OriginalLoan'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $lang['RefinancedLoan'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['MonthlyPayment2'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['TotalMonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['TotalMonthlyPayment2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['MonthlyPaymentSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['MonthlyPaymentSavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['TotalInterestPaid'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['InterestPaid'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['InterestPaid2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['TaxSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['TaxSavings'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['TaxSavings2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['TaxSavingLosses'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['TaxSavingsLosses'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['BalanceAtRefinance'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['BalanceAtRefinance'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['PointsValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['PointsValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['AmountReinanced'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['AmountFinanced'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['BalanceAtSale'], 1, 0, 'R', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['BalanceAtSale'], 1, 0, 'C', 1, '');
		$pdf->Cell(35, 6, $lang['Currency'] . $vars['BalanceAtSale2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['BalanceLosses'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['BalanceLosses'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['TotalLosses'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['TotalLosses'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['TotalClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['TotalClosingCost'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(70, 6, $lang['TotalSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['MonthlyPaymentSavings'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['TotalBenefitTxt'], 1, 0, 'R', 1, '');
		$pdf->Cell(70, 6, $lang['Currency'] . $vars['TotalBenefit'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->AddPage();
		
		// Calculator's header
		$pdf->SetHeaderMode();
		$pdf->Cell(190, 10, $lang['Calc6Title'], 1, 1, 'C', 1, '');

		// Schedule's header
		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(140, 6, $lang['OriginalPaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		// Schedule's columns headers
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(20, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->SetFontSize(7);
		// Schedule table
		$arr = $AmortizationTable->Schedule;
		$fullBalance2 = false;
		$fill = false;
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(25, 6, ' ');
				$pdf->Cell(20, 4, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(40, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);
				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(20, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['Principal'], 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(20, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		$pdf->Ln();

		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(25, 6, ' ');
		$pdf->Cell(140, 6, $lang['RefinancedPaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		// Schedule's columns headers
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(20, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->SetFontSize(7);
		// Schedule table
		$arr = $AmortizationTable2->Schedule;
		$fullBalance2 = false;
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(25, 6, ' ');
				$pdf->Cell(20, 4, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(40, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);
				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(20, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['Principal'], 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->Cell(25, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(20, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $AmortizationTable2->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable2->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable2->TotalRemainingBalance, 1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form6.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>