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
	
	if ($Variables->Length <= 0)
	{
		$Variables->Length = $Defaults->Length;
		$Variables->OutVar["Length"] = number_format($Variables->Length, 0, '.', ',');
	}
	
	if ($Variables->Taxes <= 0)
	{
		$Variables->Taxes = $Defaults->Taxes;
		$Variables->OutVar["Taxes"] = number_format($Variables->Taxes, 3, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

	$MonthlyPayment  = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);
	$BiWeeklyPayment = $MonthlyPayment * 13 / 12;

	$options = new AmortizationOptions();
	$options->PeriodPayment = $MonthlyPayment;
	$options->Periods       = 12;
	$options->Taxes         = $Variables->Taxes;

	$AmortizationTable = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

	$options = new AmortizationOptions();
	$options->PeriodPayment = $MonthlyPayment / 2;
	$options->Periods       = 26;
	$options->Taxes         = $Variables->Taxes;

	$BiWeeklyAmortizationTable = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

	$BiWeeklyLength        = $BiWeeklyAmortizationTable->TotalPeriods / 26;

	$TotalPayment          = $MonthlyPayment * 12 * $Variables->Length;
	$BiWeeklyTotalPayment  = $BiWeeklyAmortizationTable->PaymentAmount;
	
	$TotalInterest         = $TotalPayment - $Variables->Amount;
	$BiWeeklyTotalInterest = $BiWeeklyTotalPayment - $Variables->Amount;
	$InterestSavings       = $TotalInterest - $BiWeeklyTotalInterest;

	$TaxSavings            = $TotalInterest * $Variables->Taxes / 100;
	$BiWeeklyTaxSavings    = $BiWeeklyTotalInterest * $Variables->Taxes / 100;

	$TaxSavingLosses       = $TaxSavings - $BiWeeklyTaxSavings;

	$TotalBenefits          = $InterestSavings - $TaxSavingLosses;

	$Years  = floor($Variables->Length);
	$Months = ceil(12 * ($Variables->Length - floor($Variables->Length)));

	if ($Months == 12)
	{
		$Years++;
		$Months = 0;
	}

	$vars['Years']  = $Years;
	$vars['Months'] = $Months;

	$BiWeeklyYears  = floor($BiWeeklyLength);
	$BiWeeklyMonths = ceil(12 * ($BiWeeklyLength - floor($BiWeeklyLength)));

	if ($BiWeeklyMonths == 12)
	{
		$BiWeeklyYears++;
		$BiWeeklyMonths = 0;
	}

	$vars['BiWeeklyYears']  = $BiWeeklyYears;
	$vars['BiWeeklyMonths'] = $BiWeeklyMonths;

	$YearsSaved = $Years - $BiWeeklyYears;
	$MonthsSaved = $Months - $BiWeeklyMonths;

	if ($MonthsSaved < 0)
	{
		$YearsSaved--;
		$MonthsSaved = 12 - $BiWeeklyMonths;
	}

	$vars['YearsSaved']  = $YearsSaved;
	$vars['MonthsSaved'] = $MonthsSaved;


	if ($Variables->ShowTableSel)
	{
		$vars['AmortizationTable']         = $AmortizationTable;
		$vars['BiWeeklyAmortizationTable'] = $BiWeeklyAmortizationTable;
	}
    
	$vars['MonthlyPayment']        = number_format($MonthlyPayment, '2', '.', ',');
	$vars['BiWeeklyPayment']       = number_format($BiWeeklyPayment, '2', '.', ',');

	$vars['TotalInterest']         = number_format($TotalInterest, '2', '.', ',');
	$vars['BiWeeklyTotalInterest'] = number_format($BiWeeklyTotalInterest, '2', '.', ',');
	$vars['InterestSavings']       = number_format($InterestSavings, '2', '.', ',');

	$vars['TaxSavings']            = number_format($TaxSavings, '2', '.', ',');
	$vars['BiWeeklyTaxSavings']    = number_format($BiWeeklyTaxSavings, '2', '.', ',');
	$vars['TaxSavingLosses']       = number_format($TaxSavingLosses, '2', '.', ',');

	$vars['TotalBenefits']         = number_format($TotalBenefits, '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc18Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(70, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(115, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, '', 1, 0, '', 1, '');
		$pdf->Cell(30, 6, $lang['Standard'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['BiWeekly'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();		
		$pdf->Ln();
		
		$pdf->Cell(40, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Years'] . ' ' . $lang['YearsShort'] . ' ' . $vars['Months'] . $lang['MonthsShort'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['BiWeeklyYears'] . ' ' . $lang['YearsShort'] . ' ' . $vars['BiWeeklyMonths'] . $lang['MonthsShort'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(40, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TimeSaved'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $vars['YearsSaved'] . ' ' . $lang['YearsShort'] . ' ' . $vars['MonthsSaved'] . $lang['MonthsShort'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();	
		
		$pdf->Cell(40, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['BiWeeklyPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['YourTaxRate'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode();
		$pdf->Cell(55, 6, $lang['TotalInterestPaid'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalInterest'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['BiWeeklyTotalInterest'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(40, 6, $lang['TaxRate'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Taxes'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['InterestSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['InterestSavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->Cell(55, 6, $lang['TaxSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TaxSavings'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['BiWeeklyTaxSavings'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TaxSavingLosses'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['TaxSavingLosses'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TotalBenefits'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['TotalBenefits'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		$pdf->Ln();
		
		// Schedule's header
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(160, 6, $lang['PaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		// Schedule's columns headers
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(85, 5, $lang['Standard'], 1, 0, 'C', 0, '');
		$pdf->Cell(0.5, 5, '' , 1, 0, '', 1);
		$pdf->Cell(74.5, 5, $lang['BiWeekly'], 1, 0, 'C', 0, '');	
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(25, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->Cell(0.5, 5, '' , 1, 0, '', 1);
		$pdf->Cell(24.5, 5, $lang['InterestPaid'],   1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		
		$pdf->SetTableMode(false);
		$pdf->Ln();

		// Schedule table
		$arr = $AmortizationTable->Schedule;
		$fullBalance2 = false;
		$fill = false;
		$pdf->SetFontSize(7);
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(15, 4, ' ');
				$pdf->Cell(10, 4, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(25, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(25, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(25, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);
				$pdf->Cell(0.5, 4, '' , 1, 0, '', 1);
				
				$period2 = $BiWeeklyAmortizationTable->Schedule[($period->Period)*26+$period->Period-1]; 
				
				if ($period2 == null && !$fullBalance2)
				{
					$i = ($period->Period)*27 - 1;
					while($period2 == null)
						$period2 = $BiWeeklyAmortizationTable->Schedule[$i--];

					if ($period2->RemaningBalance == 0 || $period2->RemaningBalance == null)
						$fullBalance2 = true;
				}
				
				$pdf->Cell(24.5, 4, $period2->InterestPaid,     'LR', 0, 'R', $fill);
				$pdf->Cell(25, 4,   $period2->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(25, 4,   $period2->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		$pdf->SetFontSize(9);
				
		// Schedule's columns footers
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(25, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->Cell(0.5, 5, '' , 1, 0, '', 1);
		$pdf->Cell(24.5, 5, $lang['InterestPaid'],   1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(10, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(25, 5, $AmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(25, 5, $AmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(25, 5, $AmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
		$pdf->Cell(0.5, 5, '' , 1, 0, '', 1);
		$pdf->Cell(24.5, 5, $BiWeeklyAmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(25, 5, $BiWeeklyAmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(25, 5, $BiWeeklyAmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form18.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>