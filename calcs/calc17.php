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
	
	if ($Variables->Points < 0)
	{
		$Variables->Points = $Defaults->Points;
		$Variables->OutVar["Points"] = number_format($Variables->Points, 3, '.', ',');
	}
	
	if ($Variables->Points2 < 0)
	{
		$Variables->Points2 = $Defaults->Points2;
		$Variables->OutVar["Points2"] = number_format($Variables->Points2, 3, '.', ',');
	}
	
	if ($Variables->Origination < 0)
	{
		$Variables->Origination = $Defaults->Origination;
		$Variables->OutVar["Origination"] = number_format($Variables->Origination, 3, '.', ',');
	}
	
	if ($Variables->Origination2 < 0)
	{
		$Variables->Origination2 = $Defaults->Origination2;
		$Variables->OutVar["Origination2"] = number_format($Variables->Origination2, 3, '.', ',');
	}
	
	if ($Variables->Closing < 0)
	{
		$Variables->Closing = $Defaults->Closing;
		$Variables->OutVar["Closing"] = number_format($Variables->Closing, 2, '.', ',');
	}
	
	if ($Variables->Closing2 < 0)
	{
		$Variables->Closing2 = $Defaults->Closing2;
		$Variables->OutVar["Closing2"] = number_format($Variables->Closing2, 2, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;
	
	$PointsValue  = $Variables->Amount * $Variables->Points / 100;
	$PointsValue2 = $Variables->Amount * $Variables->Points2 / 100;
	
	$OriginationValue  = $Variables->Amount * $Variables->Origination / 100;
	$OriginationValue2 = $Variables->Amount * $Variables->Origination2 / 100;	
	
	$TotalClosingCost  = $PointsValue + $OriginationValue + $Variables->Closing;
	$TotalClosingCost2 = $PointsValue2 + $OriginationValue2 + $Variables->Closing2;

	$AmountFinanced    = $Variables->Amount;
	$AmountFinanced2   = $Variables->Amount;
	
	// Calculating an actual monthly payment, including interest during the life of loan
	$MonthlyPayment = Calc::PeriodPayment($AmountFinanced, $Variables->Interest, $Variables->Length);
	$MonthlyPayment2 = Calc::PeriodPayment($AmountFinanced2, $Variables->Interest2, $Variables->Length2);
	
	$TotalMonthlyPayment     = $MonthlyPayment * $Variables->Length * 12;
	$TotalMonthlyPayment2    = $MonthlyPayment2 * $Variables->Length2 * 12;
	
	$MonthlyPaymentSavings   = $TotalMonthlyPayment2 - $TotalMonthlyPayment;
	if ($MonthlyPaymentSavings < 0)
		$MonthlyPaymentSavings = 0;
		
	$MonthlyPaymentSavings2  = $TotalMonthlyPayment - $TotalMonthlyPayment2;
	if ($MonthlyPaymentSavings2 < 0)
		$MonthlyPaymentSavings2 = 0;

	$AmortizationTable = Calc::BuildAmortizationTable($AmountFinanced, $AmountFinanced, $Variables->Interest, $Variables->Length);
	$AmortizationTable2 = Calc::BuildAmortizationTable($AmountFinanced2, $AmountFinanced2, $Variables->Interest2, $Variables->Length2);

	$vars['AmortizationTable'] = $AmortizationTable;
	$vars['AmortizationTable2'] = $AmortizationTable2;
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['PointsValue']             = number_format($PointsValue,  '2', '.', ',');
	$vars['PointsValue2']            = number_format($PointsValue2,  '2', '.', ',');
	$vars['OriginationValue']        = number_format($OriginationValue,  '2', '.', ',');
	$vars['OriginationValue2']       = number_format($OriginationValue2,  '2', '.', ',');
	$vars['TotalClosingCost']        = number_format($TotalClosingCost,  '2', '.', ',');
	$vars['TotalClosingCost2']       = number_format($TotalClosingCost2,  '2', '.', ',');
	$vars['AmountFinanced']          = number_format($AmountFinanced,  '2', '.', ',');
	$vars['AmountFinanced2']         = number_format($AmountFinanced2,  '2', '.', ',');

	$vars['MonthlyPayment']          = number_format($MonthlyPayment,  '2', '.', ',');
	$vars['MonthlyPayment2']         = number_format($MonthlyPayment2,  '2', '.', ',');
	
	$vars['TotalMonthlyPayment']     = number_format($TotalMonthlyPayment,  '2', '.', ',');
	$vars['TotalMonthlyPayment2']    = number_format($TotalMonthlyPayment2,  '2', '.', ',');
	
	$vars['MonthlyPaymentSavings']   = number_format($MonthlyPaymentSavings,  '2', '.', ',');
	$vars['MonthlyPaymentSavings2']  = number_format($MonthlyPaymentSavings2,  '2', '.', ',');

	if (!empty($Variables->PDFGen))
	{
		$pdf = new PDF('P', 'mm', $PdfSettings->PageSize);
		$pdf->SetFont($PdfSettings->FontName, '', 9);
		$pdf->AllowFooter = true;
		if (strtolower($PdfSettings->PageSize) == 'legal' || strtolower($PdfSettings->PageSize) == 'letter') $pdf->SetLeftMargin(13); else $pdf->SetLeftMargin(10);
		if (strtolower($PdfSettings->PageSize) == 'legal' || strtolower($PdfSettings->PageSize) == 'letter') $pdf->SetRightMargin(13); else $pdf->SetRightMargin(10);
		$pdf->SetCompression(false);
		$pdf->AddPage();
	
		// Calculator's header
		$pdf->SetHeaderMode();
		$pdf->Cell(190, 10, $lang['Calc17Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(90, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(95, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(30, 6, ' ', 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Loan1Info'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Loan2Info'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(35, 6, ' ', 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Loan1Info'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Loan2Info'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		
		$pdf->Cell(30, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(60, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(35, 6, $lang['PointsValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['PointsValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['PointsValue2'], 1, 0, 'C', 1, '');
		$pdf->Ln();	
		
		$pdf->Cell(30, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['Interest2'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(35, 6, $lang['OriginationFees'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['OriginationValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['OriginationValue2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();
		
		$pdf->Cell(30, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Length']  . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['Length2'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(35, 6, $lang['TotalClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalClosingCost'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalClosingCost2'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(30, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['Points2'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(35, 6, $lang['AmountFinanced'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['AmountFinanced'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['AmountFinanced2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();
		
		$pdf->Cell(30, 6, $lang['OriginationFees'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $vars['Origination'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $vars['Origination2'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(35, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyPayment2'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(30, 6, $lang['ClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['Closing'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['Closing2'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(35, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalMonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['TotalMonthlyPayment2'], 1, 0, 'C', 1, '');		
		$pdf->Ln();	
		
		$pdf->Cell(95, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(35, 6, $lang['PaymentSavings'], 1, 0, 'R', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyPaymentSavings'], 1, 0, 'C', 1, '');
		$pdf->Cell(30, 6, $lang['Currency'] . $vars['MonthlyPaymentSavings2'], 1, 0, 'C', 1, '');
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
		$pdf->Cell(85, 5, $lang['Loan1Info'], 1, 0, 'C', 0, '');
		$pdf->Cell(0.5, 5, '' , 1, 0, '', 1);
		$pdf->Cell(74.5, 5, $lang['Loan2Info'], 1, 0, 'C', 0, '');	
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
		
		$content = $smarty->fetch($Variables->Template.'/form17.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>