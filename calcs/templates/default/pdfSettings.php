<?

class PdfSettings
{
	// Size of the page. Available formats: A4 or Legal.
	var $PageSize = 'a4';

	// Font used in the PDF document. ATTENTION! Available fonts are: Arial, Helvetica, Times, Courier. 
	// If you set another font, your document might not show properly on some computers.
	var $FontName = 'Arial';

	// Header and footer strings
	var $Title1 = 'Metamora State Bank';
	var $Title2 = 'Phone : 419-885-1996';
	var $TitleURL = 'URL : http://www.metamorabank.com/';

	// URL for the third header and footer string
	var $URL = 'http://www.metamorabank.com/';


	var $TitleImage = '';
	
	// Footprint text
	var $FootPrint = 'DISCLAIMER: There is NO WARRANTY, expressed or implied, for the accuracy of this information or it\'s applicability to your financial situation. Please consult your own financial advisor.';
	
	// Page-wide colors
	var $BackgroundColor  = 'FFFFFF';
	var $TextColor        = '000000';
	
	// Colors for the tables
	var $TableBackground  = 'F2F2F2';
	var $TableBreakBackground = 'DDDDDD';
	var $TableTextColor   = '000000';
	var $TableBorderColor = 'EAEAEA';
	
	var $InputTableHeaderBackground    = '4E90C9';
	var $InputTableHeaderTextColor     = 'FFFFFF';
	
	var $ResultTableHeaderBackground   = '6EB46C';
	var $ResultTableHeaderTextColor    = 'FFFFFF';
	
	var $ScheduleTableHeaderBackground = '878787';
	var $ScheduleTableHeaderTextColor  = 'FFFFFF';
	
	var $HeaderBackground  = 'FFFFFF';
	var $HeaderTextColor   = 'FF6600';
	var $HeaderBorderColor = 'FFFFFF';
}

$PdfSettings = new PdfSettings();

?>