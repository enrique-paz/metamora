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
	
	if ($Variables->PMI < 0 || ($Variables->PMI > 100 && $Variables->PMISel == 1)) {
		$Variables->PMI = $Defaults->PMI;
		$Variables->PMISel = $Defaults->PMISel;
		$Variables->OutVar['PMI'] = number_format($Variables->PMI, 3, '.', ',');
		$Variables->OutVar['PMISel'] = $Defaults->PMISel;
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
	
	if ($Variables->Interest3 <= 0)
	{
		$Variables->Interest3 = $Defaults->Interest3;
		$Variables->OutVar["Interest3"] = number_format($Variables->Interest3, 3, '.', ',');
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
	
	if ($Variables->Length3 <= 0)
	{
		$Variables->Length3 = $Defaults->Length3;
		$Variables->OutVar["Length3"] = number_format($Variables->Length3, 0, '.', ',');
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
	
	if ($Variables->Points3 < 0)
	{
		$Variables->Points3 = $Defaults->Points3;
		$Variables->OutVar["Points3"] = number_format($Variables->Points3, 3, '.', ',');
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
	
	if ($Variables->Closing3 < 0)
	{
		$Variables->Closing3 = $Defaults->Closing3;
		$Variables->OutVar["Closing3"] = number_format($Variables->Closing3, 2, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;
	
	// Calculating DownPaymentValue, monthly taxes and insurance payments.
	$DownPaymentValue       = $Variables->HomeValue * $Variables->DownPayment / 100;

	$Amount  = $Variables->HomeValue - $DownPaymentValue;
	$Amount2 = 0.8 * $Variables->HomeValue;
	$Amount3 = 0.2 * $Variables->HomeValue - $DownPaymentValue;	

	if ($Variables->PMISel == '0')
		$PMI = $Variables->PMI;
	else
		$PMI = $Amount * $Variables->PMI / 100;

	$MonthlyPMI       = $PMI / 12;
	
	$PointsValue   = $Amount * $Variables->Points / 100;
	$PointsValue2  = $Amount2 * $Variables->Points2 / 100;
	$PointsValue3  = $Amount3 * $Variables->Points3 / 100;
	
	$AmountFinanced  = $Amount;
	$AmountFinanced2 = $Amount2;
	$AmountFinanced3 = $Amount3;
	
	// Calculating an actual monthly payment, including interest during the life of loan
	$MonthlyPayment  = & Calc::PeriodPayment($AmountFinanced, $Variables->Interest, $Variables->Length);
	$MonthlyPayment2 = & Calc::PeriodPayment($AmountFinanced2, $Variables->Interest2, $Variables->Length2);
	$MonthlyPayment3 = & Calc::PeriodPayment($AmountFinanced3, $Variables->Interest3, $Variables->Length3);

	// Calculating LTV ratio in percent.
	$LoanToValue = ($Variables->Amount / $Variables->HomeValue) * 100;

	// If LTV ratio is greater than 80% (i.e. DownPaymentValue is less than 20%), then 
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

    $MonthlyTotal      = $MonthlyPayment + $MonthlyPMI;
    $MonthlyTotal2     = $MonthlyPayment2;
    $MonthlyTotal3     = $MonthlyPayment3;
    $MonthlyTotal2and3 = $MonthlyPayment2 + $MonthlyPayment3;
    
    $TotalClosing      = $PointsValue + $Variables->Closing;
    $TotalClosing2     = $PointsValue2 + $Variables->Closing2;
    $TotalClosing3     = $PointsValue3 + $Variables->Closing3;
    $TotalClosing2and3 = $TotalClosing2 + $TotalClosing3;

    $Upfront      = $TotalClosing + $DownPaymentValue;
    $Upfront2and3 = $TotalClosing2and3 + $DownPaymentValue;
    
	$options = new AmortizationOptions();
	$options->PMI           = $PMI;
	$options->PeriodPayment = $MonthlyPayment;
	
	$AmortizationTable  = Calc::BuildAmortizationTable($Variables->HomeValue, $AmountFinanced, $Variables->Interest, $Variables->Length, $options);
	
	$options = new AmortizationOptions();
	$options->PeriodPayment = $MonthlyPayment2;
	$AmortizationTable2 = Calc::BuildAmortizationTable($Variables->HomeValue, $AmountFinanced2, $Variables->Interest2, $Variables->Length2, $options);
	
	$options = new AmortizationOptions();
	$options->PeriodPayment = $MonthlyPayment3;
	$AmortizationTable3 = Calc::BuildAmortizationTable($Variables->HomeValue, $AmountFinanced3, $Variables->Interest3, $Variables->Length3, $options);
	
	$AmortizationTable2and3 = Calc::ConsolidateTables($AmortizationTable2, $AmortizationTable3);

	$TotalInterestPaid2and3  = $AmortizationTable2->InterestPaid + $AmortizationTable3->InterestPaid;
	$TotalPaymentAmount2and3 = $AmortizationTable2->PaymentAmount + $AmortizationTable3->PaymentAmount;
	
	
	$vars['AmortizationTable']      = $AmortizationTable;
	$vars['AmortizationTable2']     = $AmortizationTable2;
	$vars['AmortizationTable3']     = $AmortizationTable3;
	$vars['AmortizationTable2and3'] = $AmortizationTable2and3;
    
	// Assembling an array for output.
	// Assigning calculated values to the output array.
	$vars['DownPaymentValue']    = number_format($DownPaymentValue,    '2', '.', ',');

	$vars['PointsValue']         = number_format($PointsValue,    '2', '.', ',');
	$vars['PointsValue2']        = number_format($PointsValue2,    '2', '.', ',');
	$vars['PointsValue3']        = number_format($PointsValue3,    '2', '.', ',');

	$vars['TotalClosing']        = number_format($TotalClosing,    '2', '.', ',');
	$vars['TotalClosing2and3']   = number_format($TotalClosing2and3,    '2', '.', ',');

	$vars['Upfront']             = number_format($Upfront,    '2', '.', ',');
	$vars['Upfront2and3']        = number_format($Upfront2and3,    '2', '.', ',');
	
	$vars['AmountFinanced']      = number_format($AmountFinanced,    '2', '.', ',');
	$vars['AmountFinanced2']     = number_format($AmountFinanced2,    '2', '.', ',');
	$vars['AmountFinanced3']     = number_format($AmountFinanced3,    '2', '.', ',');
	
//	$vars['MonthlyTaxes']        = number_format($MonthlyTaxes,    '2', '.', ',');
//	$vars['MonthlyInsurance']    = number_format($MonthlyInsurance,'2', '.', ',');
	$vars['MonthlyPayment']      = number_format($MonthlyPayment,  '2', '.', ',');
	$vars['MonthlyPayment2']     = number_format($MonthlyPayment2,  '2', '.', ',');
	$vars['MonthlyPayment3']     = number_format($MonthlyPayment3,  '2', '.', ',');
	
	$vars['MonthlyPMI']        = number_format($MonthlyPMI,      '2', '.', ',');
	$vars['MonthlyPMI2']       = number_format(0,      '2', '.', ',');
	$vars['MonthlyPMI3']       = number_format(0,      '2', '.', ',');
	
	$vars['TotalPMI']          = $AmortizationTable->TotalPMI;
	$vars['TotalPMI2']         = number_format(0,      '2', '.', ',');
	$vars['TotalPMI3']         = number_format(0,      '2', '.', ',');

	$vars['TotalPaymentAmount']       = number_format($AmortizationTable->PaymentAmount + $AmortizationTable->PMI, '2', '.', ',');
	$vars['TotalPaymentAmount2and3']  = number_format($TotalPaymentAmount2and3,      '2', '.', ',');

	$vars['TotalInterestPaid']        = $AmortizationTable->TotalInterestPaid;
	$vars['TotalInterestPaid2and3']   = number_format($TotalInterestPaid2and3,      '2', '.', ',');
	
	$vars['MonthsWithPMI']     = $AmortizationTable->TotalPeriodsWithPMI;
	$vars['MonthlyTotal']      = number_format($MonthlyTotal,    '2', '.', ',');
	$vars['MonthlyTotal2']     = number_format($MonthlyTotal2,    '2', '.', ',');
	$vars['MonthlyTotal3']     = number_format($MonthlyTotal3,    '2', '.', ',');
	$vars['MonthlyTotal2and3'] = number_format($MonthlyTotal2and3,  '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc10Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(160, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(160, 6, $lang['PropertyInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(160, 6, $lang['AdditionalInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['AnnualPMI'], 1, 0, 'R', 1, '');
		if ($Variables->PMISel == 0)
			$pdf->Cell(80, 6, $CalcSettings->Currency . $vars['PMI'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(80, 6, $vars['PMI'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(80, 6, $lang['DownPayment'], 1, 0, 'R', 1, '');
		if ($Variables->DownPaymentSel == 0)
			$pdf->Cell(80, 6, $CalcSettings->Currency . $vars['DownPayment'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(80, 6, $vars['DownPayment'] . '%', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, ' ', 1, 0, '', 1);
		$pdf->Cell(40, 6, $lang['Standard'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['80PercentLoan'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['SecondLoan'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['Interest2'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['Interest3'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['Length2'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['Length3'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');		
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['Points2'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $vars['Points3'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['ClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['Closing'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['Closing2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['Closing3'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		
		
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(160, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, ' ', 1, 0, '', 1);
		$pdf->Cell(40, 6, $lang['Standard'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['80PercentLoan'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Second'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['PointsValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['PointsValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['PointsValue2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['PointsValue3'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['ClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['Closing'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['Closing2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['Closing3'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['TotalClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalClosing'], 1, 0, 'C', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['TotalClosing2and3'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['DownPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(120, 6, $lang['Currency'] . $vars['DownPaymentValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, $lang['UpfrontCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['Upfront'], 1, 0, 'C', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['Upfront2and3'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, $lang['AmountFinanced'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['AmountFinanced'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['AmountFinanced2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['AmountFinanced3'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['MonthlyPIShort'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['MonthlyPayment2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['MonthlyPayment3'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['MonthsWithPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['MonthsWithPMI'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, '0', 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, '0', 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['MonthlyPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['MonthlyPMI'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . '0.00', 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . '0.00', 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['MonthlyTotal'], 1, 0, 'C', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['MonthlyTotal2and3'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['TotalInterestPaid'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalInterestPaid'], 1, 0, 'C', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['TotalInterestPaid2and3'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(15, 6, ' ');
		$pdf->Cell(40, 6, $lang['TotalPMI'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalPMI'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalPMI2'], 1, 0, 'C', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalPMI3'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(15, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(40, 6, $lang['TotalPaymentAmount'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalPaymentAmount'], 1, 0, 'C', 1, '');
		$pdf->Cell(80, 6, $lang['Currency'] . $vars['TotalPaymentAmount2and3'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		$pdf->Ln();
		
		// Calculator's footprint
		$pdf->SetFootprintMode();
		$pdf->MultiCell(190, 4, $PdfSettings->FootPrint);
		
		$pdf->AddPage();

		// Calculator's header
		$pdf->SetHeaderMode();
		$pdf->Cell(190, 10, $lang['Calc10Title'], 1, 1, 'C', 1, '');
	
		// Schedule's header
		$pdf->SetTableHeaderMode('schedule');
		$pdf->Cell(190, 6, $lang['PaymentSchedule'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(100, 5, $lang['PaymentSchedule'], 1, 0, 'C', 0, '');
		$pdf->Cell(0.3, 5, '' , 1, 0, '', 1);
		$pdf->Cell(89.7, 5, $lang['ConsolidatedSchFor2Loans'], 1, 0, 'C', 0, '');	
		$pdf->SetTableMode();

		$pdf->Ln();
		
		// Schedule's columns headers
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(30, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->Cell(0.3, 5, '' , 1, 0, '', 1);
		$pdf->Cell(29.7, 5, $lang['InterestPaid'],   1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['Principal'],        1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
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
				$pdf->Cell(10, 4, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(30, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(30, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);
				$pdf->Cell(0.5, 4, '' , 1, 0, '', 1);
				
				$period2 = $AmortizationTable2and3->Schedule[$period->Period * 13 - 1];
				
				if ($period2 == null && !$fullBalance2)
				{
					$i = ($period->Period)*13 - 1;
					while($period2 == null)
						$period2 = $AmortizationTable2and3->Schedule[$i--];

					if ($period2->RemainingBalance == 0 || $period2->RemainingBalance == null)
						$fullBalance2 = true;
				} 
				
				$pdf->Cell(29.5, 4, $period2->InterestPaid,     'LR', 0, 'R', $fill);
				$pdf->Cell(30, 4,   $period2->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(30, 4,   $period2->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(30, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['Principal'], 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['Principal'], 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(10, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(30, 5, $AmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable2and3->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable2and3->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(30, 5, $AmortizationTable2and3->TotalRemainingBalance, 1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form10.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>