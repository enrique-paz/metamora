<?php /* Smarty version 2.6.2, created on 2008-05-04 02:01:37
         compiled from default/form10.tpl */ ?>
	<form method="POST" id="CalcForm">
		<h1><?php echo $this->_tpl_vars['lang']['Calc10Title']; ?>
</h1>
		<div class="table-caption inputinfo"><?php echo $this->_tpl_vars['lang']['InputInfo']; ?>
</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="4"><?php echo $this->_tpl_vars['lang']['PropertyInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2"><?php echo $this->_tpl_vars['lang']['HomeValue']; ?>
 : </td>
				<td colspan="2" class="last">
					<input class='text' name='HomeValue' size='8' value='<?php echo $this->_tpl_vars['vars']['HomeValue']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="4"><?php echo $this->_tpl_vars['lang']['AdditionalInfo']; ?>
</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2"><?php echo $this->_tpl_vars['lang']['AnnualPMI']; ?>
 : </td>
				<td colspan="2" class="last">
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
				<td class="first td50" colspan="2"><?php echo $this->_tpl_vars['lang']['DownPayment']; ?>
 : </td>
				<td colspan="2" class="last">
					<span class="radio">
						<input class='radio' type='radio' name='DownPayment' id='DownPayment1' <?php if (( $this->_tpl_vars['vars']['DownPayment'] == 5 )): ?>checked<?php endif; ?> value='5'> <label for="DownPayment1"> 5 % </label>
						<input class='radio' type='radio' name='DownPayment' id='DownPayment2' <?php if (( $this->_tpl_vars['vars']['DownPayment'] == 10 )): ?>checked<?php endif; ?> value='10'> <label for="DownPayment2"> 10 % </label>
						<input class='radio' type='radio' name='DownPayment' id='DownPayment3' <?php if (( $this->_tpl_vars['vars']['DownPayment'] == 15 )): ?>checked<?php endif; ?> value='15'> <label for="DownPayment3"> 15 % </label>
					</span>
				</td>
			</tr>

			<tr>
				<td class="td25 first">&nbsp;</td>
				<td class="chapter25">
					<?php echo $this->_tpl_vars['lang']['Standard']; ?>

					
				</td>
				<td class="chapter25">
					<?php echo $this->_tpl_vars['lang']['80PercentLoan']; ?>

				
				</td>
				<td class="chapter25 last">
					<?php echo $this->_tpl_vars['lang']['SecondLoan']; ?>

				
				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['Interest']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='Interest' size='8' value='<?php echo $this->_tpl_vars['vars']['Interest']; ?>
'> (%)
				</td>
				<td class="td25">
					<input class='text' name='Interest2' size='8' value='<?php echo $this->_tpl_vars['vars']['Interest2']; ?>
'> (%)
				</td>
				<td class="td25 last">
					<input class='text' name='Interest3' size='8' value='<?php echo $this->_tpl_vars['vars']['Interest3']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['Length']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='Length' size='8' value='<?php echo $this->_tpl_vars['vars']['Length']; ?>
'> <?php echo $this->_tpl_vars['lang']['YearsShort']; ?>

				</td>
				<td class="td25">
					<input class='text' name='Length2' size='8' value='<?php echo $this->_tpl_vars['vars']['Length2']; ?>
'> <?php echo $this->_tpl_vars['lang']['YearsShort']; ?>

				</td>
				<td class="td25 last">
					<input class='text' name='Length3' size='8' value='<?php echo $this->_tpl_vars['vars']['Length3']; ?>
'> <?php echo $this->_tpl_vars['lang']['YearsShort']; ?>

				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['Points']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='Points' size='8' value='<?php echo $this->_tpl_vars['vars']['Points']; ?>
'> (%)
				</td>
				<td class="td25">
					<input class='text' name='Points2' size='8' value='<?php echo $this->_tpl_vars['vars']['Points2']; ?>
'> (%)
				</td>
				<td class="td25 last">
					<input class='text' name='Points3' size='8' value='<?php echo $this->_tpl_vars['vars']['Points3']; ?>
'> (%)
				</td>
			</tr>
			<tr>
				<td class="td25 first"><?php echo $this->_tpl_vars['lang']['ClosingCost']; ?>
 : </td>
				<td class="td25">
					<input class='text' name='Closing' size='8' value='<?php echo $this->_tpl_vars['vars']['Closing']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
				<td class="td25">
					<input class='text' name='Closing2' size='8' value='<?php echo $this->_tpl_vars['vars']['Closing2']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
				</td>
				<td class="td25 last">
					<input class='text' name='Closing3' size='8' value='<?php echo $this->_tpl_vars['vars']['Closing3']; ?>
'> (<?php echo $this->_tpl_vars['lang']['Currency']; ?>
)
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
				<td colspan="4" class="chapter">
					<span class="radio">
						<input class='radio' type='checkbox' name='ShowTableSel' id='ShowTableSel' <?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>checked<?php endif; ?> value='1'> <label for="ShowTableSel"><?php echo $this->_tpl_vars['lang']['ShowScheduleTable']; ?>
</label><br/>
					</span>
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
				<td class="td25">
				<?php echo $this->_tpl_vars['lang']['Standard']; ?>

				<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>	
					<br>(<a href="#amortization"><?php echo $this->_tpl_vars['lang']['SeeAmortizationTableShort']; ?>
</a>)
				<?php endif; ?>
				</td>
				<td class="td25">
					<?php echo $this->_tpl_vars['lang']['80PercentLoan']; ?>

					<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>	
						<br>(<a href="#amortization2"><?php echo $this->_tpl_vars['lang']['SeeAmortizationTableShort']; ?>
</a>)
					<?php endif; ?>
				</td>
				<td class="td25 last">
					<?php echo $this->_tpl_vars['lang']['Second']; ?>

					<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>	
						<br><nobr>(<a href="#amortization2"><?php echo $this->_tpl_vars['lang']['SeeAmortizationTableShort']; ?>
</a>)</nobr>
					<?php endif; ?>
					</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['PointsValue']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['PointsValue']; ?>
</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['PointsValue2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['PointsValue3']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['ClosingCost']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['Closing']; ?>
</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['Closing2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['Closing3']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalClosingCost']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalClosing']; ?>
</td>
				<td class="td25 last" colspan="2"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalClosing2and3']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['DownPayment']; ?>
 : </td>
				<td class="td25 last" colspan="3"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['DownPaymentValue']; ?>
</td>
			</tr>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['UpfrontCost']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['Upfront']; ?>
</td>
				<td class="td25 last" colspan="2"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['Upfront2and3']; ?>
</td>
			</tr>

			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['AmountFinanced']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AmountFinanced']; ?>
</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AmountFinanced2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['AmountFinanced3']; ?>
</td>
			</tr>

			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPIShort']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPayment']; ?>
</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPayment2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPayment3']; ?>
</td>
			</tr>
			<?php if (! ( $this->_tpl_vars['vars']['LoanToValue'] == null )): ?>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthsWithPMI']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['vars']['MonthsWithPMI']; ?>
</td>
				<td class="td25">0</td>
				<td class="td25 last">0</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPMI']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPMI']; ?>
</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPMI2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyPMI3']; ?>
</td>
			</tr>
			<?php endif; ?>
			<tr class="total">
				<td class="first"><?php echo $this->_tpl_vars['lang']['MonthlyPayment']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyTotal']; ?>
</td>
				<td class="td25 last" colspan="2"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['MonthlyTotal2and3']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalInterestPaid']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalInterestPaid']; ?>
</td>
				<td class="td25 last" colspan="2"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalInterestPaid2and3']; ?>
</td>
			</tr>
			<tr>
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalPMI']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPMI']; ?>
</td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPMI2']; ?>
</td>
				<td class="td25 last"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPMI3']; ?>
</td>
			</tr>
			<tr class="total last">
				<td class="first"><?php echo $this->_tpl_vars['lang']['TotalPaymentAmount']; ?>
 : </td>
				<td class="td25"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPaymentAmount']; ?>
</td>
				<td class="td25 last" colspan="2"><?php echo $this->_tpl_vars['lang']['Currency'];  echo $this->_tpl_vars['vars']['TotalPaymentAmount2and3']; ?>
</td>
			</tr>

		</table>

		<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>
		<a name="amortization"></a>
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
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalInterestPaid; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalPrincipalApplied; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalPMI; ?>
</td>
				<td class="total">&nbsp;</td>
			</tr>
		</table>
		<?php endif; ?>

		<?php if (( $this->_tpl_vars['vars']['ShowTableSel'] == 1 )): ?>
		<a name="amortization2"></a>
		<div class="table-caption schedule"><?php echo $this->_tpl_vars['lang']['ConsolidatedSchFor2Loans']; ?>
</div>
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
		<?php if (count($_from = (array)$this->_tpl_vars['vars']['AmortizationTable2and3']->Schedule)):
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
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable2and3']->TotalInterestPaid; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable2and3']->TotalPrincipalApplied; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable2and3']->TotalPMI; ?>
</td>
				<td class="total"><?php echo $this->_tpl_vars['vars']['AmortizationTable']->TotalRemainingBalance; ?>
</td>
			</tr>
		</table>
		<?php endif; ?>
	</form>