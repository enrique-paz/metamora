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
	
	if ($Variables->DownPayment < 0 || ($Variables->DownPayment > 100 && $Variables->DownPaymentSel == 1)) {
		$Variables->DownPayment = $Defaults->DownPayment;
		$Variables->DownPaymentSel = $Defaults->DownPaymentSel;
		$Variables->OutVar['DownPayment'] = number_format($Variables->DownPayment, 3, '.', ',');
		$Variables->OutVar['DownPaymentSel'] = $Defaults->DownPaymentSel;
	}
	
	if ($Variables->Origination <= 0)
	{
		$Variables->Origination = $Defaults->Origination;
		$Variables->OutVar["Origination"] = number_format($Variables->Origination, 3, '.', ',');
	}
	
	if ($Variables->Points <= 0)
	{
		$Variables->Points = $Defaults->Points;
		$Variables->OutVar["Points"] = number_format($Variables->Points, 3, '.', ',');
	}
	
	if ($Variables->Closing <= 0)
	{
		$Variables->Closing = $Defaults->Closing;
		$Variables->OutVar["Closing"] = number_format($Variables->Closing, 2, '.', ',');
	}
}

function showForm() 
{
	// Making required variables visible into this function.
	global $Variables, $CalcSettings, $PdfSettings, $Lang;

	$vars = $Variables->OutVar;
	$lang = $Variables->LangVar;

	// Calculating values
	if ($Variables->DownPaymentSel == 1)
		$DownPaymentValue = $Variables->HomeValue * $Variables->DownPayment / 100;
	else 
		$DownPaymentValue = $Variables->DownPayment;

	$AmountFinanced = $Variables->HomeValue - $DownPaymentValue;
		
	$PointsValue = $AmountFinanced * $Variables->Points / 100;
	$OriginationValue = $AmountFinanced * $Variables->Origination / 100;
	$TotalClosingCost = $PointsValue + $OriginationValue + $Variables->Closing;
	
	$MonthlyPayment = Calc::PeriodPayment($AmountFinanced, $Variables->Interest, $Variables->Length);
	
	$ActualAPR = Calc::ActualAPR($AmountFinanced, $TotalClosingCost, $Variables->Interest, $Variables->Length, $MonthlyPayment);
	
	// Creating an array of output values, formatting variables
	$vars['DownPaymentValue'] = number_format($DownPaymentValue, '2', '.', ',');
	$vars['AmountFinanced'] = number_format($AmountFinanced, '2', '.', ',');
	$vars['MonthlyPayment'] = number_format($MonthlyPayment, '2', '.', ',');
	$vars['PointsValue'] = number_format($PointsValue, '2', '.', ',');
	$vars['OriginationValue'] = number_format($OriginationValue, '2', '.', ',');
	$vars['TotalClosingCost'] = number_format($TotalClosingCost, '2', '.', ',');
	$vars['ActualAPR'] = number_format($ActualAPR, '3', '.', ',');
	
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
		$pdf->Cell(190, 10, $lang['Calc12Title'], 1, 1, 'C', 1, '');
		
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
		$pdf->Cell(55, 6, $lang['DownPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['DownPaymentValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['HomeValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $lang['Currency'] . $vars['HomeValue'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['AmountFinanced'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['AmountFinanced'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();

		$pdf->Cell(45, 6, $lang['Interest'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Interest'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['MonthlyPayment'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['MonthlyPayment'], 1, 0, 'C', 1, '');
		$pdf->Ln();	
		
		$pdf->Cell(45, 6, $lang['Length'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Length'] . ' ' . $lang['Years'], 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['PointsValue'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['PointsValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['DownPayment'], 1, 0, 'R', 1, '');
		if ($Variables->DownPaymentSel == 0)
			$pdf->Cell(45, 6, $CalcSettings->Currency . $vars['DownPayment'], 1, 0, 'C', 1, '');
		else 
			$pdf->Cell(45, 6, $vars['DownPayment'] . '%', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->Cell(55, 6, $lang['OriginationFees'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['OriginationValue'], 1, 0, 'C', 1, '');
		$pdf->Ln();
		
		$pdf->SetTableMode(true);
		$pdf->Cell(90, 6, $lang['AdditionalInfo'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['TotalClosingCost'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $lang['Currency'] . $vars['TotalClosingCost'], 1, 0, 'C', 1, '');
		$pdf->SetTableMode();
		$pdf->Ln();
		
		$pdf->Cell(45, 6, $lang['Points'], 1, 0, 'R', 1, '');
		$pdf->Cell(45, 6, $vars['Points'] . ' %', 1, 0, 'C', 1, '');
		$pdf->Cell(5, 6, ' ');
		$pdf->SetTableMode(true);
		$pdf->Cell(55, 6, $lang['ActualAPR'], 1, 0, 'R', 1, '');
		$pdf->Cell(40, 6, $vars['ActualAPR'] . ' %', 1, 0, 'C', 1, '');
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
		
		$content = $smarty->fetch($Variables->Template.'/form12.tpl');
		
		// Displaying form with values or returning content
		if ($CalcSettings->ReturnContent)
			return $content;
		else
			echo $content;
	}
}
?>