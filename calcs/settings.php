<?
class CalcSettings
{
	var $Currency        = '$';
	var $CompoundPeriods = 12;

	var $Language        = "en";
	var $Template        = "default";
	var $ReturnContent   = true;
	// Footprint text
	var $Disclaimer = "DISCLAIMER: There is NO WARRANTY, expressed or implied, for the accuracy of this information or it's applicability to your financial situation. Please consult your own financial advisor.";

	var $DemoMode = false;
}

$CalcSettings = new CalcSettings();
?>