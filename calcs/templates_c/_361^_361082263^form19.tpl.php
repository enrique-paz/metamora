<?php /* Smarty version 2.6.2, created on 2008-05-01 11:18:24
         compiled from default/form19.tpl */ ?>
	<form method="POST" id="CalcForm">
		<h1><?php echo $this->_tpl_vars['lang']['Calc19Title']; ?>
</h1>
		<div class="table-caption inputinfo"><?php echo $this->_tpl_vars['lang']['InputInfo']; ?>
</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['RentInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['PeriodRent']; ?>
 : </td>
				<td class="last">
					<input class='text' name='PeriodRent' size='8' value='<?php echo $this->_tpl_vars['vars']['PeriodRent']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['AnnualRentIncrease']; ?>
 : </td>
				<td class="last">
					<input class='text' name='AnnualRentIncrease' size='8' value='<?php echo $this->_tpl_vars['vars']['AnnualRentIncrease']; ?>
'> (%)
				</td>
			</tr>

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
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['AnnualMaintanance']; ?>
 : </td>
				<td class="last">
					<input class='text' name='AnnualMaintanance' size='8' value='<?php echo $this->_tpl_vars['vars']['AnnualMaintanance']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['AnnualAppreciation']; ?>
 : </td>
				<td class="last">
					<input class='text' name='AnnualAppreciation' size='8' value='<?php echo $this->_tpl_vars['vars']['AnnualAppreciation']; ?>
'> (%)
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
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['SellingCost']; ?>
 : </td>
				<td class="last">
					<input class='text' name='SellingCost' size='8' value='<?php echo $this->_tpl_vars['vars']['SellingCost']; ?>
'> (%)
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
				<td class="chapter" colspan="2"><?php echo $this->_tpl_vars['lang']['TaxAndInsuranceInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['YourTaxRate']; ?>
 : </td>
				<td class="last">
					<input class='text' name='Taxes' size='8' value='<?php echo $this->_tpl_vars['vars']['Taxes']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50"><?php echo $this->_tpl_vars['lang']['AnnualPropertyTaxes']; ?>
 : </td>
				<td class="last">
					<input class='text' name='PropertyTaxes' size='8' value='<?php echo $this->_tpl_vars['vars']['PropertyTaxes']; ?>
'>
					<span class="radio">
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel0' <?php if (( $this->_tpl_vars['vars']['PropertyTaxesSel'] == '0' )): ?>checked<?php endif; ?> value='0'> <label for="PropertyTaxesSel0">(<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</label>
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel1' <?php if (( $this->_tpl_vars['vars']['PropertyTaxesSel'] == '1' )): ?>checked<?php endif; ?> value='1'> <label for="PropertyTaxesSel1"> (%) </label>
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
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel0' <?php if (( $this->_tpl_vars['vars']['InsuranceSel'] == '0' )): ?>checked<?php endif; ?> value='0'> <label for="InsuranceSel0">(<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</label>
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel1' <?php if (( $this->_tpl_vars['vars']['InsuranceSel'] == '1' )): ?>checked<?php endif; ?> value='1'> <label for="InsuranceSel1"> (%) </label>
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
						<input class='radio' type='radio' name='PMISel' id='PMISel0' <?php if (( $this->_tpl_vars['vars']['PMISel'] == '0' )): ?>checked<?php endif; ?> value='0'> <label for="PMISel0">(<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)</label>
						<input class='radio' type='radio' name='PMISel' id='PMISel1' <?php if (( $this->_tpl_vars['vars']['PMISel'] == '1' )): ?>checked<?php endif; ?> value='1'> <label for="PMISel1"> (%) </label>
					</span>
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
				<td colspan="2" align="center" class="chapter">
					<span class="radio">
						<input class='radio' type='checkbox' name='ShowTableSel' id='ShowTableSel' <?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == '1' )): ?>checked<?php endif; ?> value='1'> <label for="ShowTableSel"><?php echo $this->_tpl_vars['lang']['ShowScheduleTable']; ?>
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
			<tr class="total">
				<td class="first">&nbsp;</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Rent']; ?>

				<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == '1' )): ?>	
					<br>
				<?php endif; ?>
				</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Buy']; ?>

				<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == '1' )): ?>	
					<br>(<a href="#amortization"><?php echo $this->_tpl_vars['lang']['SeeAmortizationTableShort']; ?>
</a>)
				<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TaxesAndInsurance']; ?>
 : </td>
				<td class="td25" nowrap><?php echo $this->_tpl_vars['lang']['Currency']; ?>
0.00</td>
				<td class="td25 last" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalTaxesAndInsurance2']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalPMI']; ?>
 : </td>
				<td class="td25" nowrap><?php echo $this->_tpl_vars['lang']['Currency']; ?>
0.00</td>
				<td class="td25 last" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPMI2']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalMaintanance']; ?>
 : </td>
				<td class="td25" nowrap><?php echo $this->_tpl_vars['lang']['Currency']; ?>
0.00</td>
				<td class="td25 last" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalMaintanance2']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalPaymentAmount']; ?>
 : </td>
				<td class="td25" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPaymentAmount']; ?>
</td>
				<td class="td25 last" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPaymentAmount2']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['AveragePeriodPayment']; ?>
 : </td>
				<td class="td25" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AveragePeriodPayment']; ?>
</td>
				<td class="td25 last" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AveragePeriodPayment2']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['PeriodRentSavings']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['PeriodRentSavings']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TaxSavings']; ?>
 : </td>
				<td class="td25" nowrap><?php echo $this->_tpl_vars['lang']['Currency']; ?>
0.00</td>
				<td class="td25 last" nowrap><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TaxSavings2']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalRentSavings']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalRentSavings']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['HouseAppreciationValue']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['HouseAppreciationValue']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['ProceedsMinusCost']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['ProceedsMinusCost']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['LoanBalance']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['LoanBalance']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['EquityAppreciation']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['EquityAppreciation']; ?>
</td>
			</tr>
			<tr class="total last">
				<td class="first"><?php echo $this->_tpl_vars['lang']['HomePurchaseBenefits']; ?>
 : </td>
				<td class="last" colspan="2" align="center"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['HomePurchaseBenefits']; ?>
</td>
			</tr>
		</table>

		<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == '1' )): ?>
		<div class="table-caption schedule">Payment Schedule</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first"><?php echo $this->_tpl_vars['lang']['PeriodNo']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['InterestPaid']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['Principal']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['PMI']; ?>
</th>
				<th><?php echo $this->_tpl_vars['lang']['NewBalance']; ?>
</th>
			</tr>
		<?php if (count($_from = (array)$this->_tpl_vars['vars']['AmortizationTable2']->Schedule)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<?php if (( $this->_tpl_vars['item']->Type == 'SubTotal' )): ?>
			<tr>
				<td class="first subtotal"><nobr><?php echo $this->_tpl_vars['item']->Period; ?>
 <?php echo $this->_tpl_vars['lang']['YearShort']; ?>
<br/><br/></nobr></td>
				<td class="subtotal">---<br/><?php echo $this->_tpl_vars['item']->InterestPaid; ?>
<br/><br/></td>
				<td class="subtotal">---<br/><?php echo $this->_tpl_vars['item']->PrincipalApplied; ?>
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
				<th><?php echo $this->_tpl_vars['lang']['PMI']; ?>
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
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable2']->TotalPMI; ?>
</td>
				<td class="total last"><?php echo $this->_tpl_vars['vars']['AmortizationTable2']->TotalRemainingBalance; ?>
</td>
			</tr>
		</table>
		<?php endif; ?>
	</form>