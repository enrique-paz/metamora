<?php /* Smarty version 2.6.2, created on 2008-05-04 02:01:35
         compiled from default/form5.tpl */ ?>
	<form method="POST" id="CalcForm">
		<h1><?php echo $this->_tpl_vars['lang']['Calc5Title']; ?>
</h1>
		<div class="table-caption inputinfo"><?php echo $this->_tpl_vars['lang']['InputInfo']; ?>
</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['PropertyInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['HomeValue']; ?>
 : </td>
				<td class="last">
					<input class='text' name='HomeValue' size='8' value='<?php echo $this->_tpl_vars['vars']['HomeValue']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['YearsBeforeSell']; ?>
 : </td>
				<td class="last">
					<input class='text' name='YearsBeforeSell' size='8' value='<?php echo $this->_tpl_vars['vars']['YearsBeforeSell']; ?>
'> (<?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
)
				</td>
			</tr>

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
'> (<?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
)
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
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['ClosingCost']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Closing' size='8' value='<?php echo $this->_tpl_vars['vars']['Closing']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['TaxAndInsuranceInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['AnnualPropertyTaxes']; ?>
 : </td>
				<td class="last">
					<input class='text' name='PropertyTaxes' size='8' value='<?php echo $this->_tpl_vars['vars']['PropertyTaxes']; ?>
'>
					<span class="radio">
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel0' <?php if (( $this->_tpl_vars['vars']['PropertyTaxesSel'] == 0 )): ?>checked<?php endif; ?> value='0'> <label for="PropertyTaxesSel0">(<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</label>
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel1' <?php if (( $this->_tpl_vars['vars']['PropertyTaxesSel'] == 1 )): ?>checked<?php endif; ?> value='1'> <label for="PropertyTaxesSel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['AnnualInsurance']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Insurance' size='8' value='<?php echo $this->_tpl_vars['vars']['Insurance']; ?>
'>
					<span class="radio">
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel0' <?php if (( $this->_tpl_vars['vars']['InsuranceSel'] == 0 )): ?>checked<?php endif; ?> value='0'> <label for="InsuranceSel0">(<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</label>
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel1' <?php if (( $this->_tpl_vars['vars']['InsuranceSel'] == 1 )): ?>checked<?php endif; ?> value='1'> <label for="InsuranceSel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['AnnualPMI']; ?>
 : </td>
				<td class="last">
					<input class='text' name='PMI' size='8' value='<?php echo $this->_tpl_vars['vars']['PMI']; ?>
'>
					<span class="radio">
						<input class='radio' type='radio' name='PMISel' id='PMISel0' <?php if (( $this->_tpl_vars['vars']['PMISel'] == 0 )): ?>checked<?php endif; ?> value='0'> <label for="PMISel0">(<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</label>
						<input class='radio' type='radio' name='PMISel' id='PMISel1' <?php if (( $this->_tpl_vars['vars']['PMISel'] == 1 )): ?>checked<?php endif; ?> value='1'> <label for="PMISel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['YourTaxRatesAndDeductions']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['TaxRate']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Taxes' size='8' value='<?php echo $this->_tpl_vars['vars']['Taxes']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['StateTaxRate']; ?>
 : </td>
				<td class="last">
					<input class='text' name='StateTax' size='8' value='<?php echo $this->_tpl_vars['vars']['StateTax']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Deductions']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Deductions' size='8' value='<?php echo $this->_tpl_vars['vars']['Deductions']; ?>
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
				<td colspan="2" class="chapter">
					<span class="radio">
						<input class='radio' type='checkbox' name='ShowTableSel' id='ShowTableSel' <?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>checked<?php endif; ?> value='1'> <label for="ShowTableSel"><?php echo $this->_tpl_vars['lang']['ShowScheduleTable']; ?>
</label><br/>
					</span>
				</td>
			</tr>

			<tr>
				<td class="button" colspan="2" align="center">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>
		<div class="table-caption analysis"><?php echo $this->_tpl_vars['lang']['FinancialAnalysis']; ?>
</div>
		<table class="results" cellspacing="0">
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['AmountFinanced']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AmountFinanced']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPI']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPayment']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPropertyTaxes']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyTaxes']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyInsurance']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyInsurance']; ?>
</td>
			</tr>
			<?php if (! ( $this->_tpl_vars['vars']['LoanToValue'] == null )): ?>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['LTV']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['vars']['LoanToValue']; ?>
%</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthsWithPMI']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['vars']['MonthsWithPMI']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPMI']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPMI']; ?>
</td>
			</tr>
			<?php endif; ?>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalMonthlyPayment']; ?>
 : </td>
				<td colspan="2" align="center" class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyTotal']; ?>
</td>
			</tr>
			<tr>
				<td class="first">&nbsp;</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['FirstYears']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Total']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['InterestAndPoints']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['InterestAndPoints2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['InterestAndPoints']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalPropertyTaxes']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPropertyTaxes2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPropertyTaxes']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalDeductions']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalDeductions2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalDeductions']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TaxSavings']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TaxSavings2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TaxSavings']; ?>
</td>
			</tr>

			<tr class="total last">
				<td class="first"><?php echo $this->_tpl_vars['lang']['AveragePaymentAfterTaxes']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AveragePayment2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AveragePayment']; ?>
</td>
			</tr>

		</table>

		<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>
		<div class="table-caption schedule"><?php echo $this->_tpl_vars['lang']['PaymentSchedule']; ?>
</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first" width="5%"><?php echo $this->_tpl_vars['lang']['PeriodNo']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['InterestPaid']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['Principal']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['TaxSavings']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['PMI']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['NewBalance']; ?>
</th>
			</tr>
		<?php if (count($_from = (array)$this->_tpl_vars['vars']['AmortizationTable']->Schedule)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<?php if (( $this->_tpl_vars['item']->Type == SubTotal )): ?>
			<tr>
				<td class="first subtotal"><nobr><?php echo $this->_tpl_vars['item']->Period; ?>
 <?php echo $this->_tpl_vars['lang']['YearShort']; ?>
<br/><br/></nobr></td>
				<td class="subtotal">---<br/><?php echo $this->_tpl_vars['item']->InterestPaid; ?>
<br/><br/></td>
				<td class="subtotal">---<br/><?php echo $this->_tpl_vars['item']->PrincipalApplied; ?>
<br/><br/></td>
				<td class="subtotal">---<br/><?php echo $this->_tpl_vars['item']->TaxSavings; ?>
<br/><br/></td>
				<td class="subtotal">---<br/><?php echo $this->_tpl_vars['item']->PMI; ?>
<br/><br/></td>
				<td class="last">&nbsp;</td>
			</tr>
			<?php else: ?>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['item']->Period; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']->InterestPaid; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']->PrincipalApplied; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']->TaxSavings; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']->PMI; ?>
</td>
				<td class="last"><?php echo $this->_tpl_vars['item']->RemainingBalance; ?>
</td>
			</tr>
			<?php endif; ?>
		<?php endforeach; unset($_from); endif; ?>
			<tr>
				<th class="first">&nbsp;</th>
				<th><?php echo $this->_tpl_vars['lang']['InterestPaid']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['Principal']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['TaxSavings']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['PMI']; ?>
</th>
				<th class="last">&nbsp;</th>
			</tr>
			<tr class="last">
				<td class="first total"><?php echo $this->_tpl_vars['lang']['Total']; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalInterestPaid; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalPrincipalApplied; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalTaxSavings; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalPMI; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalRemainingBalance; ?>
</td>
			</tr>
		</table>
		<?php endif; ?>
	</form>