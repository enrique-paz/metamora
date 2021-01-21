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
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

	// Calculating values
	$PeriodPayment = Calc::PeriodPayment($Variables->Amount, $Variables->Interest, $Variables->Length);
	$TotalPayments = $Variables->Length * 12 * $PeriodPayment;
	
	$OriginationValue = $Variables->Amount * $Variables->Origination / 100;
	$PointsValue = $Variables->Amount * $Variables->Points / 100;
	$TotalClosingCost = $Variables->Closing + $OriginationValue + $PointsValue;
	
	$TotalCostOfLoan = $TotalPayments + $TotalClosingCost;
	
	$thousands = $Variables->Amount / 1000;
	
	$LifetimePaymentPerThousand = $TotalCostOfLoan / $thousands;
	$AnnualPaymentPerThousand   = $LifetimePaymentPerThousand / $Variables->Length;
	$MonthlyPaymentPerThousand  = $AnnualPaymentPerThousand / 12;
	
	$AmortizationTable = Calc::BuildAmortizationTable($Variables->Amount, $Variables->Amount, $Variables->Interest, $Variables->Length);
	
	// Creating an array of output values, formatting variables
	$vars['TotalClosingCost'] = number_format($TotalClosingCost, '2', '.', ',');
	$vars['TotalPayments'] = number_format($TotalPayments, '2', '.', ',');
	$vars['TotalCostOfLoan'] = number_format($TotalCostOfLoan, '2', '.', ',');
	$vars['MonthlyPaymentPerThousand'] = number_format($MonthlyPaymentPerThousand, '2', '.', ',');
	$vars['AnnualPaymentPerThousand'] = number_format($AnnualPaymentPerThousand, '2', '.', ',');
	$vars['LifetimePaymentPerThousand'] = number_format($LifetimePaymentPerThousand, '2', '.', ',');
	
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
		$pdf->Cell(190, 10, $lang['Calc14Title'], 1, 1, 'C', 1, '');
		
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
		$pdf->Cell(55, 6, $lang['TotalClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalClosingCost'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Amount'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['Amount'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['TotalMonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalPayments'], 1, 0, 'C', 1, '');
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TotalCostOfLoan'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalCostOfLoan'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();	
		
		$pdf->Cell(45, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['MonthlyPaymentPerThousand'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['MonthlyPaymentPerThousand'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['AdditionalInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['AnnualPaymentPerThousand'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['AnnualPaymentPerThousand'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['LifetimePaymentPerThousand'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['LifetimePaymentPerThousand'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['OriginationFees'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Origination'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['ClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['Closing'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
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
		
		$content = $smarty->fetch($Variables->Template.'/form14.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>