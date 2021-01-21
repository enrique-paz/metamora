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
	
	if ($Variables->Closing < 0)
	{
		$Variables->Closing = $Defaults->Closing;
		$Variables->OutVar["Closing"] = number_format($Variables->Closing, 2, '.', ',');
	}
	
	if ($Variables->PropertyTaxes < 0)
	{
		$Variables->PropertyTaxes = $Defaults->PropertyTaxes;
		$Variables->OutVar["PropertyTaxes"] = number_format($Variables->PropertyTaxes, 3, '.', ',');
	}
	
	if ($Variables->DebtAmount <= 0)
	{
		$Variables->DebtAmount = $Defaults->DebtAmount;
		$Variables->OutVar["DebtAmount"] = number_format($Variables->DebtAmount, 2, '.', ',');
	}
	
	if ($Variables->DebtAmount2 < 0)
	{
		$Variables->DebtAmount2 = $Defaults->DebtAmount2;
		$Variables->OutVar["DebtAmount2"] = number_format($Variables->DebtAmount2, 2, '.', ',');
	}
	
	if ($Variables->DebtAmount3 < 0)
	{
		$Variables->DebtAmount3 = $Defaults->DebtAmount3;
		$Variables->OutVar["DebtAmount3"] = number_format($Variables->DebtAmount3, 2, '.', ',');
	}
	
	if ($Variables->DebtAmount4 < 0)
	{
		$Variables->DebtAmount4 = $Defaults->DebtAmount4;
		$Variables->OutVar["DebtAmount4"] = number_format($Variables->DebtAmount4, 2, '.', ',');
	}
	
	if ($Variables->DebtAmount5 < 0)
	{
		$Variables->DebtAmount5 = $Defaults->DebtAmount5;
		$Variables->OutVar["DebtAmount5"] = number_format($Variables->DebtAmount5, 2, '.', ',');
	}
	
	if ($Variables->DebtPayment <= 0)
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
	
	if ($Variables->DebtInterest <= 0)
	{
		$Variables->DebtInterest = $Defaults->DebtInterest;
		$Variables->OutVar["DebtInterest"] = number_format($Variables->DebtInterest, 3, '.', ',');
	}
	
	if ($Variables->DebtInterest2 < 0)
	{
		$Variables->DebtInterest2 = $Defaults->DebtInterest2;
		$Variables->OutVar["DebtInterest2"] = number_format($Variables->DebtInterest2, 3, '.', ',');
	}
	
	if ($Variables->DebtInterest3 < 0)
	{
		$Variables->DebtInterest3 = $Defaults->DebtInterest3;
		$Variables->OutVar["DebtInterest3"] = number_format($Variables->DebtInterest3, 3, '.', ',');
	}
	
	if ($Variables->DebtInterest4 < 0)
	{
		$Variables->DebtInterest4 = $Defaults->DebtInterest4;
		$Variables->OutVar["DebtInterest4"] = number_format($Variables->DebtInterest4, 3, '.', ',');
	}
	
	if ($Variables->DebtInterest5 < 0)
	{
		$Variables->DebtInterest5 = $Defaults->DebtInterest5;
		$Variables->OutVar["DebtInterest5"] = number_format($Variables->DebtInterest5, 3, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;
	
    $TotalClosing      = $Variables->Closing;
    
    $DebtValue         = $Variables->DebtAmount + 
    					$Variables->DebtAmount2 + 
    					$Variables->DebtAmount3 + 
    					$Variables->DebtAmount4 + 
    					$Variables->DebtAmount5;
    
    $DebtPaymentAmount = $Variables->DebtPayment + 
    					$Variables->DebtPayment2 + 
    					$Variables->DebtPayment3 + 
    					$Variables->DebtPayment4 + 
    					$Variables->DebtPayment5;
    
    $DebtInterestRate = $Variables->DebtAmount * $Variables->DebtInterest + 
    					$Variables->DebtAmount2 * $Variables->DebtInterest2 + 
    					$Variables->DebtAmount3 * $Variables->DebtInterest3 +
    					$Variables->DebtAmount4 * $Variables->DebtInterest4 + 
    					$Variables->DebtAmount5 * $Variables->DebtInterest5;
    
    $DebtInterestRate = $DebtInterestRate / $DebtValue;
    
    $DebtLength       = Calc::LoanLength($DebtValue, $DebtInterestRate, $DebtPaymentAmount);
    
    $DebtYears        = floor($DebtLength);
    $DebtMonths       = ceil(($DebtLength - $DebtYears) * 12);
    
    if ($DebtMonths == 12)
    {
    	$DebtMonths = 0;
    	$DebtYears++;
    }
    
    $LoanYears        = floor($Variables->Length);
    $LoanMonths       = ceil(($Variables->Length - $LoanYears) * 12);
    
    if ($LoanMonths == 12)
    {
    	$LoanMonths = 0;
    	$LoanYears++;
    }
    
    // Calculating an additional loan payment
	$LoanPaymentAmount    = Calc::PeriodPayment($DebtValue, $Variables->Interest, $Variables->Length);
    
    // Total payment amount
    $TotalDebtPayment     = $DebtPaymentAmount * $DebtLength * 12;
    $TotalLoanPayment     = $LoanPaymentAmount * $Variables->Length * 12;
    
    // Total interest paid
    $DebtInterestPaid     = $TotalDebtPayment - $DebtValue;
    $LoanInterestPaid     = $TotalLoanPayment - $DebtValue;
    
    $TotalLoanInterest    = $LoanInterestPaid;
    if ($TotalLoanInterest < 0)
    	$TotalLoanInterest = 0;
    
	$LoanTaxSavings      = ($TotalLoanInterest * $Variables->Taxes / 100) / $Variables->Length;
	
	$AmortizationTable = Calc::BuildAmortizationTable($DebtValue, $DebtValue, $Variables->Interest, $Variables->Length);
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['DebtValue']             = number_format($DebtValue,  '2', '.', ',');
	
	$vars['DebtPaymentAmount']     = number_format($DebtPaymentAmount,  '2', '.', ',');
	$vars['LoanPaymentAmount']     = number_format($LoanPaymentAmount,  '2', '.', ',');

	$vars['DebtInterestRate']      = number_format($DebtInterestRate,  '2', '.', ',');
	$vars['LoanInterestRate']      = number_format($Variables->Interest,  '2', '.', ',');

	$vars['TotalDebtPayment']      = number_format($TotalDebtPayment,  '2', '.', ',');
	$vars['TotalLoanPayment']      = number_format($TotalLoanPayment,  '2', '.', ',');
	
	$vars['DebtYears']             = number_format($DebtYears,  '0', '.', ',');
	$vars['DebtMonths']            = number_format($DebtMonths,  '0', '.', ',');
	
	$vars['LoanYears']             = number_format($LoanYears,  '0', '.', ',');
	$vars['LoanMonths']            = number_format($LoanMonths,  '0', '.', ',');
	
	$vars['DebtInterestPaid']      = number_format($DebtInterestPaid,  '2', '.', ',');
	$vars['LoanInterestPaid']      = number_format($LoanInterestPaid,  '2', '.', ',');

	$vars['TotalDebtInterest']     = number_format(0,  '2', '.', ',');
	$vars['TotalLoanInterest']     = number_format($TotalLoanInterest,  '2', '.', ',');

	$vars['DebtTaxSavings']        = number_format(0,  '2', '.', ',');
	$vars['LoanTaxSavings']        = number_format($LoanTaxSavings,  '2', '.', ',');
	
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
		$pdf->Cell(190, 10, $lang['Calc8Title'], 1, 1, 'C', 1, '');
		
		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(160, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(160, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(80, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(80, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['ClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['Closing'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['YourTaxRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(80, 6, $vars['Taxes'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, ' ', 1, 0, '', 1);
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, $lang['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Payment'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['InterestShort'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['DebtName'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtAmount'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['DebtInterest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['DebtName2'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtAmount2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtPayment2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['DebtInterest2'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['DebtName3'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtAmount3'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtPayment3'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['DebtInterest3'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['DebtName'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtAmount'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['DebtInterest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['DebtName4'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtAmount4'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtPayment4'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['DebtInterest4'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['DebtName5'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtAmount5'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtPayment5'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['DebtInterest5'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		$pdf->Ln();
	
		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(160, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, ' ', 1, 0, '', 1);
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, $lang['Debt'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['HELOC'], 1, 0, 'C', 1, '');		
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['DebtValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtPaymentAmount'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['LoanPaymentAmount'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['AvgInterestRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['DebtInterestRate'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['LoanInterestRate'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(80, 6, $lang['PayoffTimeline'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['DebtYears'] . ' ' . $lang['YearsShort'] . ' ' . $vars['DebtMonths'] . ' ' . $lang['MonthsShort'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['LoanYears'] . ' ' . $lang['YearsShort'] . ' ' . $vars['LoanMonths'] . ' ' . $lang['MonthsShort'], 1, 0, 'C', 1, '');		
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalDebtPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalLoanPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['TotalDeductibleInterest'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalDebtInterest'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalLoanInterest'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(80, 6, $lang['AvgAnnualTaxSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DebtTaxSavings'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['LoanTaxSavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
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
		
		$content = $smarty->fetch($Variables->Template.'/form8.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>