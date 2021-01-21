<?php /* Smarty version 2.6.2, created on 2008-05-01 14:04:09
         compiled from default/form8.tpl */ ?>
	<form method="POST" id="CalcForm">
		<h1><?php echo $this->_tpl_vars['lang']['Calc8Title']; ?>
</h1>
		<div class="table-caption inputinfo"><?php echo $this->_tpl_vars['lang']['InputInfo']; ?>
</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="4"><?php echo $this->_tpl_vars['lang']['LoanInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2"><?php echo $this->_tpl_vars['lang']['Interest']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='Interest' size='8' value='<?php echo $this->_tpl_vars['vars']['Interest']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2"><?php echo $this->_tpl_vars['lang']['Length']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='Length' size='8' value='<?php echo $this->_tpl_vars['vars']['Length']; ?>
'> (<?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2"><?php echo $this->_tpl_vars['lang']['ClosingCost']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='Closing' size='8' value='<?php echo $this->_tpl_vars['vars']['Closing']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2"><?php echo $this->_tpl_vars['lang']['YourTaxRate']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='Taxes' size='8' value='<?php echo $this->_tpl_vars['vars']['Taxes']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="td25 first">&nbsp;</td>
				<td class="chapter25"><?php echo $this->_tpl_vars['lang']['Amount']; ?>
 (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</td>
				<td class="chapter25"><?php echo $this->_tpl_vars['lang']['Payment']; ?>
 (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</td>
				<td class="chapter25 last"><?php echo $this->_tpl_vars['lang']['InterestShort']; ?>
 (%)</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['DebtName']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='DebtAmount' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtAmount']; ?>
'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtPayment']; ?>
'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtInterest']; ?>
'>
				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['DebtName2']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='DebtAmount2' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtAmount2']; ?>
'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment2' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtPayment2']; ?>
'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest2' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtInterest2']; ?>
'>
				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['DebtName3']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='DebtAmount3' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtAmount3']; ?>
'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment3' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtPayment3']; ?>
'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest3' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtInterest3']; ?>
'>
				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['DebtName4']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='DebtAmount4' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtAmount4']; ?>
'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment4' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtPayment4']; ?>
'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest4' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtInterest4']; ?>
'>
				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['DebtName5']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='DebtAmount5' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtAmount5']; ?>
'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment5' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtPayment5']; ?>
'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest5' size='8' value='<?php echo $this->_tpl_vars['vars']['DebtInterest5']; ?>
'>
				</td>
			</tr>
			
			<tr>
				<td colspan="4" class="chapter" align="center">
					<script language="JavaScript">
						function showPdf()
						{
							document.getElementById('PDFGen').value = 1;
							document.getElementById('CalcForm').target = '_blank';
							document.getElementById('CalcForm').submit();
							document.getElementById('CalcForm').target = '';
							document.getElementById('PDFGen').value = 0;
						}
					</script>
					<input type="hidden" id="PDFGen" name="PDFGen" value="0" />
					<a href="javascript:void(showPdf())"><img src='images/pdf-logo.png' width="16" height="16" border="0" align="middle" title="Generate PDF form for that mortgage calculator" /></a>&nbsp;<a href="javascript:void(showPdf())"><?php echo $this->_tpl_vars['lang']['ShowPdfForm']; ?>
</a>
				</td>
			</tr>
			
			<tr>
				<td class="button" colspan="4" align="center">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>
		<div class="table-caption analysis"><?php echo $this->_tpl_vars['lang']['FinancialAnalysis']; ?>
</div>
		<table class="results" cellspacing="0">
			<tr class="total">
				<td class="first">&nbsp;</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Debt']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['HELOC']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['Amount']; ?>
 : </td>
				<td colspan="2" class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['DebtValue']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPayment']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['DebtPaymentAmount']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['LoanPaymentAmount']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['AvgInterestRate']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['vars']['DebtInterestRate']; ?>
%</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['vars']['LoanInterestRate']; ?>
%</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['PayoffTimeline']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['vars']['DebtYears']; ?>
 <?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
 <?php echo $this->_tpl_vars['vars']['DebtMonths']; ?>
 <?php echo $this->_tpl_vars['lang']['MonthsShort']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['vars']['LoanYears']; ?>
 <?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
 <?php echo $this->_tpl_vars['vars']['LoanMonths']; ?>
 <?php echo $this->_tpl_vars['lang']['MonthsShort']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalMonthlyPayment']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalDebtPayment']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalLoanPayment']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalDeductibleInterest']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalDebtInterest']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalLoanInterest']; ?>
</td>
			</tr>
			<tr class="total last">
				<td class="first"><?php echo $this->_tpl_vars['lang']['AvgAnnualTaxSavings']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['DebtTaxSavings']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['LoanTaxSavings']; ?>
</td>
			</tr>
		</table>
	</form>