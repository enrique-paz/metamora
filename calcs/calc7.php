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
	
	if ($Variables->Points < 0)
	{
		$Variables->Points = $Defaults->Points;
		$Variables->OutVar["Points"] = number_format($Variables->Points, 3, '.', ',');
	}
	
	if ($Variables->SavingsRate < 0)
	{
		$Variables->SavingsRate = $Defaults->SavingsRate;
		$Variables->OutVar["SavingsRate"] = number_format($Variables->SavingsRate, 3, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;
	
	if ($Variables->Points > 0)
		$PointsValue = $Variables->Points * $Variables->Amount / 100;
	else
		$PointsValue = 0;
		
	$MonthlyInvestmentSavings = $PointsValue * $Variables->SavingsRate / 100 / 12;
		
	$AmountFinanced  = $Variables->Amount;
	$AmountFinanced2 = $Variables->Amount;

	$MonthlyPayment  = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);
	$MonthlyPayment2 = Calc::PeriodPayment($AmountFinanced2, $Variables->Interest2, $Variables->Length);
	
	$MonthlyPaymentSavings = $MonthlyPayment - $MonthlyPayment2;
	
	$TrueMonthlySavings = $MonthlyPaymentSavings - $MonthlyInvestmentSavings;
	
	if ($TrueMonthlySavings > 0)
	{
		$BreakEvenLength = $PointsValue / ($TrueMonthlySavings * 12);

		if ($BreakEvenLength > 0)
		{
			$years  = floor($BreakEvenLength);
			$m      = ($BreakEvenLength - floor($BreakEvenLength));
	
			$months = ceil(12 * $m);
	
			if ($months == 12)
			{
				$years++;
				$months = 0;
			}
	
			$vars['BreakEvenYears']  = $years;
			$vars['BreakEvenMonths'] = $months;
		}
	}

	$options = new AmortizationOptions();
	$options->PeriodPayment = $MonthlyPayment;

	$AmortizationTable = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

	$options = new AmortizationOptions();
	$options->PeriodPayment = $MonthlyPayment2;

	$AmortizationTable2 = Calc::BuildAmortizationTable($AmountFinanced2, $AmountFinanced2, $Variables->Interest2, $Variables->Length, $options);

	if ($Variables->ShowTableSel)
	{
		$vars['AmortizationTable']     = $AmortizationTable;
		$vars['AmortizationTable2']    = $AmortizationTable2;
	}
    
	$vars['MonthlyPayment']        = number_format($MonthlyPayment, '2', '.', ',');
	$vars['MonthlyPayment2']       = number_format($MonthlyPayment2, '2', '.', ',');
	
	$vars['AmountFinanced']        = number_format($AmountFinanced, '2', '.', ',');
	$vars['AmountFinanced2']       = number_format($AmountFinanced2, '2', '.', ',');
	
	$vars['PointsValue']           = number_format($PointsValue, '2', '.', ',');
	$vars['MonthlyInvestmentSavings']        = number_format($MonthlyInvestmentSavings, '2', '.', ',');
	$vars['MonthlyPaymentSavings'] = number_format($MonthlyPaymentSavings, '2', '.', ',');
	
	$vars['TrueMonthlySavings']     = number_format($TrueMonthlySavings, '2', '.', ',');

	//$vars['TotalBenefits']         = number_format($TotalBenefits, '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc7Title'], 1, 1, 'C', 1, '');
		
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
		$pdf->Cell(30, 6, $lang['WithoutPoints'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['WithPoints'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();		
		$pdf->Ln();
		
		$pdf->Cell(40, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyPI'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['AmountFinanced'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['AmountFinanced2'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(40, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyPI'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['MonthlyPayment2'], 1, 0, 'C', 1, '');
		$pdf->Ln();	
		
		$pdf->Cell(40, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyPaymentSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['MonthlyPaymentSavings'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(70, 6, $lang['AdditionalInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['PointsValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['PointsValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(40, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');		
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyInvestmentSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['MonthlyInvestmentSavings'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TrueMonthlySavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['TrueMonthlySavings'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(75, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['BreakEven'], 1, 0, 'R', 1, '');
		if ($BreakEvenLength > 0)
			$pdf->Cell(60, 6, $vars['BreakEvenYears'] . ' ' . $lang['Years'] . ' ' . $vars['BreakEvenMonths'] . ' ' . $lang['Months'], 1, 0, 'C', 1, '');
		else  
			$pdf->Cell(60, 6, $lang['BadData'], 1, 0, 'C', 1, '');
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
		$pdf->Cell(85, 5, $lang['WithoutPoints'], 'LR', 0, 'C', 0, '');
		$pdf->Cell(0.3, 5, '' , 1, 0, '', 1);
		$pdf->Cell(74.7, 5, $lang['WithPoints'], 'LR', 0, 'C', 0, '');	
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(25, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(25, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->Cell(0.3, 5, '' , 1, 0, '', 1);
		$pdf->Cell(24.7, 5, $lang['InterestPaid'],   1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form7.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>