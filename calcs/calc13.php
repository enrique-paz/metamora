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
	
	if ($Variables->AdditionalPayment <= 0)
	{
		$Variables->AdditionalPayment = $Defaults->AdditionalPayment;
		$Variables->OutVar["AdditionalPayment"] = number_format($Variables->AdditionalPayment, 0, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

	// Calculating values
	$PeriodPayment  = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);
	$PeriodPayment2 = $PeriodPayment + $Variables->AdditionalPayment;
	
	$options = new AmortizationOptions();
	$options->PeriodPayment = $PeriodPayment;
	$AmortizationTable = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);
	
	$options->PeriodPayment = $PeriodPayment2;
	$AmortizationTable2 = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);
	
	$Periods  = $AmortizationTable->TotalPeriods;
	$Periods2 = $AmortizationTable2->TotalPeriods;
	
	$TotalPeriodPayment = $AmortizationTable->PaymentAmount;
	$TotalPeriodPayment2 = $AmortizationTable2->PaymentAmount;
	
	$InterestSavings = $TotalPeriodPayment - $TotalPeriodPayment2;	

	$PeriodsSaved = $Periods - $Periods2;
	
	$Length  = $Variables->Length;
	$Years  = floor($Length);
	$Months = 12 * ($Length - floor($Length));

	if ($Length % $Years < 1 / 24)
		$Months = floor($Months);
	else
		$Months = ceil($Months);

	if ($Months == 12)
	{
		$Years  = $Years++;
		$Months = 0;
	} 
	
	$Length2 = $Periods2  / 12;
	$Years2  = floor($Length2);
	$Months2 = 12 * ($Length2 - floor($Length2));

	if ($Length2 % $Years2 < 1 / 24)
		$Months2 = floor($Months2);
	else
		$Months2 = ceil($Months2);

	if ($Months2 == 12)
	{
		$Years2  = $Years2++;
		$Months2 = 0;
	} 
	
	$Length3 = $PeriodsSaved / 12;
	$YearsSaved  = floor($Length3);
	$MonthsSaved = 12 * ($Length3 - floor($Length3));

	if ($Length3 % $YearsSaved < 1 / 24)
		$MonthsSaved = floor($MonthsSaved);
	else
		$MonthsSaved = ceil($MonthsSaved);

	if ($MonthsSaved == 12)
	{
		$YearsSaved  = $YearsSaved++;
		$MonthsSaved = 0;
	} 	
	
	// Creating an array of output values, formatting variables
	$vars['PeriodPayment'] = number_format($PeriodPayment, '2', '.', ',');
	$vars['PeriodPayment2'] = number_format($PeriodPayment2, '2', '.', ',');
	$vars['TotalPeriodPayment'] = number_format($TotalPeriodPayment, '2', '.', ',');
	$vars['TotalPeriodPayment2'] = number_format($TotalPeriodPayment2, '2', '.', ',');
	$vars['InterestSavings'] = number_format($InterestSavings, '2', '.', ',');
	$vars['Years']   = $Years;
	$vars['Months']  = $Months;
	$vars['Years2']  = $Years2;
	$vars['Months2'] = $Months2;
	$vars['YearsSaved']  = $YearsSaved;
	$vars['MonthsSaved'] = $MonthsSaved;
	
	$vars['AmortizationTable']  = $AmortizationTable;
	$vars['AmortizationTable2'] = $AmortizationTable2;
	
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
		$pdf->Cell(190, 10, $lang['Calc13Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(70, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(115, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, ' ', 1, 0, 'C', 1, '');		
		$pdf->Cell(30, 6, $lang['Standard'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['AdditionalPayment'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(40, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['PeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['PeriodPayment2'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(40, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalPeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalPeriodPayment2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();	
		
		$pdf->Cell(40, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['InterestSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['InterestSavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['AdditionalPayment'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Years'] . ' ' . $lang['YearsShort'] . ' ' . $vars['Months'] . ' ' . $lang['MonthsShort'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['Years2'] . ' ' . $lang['YearsShort'] . ' ' . $vars['Months2'] . ' ' . $lang['MonthsShort'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(40, 6, $lang['AdditionalPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['AdditionalPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TimeSaved'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $vars['YearsSaved'] . ' ' . $lang['YearsShort'] . ' ' . $vars['MonthsSaved'] . ' ' . $lang['MonthsShort'], 1, 0, 'C', 1, '');		
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
		$pdf->Cell(0.3, 5, '' , 1, 0, '', 1);
		$pdf->Cell(74.7, 5, $lang['WithAdditionalPayment'], 1, 0, 'C', 0, '');	
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

		$pdf->SetFontSize(7);
		// Schedule table
		$arr = $AmortizationTable->Schedule;
		$fullBalance2 = false;
		$fill = false;
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
				
				$period2 = $AmortizationTable2->Schedule[$period->Period * 13 - 1];
				
				if ($period2 == null && !$fullBalance2)
				{
					$i = ($period->Period)*13 - 1;
					while($period2 == null)
						$period2 = $AmortizationTable2->Schedule[$i--];

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
		$pdf->Cell(24.5, 5, $AmortizationTable2->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(25, 5, $AmortizationTable2->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(25, 5, $AmortizationTable2->TotalRemainingBalance, 1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form13.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>