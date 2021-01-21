<?

include_once('defaults.php');
include_once('settings.php');

class Variables
{
	var $Template;
	
	// Default mortgage info.
	var $DownPayment;
	var $DownPayment2;
	var $Amount;
	var $Amount2;
	var $Amount3;
	var $Interest;
	var $Interest2;
	var $Interest3;
	var $Length;
	var $Length2;
	var $Length3;
	var $PaidPeriods;
	var $PeriodPayment;
	var $AdditionalPayment;
	
	var $BalloonPayment;
	var $BalloonLength;
		  
	var $Points;
	var $Points2;
	var $Points3;
	var $Closing;
	var $Closing2;
	var $Closing3;
	var $Origination;
	var $Origination2;
	var $Origination3;
	
	var $PeriodRent;
	var $AnnualRentIncrease;
	var $AnnualMaintanance;
	var $AnnualAppreciation;
	var $SellingCost;

	var $PMI;
	var $PMI2;
	var $PMI3;
	
	// Default property info.
	var $HomeValue;
	var $Insurance;
	var $PropertyTaxes;
	
	var $YearsBeforeSell;
		  
	// Default state of the selectors.
	var $DownPaymentSel;
	var $PropertyTaxesSel;
	var $InsuranceSel;
	var $PMISel;
	var $ShowTableSel;

	// Default personal info
	var $Income;
	var $Income2;
	var $Income3;
	var $Income4;
	var $Income5;

	var $DebtAmount;
	var $DebtAmount2;
	var $DebtAmount3;
	var $DebtAmount4;
	var $DebtAmount5;
	var $DebtAmount6;
	var $DebtAmount7;
	var $DebtAmount8;
	var $DebtAmount9;
	var $DebtAmount10;
	
	var $DebtPayment;
	var $DebtPayment2;
	var $DebtPayment3;
	var $DebtPayment4;
	var $DebtPayment5;
	var $DebtPayment6;
	var $DebtPayment7;
	var $DebtPayment8;
	var $DebtPayment9;
	var $DebtPayment10;

	var $DebtInterest;
	var $DebtInterest2;
	var $DebtInterest3;
	var $DebtInterest4;
	var $DebtInterest5;
	var $DebtInterest6;
	var $DebtInterest7;
	var $DebtInterest8;
	var $DebtInterest9;
	var $DebtInterest10;

	var $DebtLength;
	var $DebtLength2;
	var $DebtLength3;
	var $DebtLength4;
	var $DebtLength5;
	var $DebtLength6;
	var $DebtLength7;
	var $DebtLength8;
	var $DebtLength9;
	var $DebtLength10;
	
	var $Taxes;
	var $StateTax;
	var $SavingsRate;

	var $FrontRatio;
	var $BackRatio;
	
	var $Deductions;
	
	var $PDFGen;
	
	var $OutVar;
	
	var $LangVar;
	
	function Variables()
	{
		global $Defaults, $CalcSettings;
		
		list(
			$this->Template,
			$this->DownPayment,
			$this->DownPayment2,
			$this->Amount,
			$this->Amount2,
			$this->Amount3,
			$this->Interest,
			$this->Interest2,
			$this->Interest3,
			$this->Length,
			$this->Length2,
			$this->Length3,
			$this->PaidPeriods,
			$this->PeriodPayment,
			$this->AdditionalPayment,

			$this->BalloonPayment,
			$this->BalloonLength,

			$this->Points,
			$this->Points2,
			$this->Points3,
			$this->Closing,
			$this->Closing2,
			$this->Closing3,
			$this->Origination,
			$this->Origination2,
			$this->Origination3,

			$this->PeriodRent,
			$this->AnnualRentIncrease,
			$this->AnnualMaintanance,
			$this->AnnualAppreciation,
			$this->SellingCost,
	
			$this->PMI,
			$this->PMI2,
			$this->PMI3,
			
			$this->HomeValue,
			$this->Insurance,
			$this->PropertyTaxes,
			
			$this->YearsBeforeSell,
			
			$this->DownPaymentSel,
			$this->PropertyTaxesSel,
			$this->InsuranceSel,
			$this->PMISel,
			$this->ShowTableSel,
			
			$this->Income,
			$this->Income2,
			$this->Income3,
			$this->Income4,
			$this->Income5,

			$this->DebtAmount,
			$this->DebtAmount2,
			$this->DebtAmount3,
			$this->DebtAmount4,
			$this->DebtAmount5,
			$this->DebtAmount6,
			$this->DebtAmount7,
			$this->DebtAmount8,
			$this->DebtAmount9,
			$this->DebtAmount10,
			
			$this->DebtPayment,
			$this->DebtPayment2,
			$this->DebtPayment3,
			$this->DebtPayment4,
			$this->DebtPayment5,
			$this->DebtPayment6,
			$this->DebtPayment7,
			$this->DebtPayment8,
			$this->DebtPayment9,
			$this->DebtPayment10,

			$this->DebtInterest,
			$this->DebtInterest2,
			$this->DebtInterest3,
			$this->DebtInterest4,
			$this->DebtInterest5,
			$this->DebtInterest6,
			$this->DebtInterest7,
			$this->DebtInterest8,
			$this->DebtInterest9,
			$this->DebtInterest10,

			$this->DebtLength,
			$this->DebtLength2,
			$this->DebtLength3,
			$this->DebtLength4,
			$this->DebtLength5,
			$this->DebtLength6,
			$this->DebtLength7,
			$this->DebtLength8,
			$this->DebtLength9,
			$this->DebtLength10,

			$this->Taxes,
			$this->StateTax,
			$this->SavingsRate,
			$this->FrontRatio,
			$this->BackRatio,
			
			$this->Deductions,
			
			$this->PDFGen
			
		) = $this->clearHttpVars(
			'Template',
			'DownPayment',
			'DownPayment2',
			'Amount',
			'Amount2',
			'Amount3',
			'Interest',
			'Interest2',
			'Interest3',
			'Length',
			'Length2',
			'Length3',
			'PaidPeriods',
			'PeriodPayment',
			'AdditionalPayment',
			'BalloonPayment',
			'BalloonLength',

			'Points',
			'Points2',
			'Points3',
			'Closing',
			'Closing2',
			'Closing3',
			'Origination',
			'Origination2',
			'Origination3',
			
			'PeriodRent',
			'AnnualRentIncrease',
			'AnnualMaintanance',
			'AnnualAppreciation',
			'SellingCost',

			'PMI',
			'PMI2',
			'PMI3',
			
			'HomeValue',
			'Insurance',
			'PropertyTaxes',
			
			'YearsBeforeSell',
			
			'DownPaymentSel',
			'PropertyTaxesSel',
			'InsuranceSel',
			'PMISel',
			'ShowTableSel',
			
			'Income',
			'Income2',
			'Income3',
			'Income4',
			'Income5',

			'DebtAmount',
			'DebtAmount2',
			'DebtAmount3',
			'DebtAmount4',
			'DebtAmount5',
			'DebtAmount6',
			'DebtAmount7',
			'DebtAmount8',
			'DebtAmount9',
			'DebtAmount10',
			
			'DebtPayment',
			'DebtPayment2',
			'DebtPayment3',
			'DebtPayment4',
			'DebtPayment5',
			'DebtPayment6',
			'DebtPayment7',
			'DebtPayment8',
			'DebtPayment9',
			'DebtPayment10',

			'DebtInterest',
			'DebtInterest2',
			'DebtInterest3',
			'DebtInterest4',
			'DebtInterest5',
			'DebtInterest6',
			'DebtInterest7',
			'DebtInterest8',
			'DebtInterest9',
			'DebtInterest10',
			
			'DebtLength',
			'DebtLength2',
			'DebtLength3',
			'DebtLength4',
			'DebtLength5',
			'DebtLength6',
			'DebtLength7',
			'DebtLength8',
			'DebtLength9',
			'DebtLength10',
			
			'Taxes',
			'StateTax',
			'SavingsRate',
			'FrontRatio',
			'BackRatio',
			
			'Deductions',
			'PDFGen'
			);

		if (empty($this->Template))
			$this->Template = $CalcSettings->Template;

		if (empty($this->Currency))
			$this->Currency = $CalcSettings->Currency;

		if (empty($this->Language))
			$this->Language = $CalcSettings->Language;
			
		if (empty($this->DownPayment) || is_float($this->DownPayment))
			$this->DownPayment = $Defaults->DownPayment;

		if (empty($this->DownPayment2) || is_int($this->DownPayment2))
			$this->DownPayment2 = $Defaults->DownPayment2;
			
		if (empty($this->Amount) || is_float($this->Amount))
			$this->Amount = $Defaults->Amount;

		if (empty($this->Amount2) || is_float($this->Amount2))
			$this->Amount2 = $Defaults->Amount2;

		if (empty($this->Amount3) || is_float($this->Amount3))
			$this->Amount3 = $Defaults->Amount3;
			
		if (empty($this->Interest) || is_float($this->Interest))
			$this->Interest = $Defaults->Interest;

		if (empty($this->Interest2) || is_float($this->Interest2))
			$this->Interest2 = $Defaults->Interest2;

		if (empty($this->Interest3) || is_float($this->Interest3))
			$this->Interest3 = $Defaults->Interest3;

		if (empty($this->Length) || is_int($this->Length))
			$this->Length = $Defaults->Length;

		if (empty($this->Length2) || is_int($this->Length2))
			$this->Length2 = $Defaults->Length2;

		if (empty($this->Length3) || is_int($this->Length3))
			$this->Length3 = $Defaults->Length3;
			
		if (empty($this->PaidPeriods) || is_int($this->PaidPeriods))
			$this->PaidPeriods = $Defaults->PaidPeriods;

		if (empty($this->PeriodPayment) || is_int($this->PeriodPayment))
			$this->PeriodPayment = $Defaults->PeriodPayment;

		if (empty($this->AdditionalPayment) || is_float($this->AdditionalPayment))
			$this->AdditionalPayment = $Defaults->AdditionalPayment;
			
		if (empty($this->BalloonPayment) || is_float($this->BalloonPayment))
			$this->BalloonPayment = $Defaults->BalloonPayment;

		if (empty($this->BalloonLength) || is_float($this->BalloonLength))
			$this->BalloonLength = $Defaults->BalloonLength;

		if (empty($this->Points) || is_float($this->Points))
			$this->Points = $Defaults->Points;

		if (empty($this->Points2) || is_float($this->Points2))
			$this->Points2 = $Defaults->Points2;

		if (empty($this->Points3) || is_float($this->Points3))
			$this->Points3 = $Defaults->Points3;
			
		if (empty($this->Closing) || is_float($this->Closing))
			$this->Closing = $Defaults->Closing;

		if (empty($this->Closing2) || is_float($this->Closing2))
			$this->Closing2 = $Defaults->Closing2;

		if (empty($this->Closing3) || is_float($this->Closing3))
			$this->Closing3 = $Defaults->Closing3;

		if (empty($this->Origination) || is_float($this->Origination))
			$this->Origination = $Defaults->Origination;

		if (empty($this->Origination2) || is_float($this->Origination2))
			$this->Origination2 = $Defaults->Origination2;

		if (empty($this->Origination3) || is_float($this->Origination3))
			$this->Origination3 = $Defaults->Origination3;
			
		if (empty($this->PeriodRent) || is_float($this->PeriodRent))
			$this->PeriodRent = $Defaults->PeriodRent;

		if (empty($this->AnnualRentIncrease) || is_float($this->AnnualRentIncrease))
			$this->AnnualRentIncrease = $Defaults->AnnualRentIncrease;

		if (empty($this->AnnualMaintanance) || is_float($this->AnnualMaintanance))
			$this->AnnualMaintanance = $Defaults->AnnualMaintanance;

		if (empty($this->AnnualAppreciation) || is_float($this->AnnualAppreciation))
			$this->AnnualAppreciation = $Defaults->AnnualAppreciation;

		if (empty($this->SellingCost) || is_float($this->SellingCost))
			$this->SellingCost = $Defaults->SellingCost;
			
		if (empty($this->PMI) || is_float($this->PMI))
			$this->PMI = $Defaults->PMI;

		if (empty($this->PMI2) || is_float($this->PMI2))
			$this->PMI2 = $Defaults->PMI2;

		if (empty($this->PMI3) || is_float($this->PMI3))
			$this->PMI3 = $Defaults->PMI3;

		if (empty($this->HomeValue) || is_float($this->HomeValue))
			$this->HomeValue = $Defaults->HomeValue;

		if (empty($this->Insurance) || is_float($this->Insurance))
			$this->Insurance = $Defaults->Insurance;
			
		if (empty($this->PropertyTaxes) || is_float($this->PropertyTaxes))
			$this->PropertyTaxes = $Defaults->PropertyTaxes;

		if (empty($this->YearsBeforeSell) || is_int($this->YearsBeforeSell))
			$this->YearsBeforeSell = $Defaults->YearsBeforeSell;
			
		if (empty($this->DownPaymentSel))
			$this->DownPaymentSel = $Defaults->DownPaymentSel;
			
		if (empty($this->PropertyTaxesSel))
			$this->PropertyTaxesSel = $Defaults->PropertyTaxesSel;

		if (empty($this->InsuranceSel))
			$this->InsuranceSel = $Defaults->InsuranceSel;

		if (empty($this->PMISel))
			$this->PMISel = $Defaults->PMISel;

		if (empty($this->ShowTableSel))
			$this->ShowTableSel = $Defaults->ShowTableSel;

		if (empty($this->Income) || is_float($this->Income))
			$this->Income = $Defaults->Income;
			
		if (empty($this->Income2) || is_float($this->Income2))
			$this->Income2 = $Defaults->Income2;
			
		if (empty($this->Income3) || is_float($this->Income3))
			$this->Income3 = $Defaults->Income3;
			
		if (empty($this->Income4) || is_float($this->Income4))
			$this->Income4 = $Defaults->Income4;
			
		if (empty($this->Income5) || is_float($this->Income5))
			$this->Income5 = $Defaults->Income5;


		if (empty($this->DebtAmount) || is_float($this->DebtAmount))
			$this->DebtAmount = $Defaults->DebtAmount;
			
		if (empty($this->DebtAmount2) || is_float($this->DebtAmount2))
			$this->DebtAmount2 = $Defaults->DebtAmount2;
			
		if (empty($this->DebtAmount3) || is_float($this->DebtAmount3))
			$this->DebtAmount3 = $Defaults->DebtAmount3;
			
		if (empty($this->DebtAmount4) || is_float($this->DebtAmount4))
			$this->DebtAmount4 = $Defaults->DebtAmount4;
			
		if (empty($this->DebtAmount5) || is_float($this->DebtAmount5))
			$this->DebtAmount5 = $Defaults->DebtAmount5;

		if (empty($this->DebtAmount6) || is_float($this->DebtAmount6))
			$this->DebtAmount6 = $Defaults->DebtAmount6;
			
		if (empty($this->DebtAmount7) || is_float($this->DebtAmount7))
			$this->DebtAmount7 = $Defaults->DebtAmount7;

		if (empty($this->DebtAmount8) || is_float($this->DebtAmount8))
			$this->DebtAmount8 = $Defaults->DebtAmount8;

		if (empty($this->DebtAmount9) || is_float($this->DebtAmount9))
			$this->DebtAmount9 = $Defaults->DebtAmount9;

		if (empty($this->DebtAmount10) || is_float($this->DebtAmount10))
			$this->DebtAmount10 = $Defaults->DebtAmount10;

			
					
		if (empty($this->DebtPayment) || is_float($this->DebtPayment))
			$this->DebtPayment = $Defaults->DebtPayment;
			
		if (empty($this->DebtPayment2) || is_float($this->DebtPayment2))
			$this->DebtPayment2 = $Defaults->DebtPayment2;
			
		if (empty($this->DebtPayment3) || is_float($this->DebtPayment3))
			$this->DebtPayment3 = $Defaults->DebtPayment3;
			
		if (empty($this->DebtPayment4) || is_float($this->DebtPayment4))
			$this->DebtPayment4 = $Defaults->DebtPayment4;
			
		if (empty($this->DebtPayment5) || is_float($this->DebtPayment5))
			$this->DebtPayment5 = $Defaults->DebtPayment5;

		if (empty($this->DebtPayment6) || is_float($this->DebtPayment6))
			$this->DebtPayment6 = $Defaults->DebtPayment6;
			
		if (empty($this->DebtPayment7) || is_float($this->DebtPayment7))
			$this->DebtPayment7 = $Defaults->DebtPayment7;

		if (empty($this->DebtPayment8) || is_float($this->DebtPayment8))
			$this->DebtPayment8 = $Defaults->DebtPayment8;

		if (empty($this->DebtPayment9) || is_float($this->DebtPayment9))
			$this->DebtPayment9 = $Defaults->DebtPayment9;

		if (empty($this->DebtPayment10) || is_float($this->DebtPayment10))
			$this->DebtPayment10 = $Defaults->DebtPayment10;


		if (empty($this->DebtInterest) || is_float($this->DebtInterest))
			$this->DebtInterest = $Defaults->DebtInterest;
			
		if (empty($this->DebtInterest2) || is_float($this->DebtInterest2))
			$this->DebtInterest2 = $Defaults->DebtInterest2;
			
		if (empty($this->DebtInterest3) || is_float($this->DebtInterest3))
			$this->DebtInterest3 = $Defaults->DebtInterest3;
			
		if (empty($this->DebtInterest4) || is_float($this->DebtInterest4))
			$this->DebtInterest4 = $Defaults->DebtInterest4;
			
		if (empty($this->DebtInterest5) || is_float($this->DebtInterest5))
			$this->DebtInterest5 = $Defaults->DebtInterest5;

		if (empty($this->DebtInterest6) || is_float($this->DebtInterest6))
			$this->DebtInterest6 = $Defaults->DebtInterest6;
			
		if (empty($this->DebtInterest7) || is_float($this->DebtInterest7))
			$this->DebtInterest7 = $Defaults->DebtInterest7;

		if (empty($this->DebtInterest8) || is_float($this->DebtInterest8))
			$this->DebtInterest8 = $Defaults->DebtInterest8;

		if (empty($this->DebtInterest9) || is_float($this->DebtInterest9))
			$this->DebtInterest9 = $Defaults->DebtInterest9;

		if (empty($this->DebtInterest10) || is_float($this->DebtInterest10))
			$this->DebtInterest10 = $Defaults->DebtInterest10;


		if (empty($this->DebtLength) || is_float($this->DebtLength))
			$this->DebtLength = $Defaults->DebtLength;
			
		if (empty($this->DebtLength2) || is_float($this->DebtLength2))
			$this->DebtLength2 = $Defaults->DebtLength2;
			
		if (empty($this->DebtLength3) || is_float($this->DebtLength3))
			$this->DebtLength3 = $Defaults->DebtLength3;
			
		if (empty($this->DebtLength4) || is_float($this->DebtLength4))
			$this->DebtLength4 = $Defaults->DebtLength4;
			
		if (empty($this->DebtLength5) || is_float($this->DebtLength5))
			$this->DebtLength5 = $Defaults->DebtLength5;

		if (empty($this->DebtLength6) || is_float($this->DebtLength6))
			$this->DebtLength6 = $Defaults->DebtLength6;
			
		if (empty($this->DebtLength7) || is_float($this->DebtLength7))
			$this->DebtLength7 = $Defaults->DebtLength7;

		if (empty($this->DebtLength8) || is_float($this->DebtLength8))
			$this->DebtLength8 = $Defaults->DebtLength8;

		if (empty($this->DebtLength9) || is_float($this->DebtLength9))
			$this->DebtLength9 = $Defaults->DebtLength9;

		if (empty($this->DebtLength10) || is_float($this->DebtLength10))
			$this->DebtLength10 = $Defaults->DebtLength10;

			
		if (empty($this->Taxes) || is_float($this->Taxes))
			$this->Taxes = $Defaults->Taxes;
			
		if (empty($this->StateTax) || is_float($this->StateTax))
			$this->StateTax = $Defaults->StateTax;

		if (empty($this->SavingsRate) || is_float($this->SavingsRate))
			$this->SavingsRate = $Defaults->SavingsRate;

		if (empty($this->FrontRatio) || is_float($this->FrontRatio))
			$this->FrontRatio = $Defaults->FrontRatio;

		if (empty($this->BackRatio) || is_float($this->BackRatio))
			$this->BackRatio = $Defaults->BackRatio;
		
		if (empty($this->Deductions) || is_float($this->Deductions))
			$this->Deductions = $Defaults->Deductions;
			
		if (empty($this->PDFGen))
			$this->PDFGen = intval($Defaults->PDFGen);

		// Filling values for the input fields. We need to do so each time form is shown.
	    $this->OutVar['DownPayment']      = number_format($this->DownPayment, '3', '.', ',');
	    $this->OutVar['DownPayment2']     = $this->DownPayment2;
	    $this->OutVar['Amount']           = number_format($this->Amount, '2', '.', ',');
	    $this->OutVar['Amount2']          = number_format($this->Amount2, '2', '.', ',');
	    $this->OutVar['Amount3']          = number_format($this->Amount3, '2', '.', ',');	    
	    $this->OutVar['Interest']         = number_format($this->Interest, '3', '.', ',');
	    $this->OutVar['Interest2']        = number_format($this->Interest2, '3', '.', ',');
	    $this->OutVar['Interest3']        = number_format($this->Interest3, '3', '.', ',');
	    $this->OutVar['Length']           = number_format($this->Length, '0', '', '');
	    $this->OutVar['Length2']          = number_format($this->Length2, '0', '', '');
	    $this->OutVar['Length3']          = number_format($this->Length3, '0', '', '');
	    $this->OutVar['PaidPeriods']      = number_format($this->PaidPeriods, '0', '', '');
	    $this->OutVar['PeriodPayment']    = number_format($this->PeriodPayment, '2', '.', ',');
	    $this->OutVar['AdditionalPayment']  = number_format($this->AdditionalPayment, '2', '.', ',');
	    $this->OutVar['BalloonPayment']    = number_format($this->BalloonPayment, '2', '.', ',');
	    $this->OutVar['BalloonLength']    = number_format($this->BalloonLength, '0', '.', ',');

	    $this->OutVar['Points']           = number_format($this->Points, '3', '.', ',');
	    $this->OutVar['Points2']          = number_format($this->Points2, '3', '.', ',');
	    $this->OutVar['Points3']          = number_format($this->Points3, '3', '.', ',');
	    $this->OutVar['Closing']          = number_format($this->Closing, '2', '.', ',');
	    $this->OutVar['Closing2']         = number_format($this->Closing2, '2', '.', ',');
	    $this->OutVar['Closing3']         = number_format($this->Closing3, '2', '.', ',');
	    $this->OutVar['Origination']      = number_format($this->Origination, '2', '.', ',');
	    $this->OutVar['Origination2']     = number_format($this->Origination2, '2', '.', ',');
	    $this->OutVar['Origination3']     = number_format($this->Origination3, '2', '.', ',');

	    $this->OutVar['PeriodRent']       = number_format($this->PeriodRent, '2', '.', ',');
		$this->OutVar['AnnualRentIncrease']  = number_format($this->AnnualRentIncrease, '3', '.', ',');
	    $this->OutVar['AnnualMaintanance']   = number_format($this->AnnualMaintanance, '2', '.', ',');
	    $this->OutVar['AnnualAppreciation']  = number_format($this->AnnualAppreciation, '3', '.', ',');
	    $this->OutVar['SellingCost']       = number_format($this->SellingCost, '3', '.', ',');
	    
	    $this->OutVar['PMI']              = number_format($this->PMI, '3', '.', ',');
	    $this->OutVar['PMI2']              = number_format($this->PMI2, '3', '.', ',');
	    $this->OutVar['PMI3']              = number_format($this->PMI3, '3', '.', ',');
	    
	    $this->OutVar['HomeValue']        = number_format($this->HomeValue, '2', '.', ',');
	    $this->OutVar['Insurance']        = number_format($this->Insurance, '2', '.', ',');
	    $this->OutVar['PropertyTaxes']    = number_format($this->PropertyTaxes, '2', '.', ',');

	    $this->OutVar['YearsBeforeSell']  = number_format($this->YearsBeforeSell, '0', '.', ',');
	        
	    $this->OutVar['DownPaymentSel']   = $this->DownPaymentSel;
	    $this->OutVar['PropertyTaxesSel'] = $this->PropertyTaxesSel;
	    $this->OutVar['InsuranceSel']     = $this->InsuranceSel;
	    $this->OutVar['PMISel']           = $this->PMISel;
	    $this->OutVar['ShowTableSel']     = $this->ShowTableSel;

	    $this->OutVar['Income']           = number_format($this->Income,  '2', '.', ',');
	    $this->OutVar['Income2']          = number_format($this->Income2, '2', '.', ',');
	    $this->OutVar['Income3']          = number_format($this->Income3, '2', '.', ',');
	    $this->OutVar['Income4']          = number_format($this->Income4, '2', '.', ',');
	    $this->OutVar['Income5']          = number_format($this->Income5, '2', '.', ',');

	    $this->OutVar['DebtAmount']      = number_format($this->DebtAmount,  '2', '.', ',');
	    $this->OutVar['DebtAmount2']     = number_format($this->DebtAmount2, '2', '.', ',');
	    $this->OutVar['DebtAmount3']     = number_format($this->DebtAmount3, '2', '.', ',');
	    $this->OutVar['DebtAmount4']     = number_format($this->DebtAmount4, '2', '.', ',');
	    $this->OutVar['DebtAmount5']     = number_format($this->DebtAmount5, '2', '.', ',');
	    $this->OutVar['DebtAmount6']     = number_format($this->DebtAmount6,  '2', '.', ',');
	    $this->OutVar['DebtAmount7']     = number_format($this->DebtAmount7,  '2', '.', ',');
	    $this->OutVar['DebtAmount8']     = number_format($this->DebtAmount8,  '2', '.', ',');
	    $this->OutVar['DebtAmount9']     = number_format($this->DebtAmount9,  '2', '.', ',');
	    $this->OutVar['DebtAmount10']    = number_format($this->DebtAmount10,  '2', '.', ',');
	    
	    $this->OutVar['DebtPayment']      = number_format($this->DebtPayment,  '2', '.', ',');
	    $this->OutVar['DebtPayment2']     = number_format($this->DebtPayment2, '2', '.', ',');
	    $this->OutVar['DebtPayment3']     = number_format($this->DebtPayment3, '2', '.', ',');
	    $this->OutVar['DebtPayment4']     = number_format($this->DebtPayment4, '2', '.', ',');
	    $this->OutVar['DebtPayment5']     = number_format($this->DebtPayment5, '2', '.', ',');
	    $this->OutVar['DebtPayment6']     = number_format($this->DebtPayment6,  '2', '.', ',');
	    $this->OutVar['DebtPayment7']     = number_format($this->DebtPayment7,  '2', '.', ',');
	    $this->OutVar['DebtPayment8']     = number_format($this->DebtPayment8,  '2', '.', ',');
	    $this->OutVar['DebtPayment9']     = number_format($this->DebtPayment9,  '2', '.', ',');
	    $this->OutVar['DebtPayment10']    = number_format($this->DebtPayment10,  '2', '.', ',');
	    
	    $this->OutVar['DebtInterest']     = number_format($this->DebtInterest,  '2', '.', ',');
	    $this->OutVar['DebtInterest2']    = number_format($this->DebtInterest2, '2', '.', ',');
	    $this->OutVar['DebtInterest3']    = number_format($this->DebtInterest3, '2', '.', ',');
	    $this->OutVar['DebtInterest4']    = number_format($this->DebtInterest4, '2', '.', ',');
	    $this->OutVar['DebtInterest5']    = number_format($this->DebtInterest5, '2', '.', ',');
	    $this->OutVar['DebtInterest6']    = number_format($this->DebtInterest6,  '2', '.', ',');
	    $this->OutVar['DebtInterest7']    = number_format($this->DebtInterest7,  '2', '.', ',');
	    $this->OutVar['DebtInterest8']    = number_format($this->DebtInterest8,  '2', '.', ',');
	    $this->OutVar['DebtInterest9']    = number_format($this->DebtInterest9,  '2', '.', ',');
	    $this->OutVar['DebtInterest10']   = number_format($this->DebtInterest10,  '2', '.', ',');
	    
	    $this->OutVar['DebtLength']       = number_format($this->DebtLength,  '2', '.', ',');
	    $this->OutVar['DebtLength2']      = number_format($this->DebtLength2, '2', '.', ',');
	    $this->OutVar['DebtLength3']      = number_format($this->DebtLength3, '2', '.', ',');
	    $this->OutVar['DebtLength4']      = number_format($this->DebtLength4, '2', '.', ',');
	    $this->OutVar['DebtLength5']      = number_format($this->DebtLength5, '2', '.', ',');
	    $this->OutVar['DebtLength6']      = number_format($this->DebtLength6,  '2', '.', ',');
	    $this->OutVar['DebtLength7']      = number_format($this->DebtLength7,  '2', '.', ',');
	    $this->OutVar['DebtLength8']      = number_format($this->DebtLength8,  '2', '.', ',');
	    $this->OutVar['DebtLength9']      = number_format($this->DebtLength9,  '2', '.', ',');
	    $this->OutVar['DebtLength10']     = number_format($this->DebtLength10,  '2', '.', ',');	    
	    
	    $this->OutVar['Taxes']            = number_format($this->Taxes, '3', '.', ',');
	    $this->OutVar['StateTax']         = number_format($this->StateTax, '3', '.', ',');
	    $this->OutVar['SavingsRate']      = number_format($this->SavingsRate, '3', '.', ',');
	    
	    $this->OutVar['FrontRatio']       = number_format($this->FrontRatio, '3', '.', ',');
	    $this->OutVar['BackRatio']        = number_format($this->BackRatio, '3', '.', ',');
	    
	    $this->OutVar['Deductions']       = number_format($this->Deductions, '2', '.', ',');
	    $this->OutVar['PDFGen']           = intval($this->PDFGen);
	}
	
	
	function clearHttpVars()
	{
	    $resarray = array();
	    foreach (func_get_args() as $var) {
	        // Get var
	        //global $$var;
			if (isset($_REQUEST[$var]))
				$$var = $_REQUEST[$var];
			else
				$$var = null; 
				
	        if (empty($var)) {
	            return;
	        }

	        $ourvar = $$var;
	
	        if ($ourvar == '0' && strpos($var, 'Sel') >=0 && $var != 'PDFGen')
	           $ourvar = '0.0';

			$ourvar = str_replace(',', '', $ourvar);
			
	        if (!isset($ourvar)) 
	        {
	            array_push($resarray, NULL);
	            continue;
	        }
	        
	        if (empty($ourvar)) 
	        {
	            array_push($resarray, $ourvar);
	            continue;
	        }
	
	        // Clean var
	        if (get_magic_quotes_gpc()) 
	        {
	            $outvar = stripslashes($ourvar);
	        }
	
	        // Add to result array
	        array_push($resarray, $ourvar);
	    }
	
	    // Return vars
	    if (func_num_args() == 1) 
	    {
	        return $resarray[0];
	    } 
	    else 
	    {
	        return $resarray;
	    }
	}
}

$Variables = new Variables();

?>