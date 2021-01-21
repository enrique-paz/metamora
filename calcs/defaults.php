<?
class Defaults
{
	// Default mortgage info.
	var $DownPayment   = 10;
	var $DownPayment2  = 1;
	var $Amount        = 250000;
	var $Amount2       = 250000;
	var $Amount3       = 250000;
	var $Interest      = 4.75;
	var $Interest2     = 4.15;
	var $Interest3     = 6.0;
	var $Length        = 30;
	var $Length2       = 30;
	var $Length3       = 15;
	var $PaidPeriods   = 60;
	var $PeriodPayment = 1304.118;
	var $BalloonPayment= 150000;
	var $BalloonLength = 7;
	var $AdditionalPayment = 50;
		  
	var $Points        = 1;
	var $Points2       = 1.5;
	var $Points3       = 1;
	var $Closing       = 1200;
	var $Closing2      = 700;
	var $Closing3      = 1000;
	var $Origination   = 0;
	var $Origination2  = 0.5;
	var $Origination3  = 0.8;
	
	var $PeriodRent         = 800;
	var $AnnualRentIncrease = 4;
	var $AnnualMaintanance  = 900;
	var $AnnualAppreciation = 5;
	var $SellingCost        = 7;

	var $PMI       = 0.5;
	var $PMI2       = 0.5;
	var $PMI3       = 0.5;

	// Default property info.
	var $HomeValue     = 300000;
	var $Insurance     = 1500;
	var $PropertyTaxes = 3000;
	
	var $YearsBeforeSell = 5;
		  
	// Default state of the selectors.
	// Place 0 to set ($) option, 1 to set (%) option of selector
	var $DownPaymentSel   = 1;
	var $PropertyTaxesSel = 0;
	var $InsuranceSel     = 0;
	var $PMISel           = 1;
	var $ShowTableSel     = 0;

	// Default personal info
	var $Income      = 5000;
	var $Income2     = 3000;
	var $Income3     = 0;
	var $Income4     = 0;
	var $Income5     = 0;

	var $DebtAmount  = 3000;
	var $DebtAmount2 = 4000;
	var $DebtAmount3 = 1200;
	var $DebtAmount4 = 800;
	var $DebtAmount5 = 0;
	var $DebtAmount6 = 0;
	var $DebtAmount7 = 0;
	var $DebtAmount8 = 0;
	var $DebtAmount9 = 0;
	var $DebtAmount10= 0;
	
	var $DebtPayment  = 375;
	var $DebtPayment2 = 425;
	var $DebtPayment3 = 60;
	var $DebtPayment4 = 50;
	var $DebtPayment5 = 0;
	var $DebtPayment6 = 0;
	var $DebtPayment7 = 0;
	var $DebtPayment8 = 0;
	var $DebtPayment9 = 0;
	var $DebtPayment10= 0;
	
	var $DebtInterest  = 8;
	var $DebtInterest2 = 15;
	var $DebtInterest3 = 15;
	var $DebtInterest4 = 18;
	var $DebtInterest5 = 0;
	var $DebtInterest6 = 0;
	var $DebtInterest7 = 0;
	var $DebtInterest8 = 0;
	var $DebtInterest9 = 0;
	var $DebtInterest10= 0;

	var $DebtLength   = 3;
	var $DebtLength2  = 1.5;
	var $DebtLength3  = 4;
	var $DebtLength4  = 1;
	var $DebtLength5  = 0;
	var $DebtLength6  = 0;
	var $DebtLength7  = 0;
	var $DebtLength8  = 0;
	var $DebtLength9  = 0;
	var $DebtLength10 = 0;
	
	var $Taxes        = 26;
	var $StateTax     = 5;
	var $SavingsRate  = 5;
	
	var $FrontRatio   = 30;
	var $BackRatio    = 36;
	
	var $Deductions   = 3000;
	
	var $PDFGen        = 0;
}

$Defaults = new Defaults();
?>