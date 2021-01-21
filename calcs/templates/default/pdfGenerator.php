<?

define('FPDF_FONTPATH', 'libs/font/');

class PDF extends FPDF 
{

	var $AllowFooter = false;
	
	function Header()
	{
		global $PdfSettings, $Variables;
		$this->SetNormalFont();

		$width = 190;
		switch (strtolower($this->format))
		{
			case 'legal':
				$left  = 13;
				$right = 203;
				$bottom = 332;
			case 'letter':
				$left = 13;
				$right = 203;
				$bottom = 0;
				break;
			case 'a4':
				$left = 10;
				$right = 200;
				$bottom = 274;
				break;
		}
	
		$this->Cell($width, 4, $PdfSettings->Title1, 0, 0, 'R');
		$this->Ln();
		$this->Cell($width, 4, $PdfSettings->Title2, 0, 0, 'R');
		$this->Ln();
		$this->Cell($width, 4, $PdfSettings->TitleURL, 0, 0, 'R', 0, $PdfSettings->URL);
		if (file_exists('templates/' . $Variables->Template . '/images/logo.png'))
			$this->Image('templates/' . $Variables->Template . '/images/logo.png', $left, 8, 0, 14, '', $PdfSettings->URL); 
		$this->SetDrawColor(0, 0, 0);
		$this->Line($left, 23, $right, 23);
		$this->Ln(7);
	}
	
	function Footer()
	{
		if ($this->AllowFooter && strtolower($this->format) != 'letter')
		{
			global $PdfSettings, $Variables;
			
			$width = 190;
			switch (strtolower($this->format))
			{
				case 'legal':
					$left  = 13;
					$right = 203;
					$bottom = 332;
					break;
				case 'letter':
					$left = 13;
					$right = 203;
					$bottom = 0;
					break;
				case 'a4':
					$left = 10;
					$right = 200;
					$bottom = 274;
					break;
			}
			
			$this->SetDrawColor(0, 0, 0); 
			$this->Line($left, $bottom, $right, $bottom);
			$this->SetNormalFont();
			$this->SetY(-22);
			$this->Cell($width, 4, $PdfSettings->Title1, 0, 0, 'R');
			$this->Ln();
			$this->Cell($width, 4, $PdfSettings->Title2, 0, 0, 'R');
			$this->Ln();
			$this->Cell($width, 4, $PdfSettings->TitleURL, 0, 0, 'R', 0, $PdfSettings->URL);
			if (file_exists('templates/' . $Variables->Template . '/images/logo.png'))
				$this->Image('templates/' . $Variables->Template . '/images/logo.png', $left, $bottom + 2, 0, 14, '', $PdfSettings->URL); 
			//$this->Ln(10);
		}
	}
	
	function SetNormalFont()
	{
		global $PdfSettings;
		$this->SetFontSize(10);
		$this->SetTextColor(
			hexdec(substr($PdfSettings->TextColor, 0, 2)),
			hexdec(substr($PdfSettings->TextColor, 2, 2)),
			hexdec(substr($PdfSettings->TextColor, 4, 2))
			);
	}

	function SetHeaderMode()
	{
		global $PdfSettings;
		$this->SetFont($PdfSettings->FontName, 'B', 16);
		$this->SetTextColor(
			hexdec(substr($PdfSettings->HeaderTextColor, 0, 2)),
			hexdec(substr($PdfSettings->HeaderTextColor, 2, 2)),
			hexdec(substr($PdfSettings->HeaderTextColor, 4, 2))
			);
			
		$this->SetFillColor(
			hexdec(substr($PdfSettings->HeaderBackground, 0, 2)),
			hexdec(substr($PdfSettings->HeaderBackground, 2, 2)),
			hexdec(substr($PdfSettings->HeaderBackground, 4, 2))
			);
			
		$this->SetDrawColor(
			hexdec(substr($PdfSettings->HeaderBorderColor, 0, 2)),
			hexdec(substr($PdfSettings->HeaderBorderColor, 2, 2)),
			hexdec(substr($PdfSettings->HeaderBorderColor, 4, 2))
			);
	}
	
	function SetTableHeaderMode($type)
	{
		global $PdfSettings;
		$this->SetFont($PdfSettings->FontName, 'B', 11);
		
		switch ($type)
		{
			case 'input':
				$textColor = $PdfSettings->InputTableHeaderTextColor;
				$backgroundColor = $PdfSettings->InputTableHeaderBackground;
				$borderColor = $PdfSettings->InputTableHeaderBackground;
				break;
			case 'result':
				$textColor = $PdfSettings->ResultTableHeaderTextColor;
				$backgroundColor = $PdfSettings->ResultTableHeaderBackground;
				$borderColor = $PdfSettings->ResultTableHeaderBackground;
				break;
			case 'schedule':
				$textColor = $PdfSettings->ScheduleTableHeaderTextColor;
				$backgroundColor = $PdfSettings->ScheduleTableHeaderBackground;
				$borderColor = $PdfSettings->ScheduleTableHeaderBackground;
				break;
			default:
				echo 'Errorneous header type';
				return;
		}
		
		$this->SetTextColor(
			hexdec(substr($textColor, 0, 2)),
			hexdec(substr($textColor, 2, 2)),
			hexdec(substr($textColor, 4, 2))
			);
			
		$this->SetFillColor(
			hexdec(substr($backgroundColor, 0, 2)),
			hexdec(substr($backgroundColor, 2, 2)),
			hexdec(substr($backgroundColor, 4, 2))
			);
			
		$this->SetDrawColor(
			hexdec(substr($borderColor, 0, 2)),
			hexdec(substr($borderColor, 2, 2)),
			hexdec(substr($borderColor, 4, 2))
			);
	}
	
	function SetCaptionMode()
	{
		$this->SetTableMode(true);
	}
	
	function SetTableMode($bold = false)
	{
		global $PdfSettings;
		$this->SetFont($PdfSettings->FontName, ($bold) ? 'B' : '', 9);
		$this->SetTextColor(
			hexdec(substr($PdfSettings->TableTextColor, 0, 2)),
			hexdec(substr($PdfSettings->TableTextColor, 2, 2)),
			hexdec(substr($PdfSettings->TableTextColor, 4, 2))
			);
			
		$this->SetFillColor(
			hexdec(substr($PdfSettings->TableBackground, 0, 2)),
			hexdec(substr($PdfSettings->TableBackground, 2, 2)),
			hexdec(substr($PdfSettings->TableBackground, 4, 2))
			);
			
		$this->SetDrawColor(
			hexdec(substr($PdfSettings->TableBorderColor, 0, 2)),
			hexdec(substr($PdfSettings->TableBorderColor, 2, 2)),
			hexdec(substr($PdfSettings->TableBorderColor, 4, 2))
			);
	}
	
	function SetTableBreakerMode()
	{
		global $PdfSettings;
		$this->SetFont($PdfSettings->FontName, 'B');
		$this->SetTextColor(
			hexdec(substr($PdfSettings->TableTextColor, 0, 2)),
			hexdec(substr($PdfSettings->TableTextColor, 2, 2)),
			hexdec(substr($PdfSettings->TableTextColor, 4, 2))
			);
			
		$this->SetFillColor(
			hexdec(substr($PdfSettings->TableBreakBackground, 0, 2)),
			hexdec(substr($PdfSettings->TableBreakBackground, 2, 2)),
			hexdec(substr($PdfSettings->TableBreakBackground, 4, 2))
			);
			
		$this->SetDrawColor(
			hexdec(substr($PdfSettings->TableBreakBackground, 0, 2)),
			hexdec(substr($PdfSettings->TableBreakBackground, 2, 2)),
			hexdec(substr($PdfSettings->TableBreakBackground, 4, 2))
			);
	}
	
	function SetFootprintMode()
	{
		global $PdfSettings;
		$this->SetFont($PdfSettings->FontName, '', 6);
		$this->SetTextColor(200, 200, 200);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(255, 255, 255);
	}
}
?>