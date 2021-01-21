<?php /* Smarty version 2.6.2, created on 2008-04-09 21:39:23
         compiled from default/form3.tpl */ ?>
	<form method="POST" id="CalcForm">
		<h1><?php echo $this->_tpl_vars['lang']['Calc3Title']; ?>
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
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['PeriodPayment']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['MonthlyPayment']; ?>
 : </td>
				<td class="last">
					<input class='text' name='PeriodPayment' size='8' value='<?php echo $this->_tpl_vars['vars']['PeriodPayment']; ?>
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
				<td class="first"><?php echo $this->_tpl_vars['lang']['OriginalPayment']; ?>
 : </td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['OriginalPayment']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['NewPayment']; ?>
 : </td>
				<td class="last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['PeriodPayment']; ?>
</td>
			</tr>
			<tr class="total last">
				<td class="first"><?php echo $this->_tpl_vars['lang']['NewLength']; ?>
 : </td>
				<td class="last">
				<?php if (! ( $this->_tpl_vars['vars']['Years'] == null && $this->_tpl_vars['vars']['Months'] == null )): ?>
					<?php echo $this->_tpl_vars['vars']['Years']; ?>
 <?php echo $this->_tpl_vars['lang']['Years']; ?>
 <?php echo $this->_tpl_vars['vars']['Months']; ?>
 <?php echo $this->_tpl_vars['lang']['Months']; ?>
 
				<?php else: ?>
				<?php echo $this->_tpl_vars['lang']['BadLength']; ?>

				<?php endif; ?>
				</td>
			</tr>
		</table>

		<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 && ! ( $this->_tpl_vars['vars']['Years'] == null && $this->_tpl_vars['vars']['Months'] == null ) )): ?>
		<div class="table-caption schedule"><?php echo $this->_tpl_vars['lang']['PaymentSchedule']; ?>
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
				<th class="last"><?php echo $this->_tpl_vars['lang']['RemainingBalance']; ?>
</th>
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
	</form>