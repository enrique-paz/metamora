<?php

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
	// Making required variables visible into this function.
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
	
	if ($Variables->PeriodPayment <= 0)
	{
		$Variables->PeriodPayment = $Defaults->PeriodPayment;
		$Variables->OutVar["PeriodPayment"] = number_format($Variables->PeriodPayment, 2, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

	$OriginalPayment = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);
	
	$NewLength = Calc::LoanLength($Variables->Amount, $Variables->Interest, $Variables->PeriodPayment);

	if (!is_nan($NewLength))
	{
		$years  = floor($NewLength);
		$m      = ($NewLength - floor($NewLength));

		$months = ceil(12 * $m);
		
		if ($m < 1/365)
			$months--;

		if ($months == 12)
		{
			$years++;
			$months = 0;
		}

		$vars['Years']  = $years;
		$vars['Months'] = $months;

		$options = new AmortizationOptions();
		$options->PeriodPayment = $Variables->PeriodPayment;

		$AmortizationTable = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length, $options);

		$vars['AmortizationTable'] = $AmortizationTable;
	}
    
	$vars['OriginalPayment']    = number_format($OriginalPayment, '2', '.', ',');

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
		$pdf->Cell(190, 10, $lang['Calc3Title'], 1, 1, 'C', 1, '');
		
		$pdf->SetTableHeaderMode('input');
		$pdf->Cell(90, 6, $lang['InputInfo'], 1, 0, 'C', 1, '');
		$pdf->Cell(5,  6, ' ');
		$pdf->SetTableHeaderMode('result');
		$pdf->Cell(95, 6, $lang['FinancialAnalysis'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['LoanInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['OriginalPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['OriginalPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['NewPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['PeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['NewLength'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['Years'] . ' ' . $lang['YearsShort'] . ' ' . $vars['Months'] . ' ' . $lang['MonthsShort'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();	
		
		$pdf->Cell(45, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['PeriodPayment'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['PeriodPayment'], 1, 0, 'C', 1, '');
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
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();

		$pdf->SetFontSize(7);
		// Schedule table
		$arr = $AmortizationTable->Schedule;
		$fill = false;
		foreach($arr as $period)
		{
			if ($period->Type == 'SubTotal')
			{
				$pdf->Cell(30, 4, ' ');
				$pdf->Cell(10, 4, $period->Period,           'L',  0, 'C', $fill);
				$pdf->Cell(40, 4, $period->InterestPaid,     'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->PrincipalApplied, 'L',  0, 'R', $fill);
				$pdf->Cell(40, 4, $period->RemainingBalance, 'LR', 0, 'R', $fill);

				$pdf->Ln();
				$fill=!$fill;
			} 
		}
		
		// Schedule's columns footers
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableBreakerMode();
		$pdf->Cell(10, 5, $lang['Period'],           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $lang['InterestPaid'],     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['PrincipalApplied'], 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $lang['RemainingBalance'], 1,  0, 'R', 1);
		$pdf->SetTableMode(false);
		$pdf->Ln();
		
		$pdf->Cell(30, 5, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(10, 5, ' ',           1,  0, 'C', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalInterestPaid,     1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalPrincipalApplied, 1,  0, 'R', 1);
		$pdf->Cell(40, 5, $AmortizationTable->TotalRemainingBalance, 1,  0, 'R', 1);
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
		
		$content = $smarty->fetch($Variables->Template.'/form3.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>