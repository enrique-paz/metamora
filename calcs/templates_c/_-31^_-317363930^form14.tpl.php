<?php /* Smarty version 2.6.2, created on 2008-05-04 02:22:51
         compiled from default/form14.tpl */ ?>
	<form method="POST" id="CalcForm">
		<h1><?php echo $this->_tpl_vars['lang']['Calc14Title']; ?>
</h1>
		<div class="table-caption inputinfo"><?php echo $this->_tpl_vars['lang']['InputInfo']; ?>
</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['LoanInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Amount']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Amount' size='8' value='<?php echo $this->_tpl_vars['vars']['Amount']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Interest']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Interest' size='8' value='<?php echo $this->_tpl_vars['vars']['Interest']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Length']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Length' size='8' value='<?php echo $this->_tpl_vars['vars']['Length']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Years']; ?>
)
				</td>
			</tr>
			
			<tr>
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['AdditionalInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Points']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Points' size='8' value='<?php echo $this->_tpl_vars['vars']['Points']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['OriginationFees']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Origination' size='8' value='<?php echo $this->_tpl_vars['vars']['Origination']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['ClosingCost']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Closing' size='8' value='<?php echo $this->_tpl_vars['vars']['Closing']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr> 
			
			<tr>
				<td colspan="2" class="chapter" align="center">
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
				<td class="button" colspan="2">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>

		<div class="table-caption analysis"><?php echo $this->_tpl_vars['lang']['FinancialAnalysis']; ?>
</div>
		<table class="results" cellspacing="0">
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalClosingCost']; ?>
</td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalClosingCost']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalMonthlyPayment']; ?>
</td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPayments']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalCostOfLoan']; ?>
</td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalCostOfLoan']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPaymentPerThousand']; ?>
</td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPaymentPerThousand']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['AnnualPaymentPerThousand']; ?>
</td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AnnualPaymentPerThousand']; ?>
</td>
			</tr>
			<tr class="total last">
				<td class="first"><?php echo $this->_tpl_vars['lang']['LifetimePaymentPerThousand']; ?>
</td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['LifetimePaymentPerThousand']; ?>
</td>
			</tr>
		</table>
	</form>