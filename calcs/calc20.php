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
		$Variables->OutVar["AdditionalPayment"] = number_format($Variables->AdditionalPayment, 2, '.', ',');
	}
	
	
}

function showForm() {
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;
	
	$options = new AmortizationOptions();
	$options->InterestOnly      = true;
	$AmortizationTable  = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);
	
	$options->PaidPeriods       = $Variables->Length * 12;
	$options->AdditionalPayment = $Variables->AdditionalPayment;
	$options->CalculateEveryPeriodPayment = true;
	$AmortizationTable2 = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

	//$AmortizationTable = new AmortizationTable();
	
	$TotalPeriodPayment  = $Variables->Amount * $Variables->Interest / 100 * $Variables->Length;
	$TotalPeriodPayment2 = $AmortizationTable2->PaymentAmount;
	
	$PaidPeriods  = $Variables->Length * 12;
	$PaidPeriods2 = $AmortizationTable2->Periods;
	
	$AveragePeriodPayment  = $TotalPeriodPayment / $PaidPeriods;
	$AveragePeriodPayment2 = $AmortizationTable2->PaymentAmount / $AmortizationTable2->Periods;
	
	$TotalInterestPaid  = $TotalPeriodPayment;
	$TotalInterestPaid2 = $AmortizationTable2->InterestPaid;
	
	$InterestSavings = $TotalInterestPaid - $TotalInterestPaid2;
	
	$RemainingBalance  = $Variables->Amount;
	$RemainingBalance2 = $AmortizationTable2->RemainingBalance;
	
	$TotalPrincipalPaid = $AmortizationTable2->PrincipalApplied;
	
	$vars['AmortizationTable']  = $AmortizationTable;
	$vars['AmortizationTable2'] = $AmortizationTable2;
	
	$vars['TotalPeriodPayment']    = number_format($TotalPeriodPayment, '2', '.', ',');
	$vars['TotalPeriodPayment2']   = number_format($TotalPeriodPayment2, '2', '.', ',');
	$vars['PaidPeriods']           = number_format($PaidPeriods, '0', '.', ',');
	$vars['PaidPeriods2']          = number_format($PaidPeriods2, '0', '.', ',');
	$vars['AveragePeriodPayment']  = number_format($AveragePeriodPayment, '2', '.', ',');
	$vars['AveragePeriodPayment2'] = number_format($AveragePeriodPayment2, '2', '.', ',');
	$vars['TotalInterestPaid']     = number_format($TotalInterestPaid, '2', '.', ',');
	$vars['TotalInterestPaid2']    = number_format($TotalInterestPaid2, '2', '.', ',');
	$vars['InterestSavings']       = number_format($InterestSavings, '2', '.', ',');
	$vars['RemainingBalance']      = number_format($RemainingBalance, '2', '.', ',');
	$vars['RemainingBalance2']     = number_format($RemainingBalance2, '2', '.', ',');
	$vars['TotalPrincipalPaid']    = number_format($TotalPrincipalPaid, '2', '.', ',');
	
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
		$pdf->Cell(190, 10, $lang['Calc20Title'], 1, 1, 'C', 1, '');
		
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
		$pdf->Cell(30, 6, $lang['InterestOnly'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, 'With Add. Pmt.', 1, 0, 'C', 1, '');
		$pdf->SetTableMode();		
		$pdf->Ln();
		
		$pdf->Cell(40, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyPI'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalPeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalPeriodPayment2'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(40, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthsPaid'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['PaidPeriods'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['PaidPeriods2'], 1, 0, 'C', 1, '');
		$pdf->Ln();	
		
		$pdf->Cell(40, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalPeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalPeriodPayment2'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->Cell(55, 6, $lang['TotalInterestPaid'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalInterestPaid'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalInterestPaid2'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['InterestSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['InterestSavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->Cell(55, 6, $lang['RemainingBalance'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['RemainingBalance'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['RemainingBalance2'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(75, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['EquityAppreciation'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . '0.00', 1, 0, 'C', 1, '');		
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalPrincipalPaid'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln(10);

		// Schedule's header
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(160, 6, $lang['PaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		// Schedule's columns headers
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(85, 5, $lang['InterestOnly'], 1, 0, 'C', 0, '');
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
		
		$content = $smarty->fetch($Variables->Template.'/form20.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>