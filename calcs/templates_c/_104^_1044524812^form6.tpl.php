<?php /* Smarty version 2.6.2, created on 2008-04-11 14:51:20
         compiled from default/form6.tpl */ ?>
	<form method="POST" id="CalcForm">
		<h1><?php echo $this->_tpl_vars['lang']['Calc6Title']; ?>
</h1>
		<div class="table-caption inputinfo"><?php echo $this->_tpl_vars['lang']['InputInfo']; ?>
</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter50 first">&nbsp;</td>
				<td class="chapter25"><nobr><?php echo $this->_tpl_vars['lang']['OriginalLoan']; ?>
</nobr></td>
				<td class="chapter25 last"><nobr><?php echo $this->_tpl_vars['lang']['RefinancedLoan']; ?>
</nobr></td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Amount']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='Amount' size='8' value='<?php echo $this->_tpl_vars['vars']['Amount']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Interest']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='Interest' size='8' value='<?php echo $this->_tpl_vars['vars']['Interest']; ?>
'> (%)
				</td>
				<td class="td25 last">
					<input class='text' name='Interest2' size='8' value='<?php echo $this->_tpl_vars['vars']['Interest2']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Length']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='Length' size='8' value='<?php echo $this->_tpl_vars['vars']['Length']; ?>
'> (<?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
)
				</td>
				<td class="td25 last">
					<nobr><input class='text' name='Length2' size='8' value='<?php echo $this->_tpl_vars['vars']['Length2']; ?>
'> (<?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
)</nobr>
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['MonthsPaid']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='PaidPeriods' size='8' value='<?php echo $this->_tpl_vars['vars']['PaidPeriods']; ?>
'> (<?php echo $this->_tpl_vars['lang']['MonthsShort']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['YearsBeforeSell']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='YearsBeforeSell' size='8' value='<?php echo $this->_tpl_vars['vars']['YearsBeforeSell']; ?>
'> (<?php echo $this->_tpl_vars['lang']['YearsShort']; ?>
)
				</td>
			</tr>

			<tr>
				<td class="chapter" colspan="3"><?php echo $this->_tpl_vars['lang']['RefinancingFees']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['Points']; ?>
 : </td>
				<td class="last" colspan="2">
					<input class='text' name='Points' size='8' value='<?php echo $this->_tpl_vars['vars']['Points']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['OriginationFees']; ?>
 : </td>
				<td class="last" colspan="2">
					<input class='text' name='Origination' size='8' value='<?php echo $this->_tpl_vars['vars']['Origination']; ?>
'> (%)
				</td>
			</tr>

			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['ClosingCost']; ?>
 : </td>
				<td class="last" colspan="2">
					<input class='text' name='Closing' size='8' value='<?php echo $this->_tpl_vars['vars']['Closing']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="3"><?php echo $this->_tpl_vars['lang']['YourTaxRates']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['TaxRate']; ?>
 : </td>
				<td class="last" colspan="2">
					<input class='text' name='Taxes' size='8' value='<?php echo $this->_tpl_vars['vars']['Taxes']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['StateTaxRate']; ?>
 : </td>
				<td class="last" colspan="2">
					<input class='text' name='StateTax' size='8' value='<?php echo $this->_tpl_vars['vars']['StateTax']; ?>
'> (%)
				</td>
			</tr>
			
			<tr>
				<td colspan="3" class="chapter" align="center">
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
				<td colspan="3"  class="chapter">
					<span class="radio">
						<input class='radio' type='checkbox' name='ShowTableSel' id='ShowTableSel' <?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>checked<?php endif; ?> value='1'> <label for="ShowTableSel"><?php echo $this->_tpl_vars['lang']['ShowScheduleTable']; ?>
</label><br/>
					</span>
				</td>
			</tr>

			<tr>
				<td class="button" colspan="3" align="center">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>
		<div class="table-caption analysis"><?php echo $this->_tpl_vars['lang']['FinancialAnalysis']; ?>
</div>
		<table class="results" cellspacing="0">
			<tr class="total">
				<td class="first">&nbsp;</td>
				<td class="td25">
					<nobr><?php echo $this->_tpl_vars['lang']['OriginalLoan']; ?>
</nobr>
					<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>	
						<br>(<a href="#amortization"><?php echo $this->_tpl_vars['lang']['SeeAmortizationTableShort']; ?>
</a>)
					<?php endif; ?>

				</td>
				<td class="td25 last">
					<nobr><?php echo $this->_tpl_vars['lang']['RefinancedLoan']; ?>
</nobr>
					<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>	
						<br>(<a href="#amortization2"><?php echo $this->_tpl_vars['lang']['SeeAmortizationTableShort']; ?>
</a>)
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPayment']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPayment']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPayment2']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalMonthlyPayment']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalMonthlyPayment']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalMonthlyPayment2']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPaymentSavings']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPaymentSavings']; ?>
</td>
			</tr>

			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalInterestPaid']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['InterestPaid']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['InterestPaid2']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TaxSavings']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TaxSavings']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TaxSavings2']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TaxSavingLosses']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TaxSavingsLosses']; ?>
</td>
			</tr>

			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['BalanceAtRefinance']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['BalanceAtRefinance']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['PointsValue']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['PointsValue']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['AmountReinanced']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AmountFinanced']; ?>
</td>
			</tr>

			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['BalanceAtSale']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['BalanceAtSale']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['BalanceAtSale2']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['BalanceLosses']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['BalanceLosses']; ?>
</td>
			</tr>

			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalLosses']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalLosses']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalClosingCost']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalClosingCost']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalSavings']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPaymentSavings']; ?>
</td>
			</tr>
			<tr class="total last">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalBenefit']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalBenefit']; ?>
</td>
			</tr>
		</table>

		<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>
		<a name="amortization"></a>
		<div class="table-caption schedule"><?php echo $this->_tpl_vars['lang']['OriginalPaymentSchedule']; ?>
</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first"><?php echo $this->_tpl_vars['lang']['PeriodNo']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['InterestPaid']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['Principal']; ?>
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
				<th class="last">&nbsp;</th>
			</tr>
			<tr class="last">
				<td class="first total"><?php echo $this->_tpl_vars['lang']['Total']; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalInterestPaid; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalPrincipalApplied; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalRemainingBalance; ?>
</td>
			</tr>
		</table>
		<?php endif; ?>


		<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>
		<a name="amortization2"></a>
		<div class="table-caption schedule"><?php echo $this->_tpl_vars['lang']['RefinancedPaymentSchedule']; ?>
</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first"><?php echo $this->_tpl_vars['lang']['PeriodNo']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['InterestPaid']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['Principal']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['NewBalance']; ?>
</th>
			</tr>
		<?php if (count($_from = (array)$this->_tpl_vars['vars']['AmortizationTable2']->Schedule)):
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
				<th class="last">&nbsp;</th>
			</tr>
			<tr class="last">
				<td class="first total"><?php echo $this->_tpl_vars['lang']['Total']; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable2']->TotalInterestPaid; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable2']->TotalPrincipalApplied; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable2']->TotalRemainingBalance; ?>
</td>
			</tr>
		</table>
		<?php endif; ?>
	</form>