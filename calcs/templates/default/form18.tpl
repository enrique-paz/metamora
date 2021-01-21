	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc18Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="2">{$lang.LoanInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Amount} : </td>
				<td class="last">
					<input class='text' name='Amount' size='8' value='{$vars.Amount}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Interest} : </td>
				<td class="last">
					<input class='text' name='Interest' size='8' value='{$vars.Interest}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Length} : </td>
				<td class="last">
					<input class='text' name='Length' size='8' value='{$vars.Length}'> ({$lang.Years})
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="2">{$lang.YourTaxRate}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.TaxRate} : </td>
				<td class="last">
					<input class='text' name='Taxes' size='8' value='{$vars.Taxes}'> (%)
				</td>
			</tr>
			
			<tr>
				<td colspan="2" class="chapter" align="center">
					<script language="JavaScript">
						function showPdf()
						{ldelim}
							document.getElementById('PDFGen').value = 1;
							document.getElementById('CalcForm').target = '_blank';
							document.getElementById('CalcForm').submit();
							document.getElementById('CalcForm').target = '';
							document.getElementById('PDFGen').value = 0;
						}
					</script>
					<input type="hidden" id="PDFGen" name="PDFGen" value="0" />
					<a href="javascript:void(showPdf())"><img src='images/pdf-logo.png' width="16" height="16" border="0" align="middle" title="Generate PDF form for that mortgage calculator" /></a>&nbsp;<a href="javascript:void(showPdf())">{$lang.ShowPdfForm}</a>
				</td>
			</tr>

			<tr>
				<td colspan="2" class="chapter">
					<span class="radio">
						<input class='radio' type='checkbox' name='ShowTableSel' id='ShowTableSel' {if ($vars.ShowTableSel eq 1)}checked{/if} value='1'> <label for="ShowTableSel">{$lang.ShowScheduleTable}</label><br/>
					</span>
				</td>
			</tr>

			<tr>
				<td class="button" colspan="2" align="center">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>
		
		<div class="table-caption analysis">{$lang.FinancialAnalysis}</div>
		<table class="results" cellspacing="0">
			<tr class="total">
				<td class="first">&nbsp;</td>
				<td class="td25">{$lang.Standard}
				{if ($vars.ShowTableSel eq 1)}	
					<br>(<a href="#amortization">{$lang.SeeAmortizationTableShort}</a>)
				{/if}
				</td>
				<td class="td25 last">{$lang.BiWeekly}
				{if ($vars.ShowTableSel eq 1)}	
					<br>(<a href="#amortization2">{$lang.SeeAmortizationTableShort}</a>)
				{/if}
				</td>
			</tr>
			<tr>
				<td class="first">{$lang.Length} : </td>
				<td class="td25" nowrap>{$vars.Years} {$lang.YearsShort} {$vars.Months} {$lang.MonthsShort}</td>
				<td class="td25 last" nowrap>{$vars.BiWeeklyYears} {$lang.YearsShort} {$vars.BiWeeklyMonths} {$lang.MonthsShort}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.TimeSaved} : </td>
				<td class="last" colspan="2" align="center">{$vars.YearsSaved} {$lang.YearsShort} {$vars.MonthsSaved} {$lang.MonthsShort}</td>
			</tr>

			<tr>
				<td class="first">{$lang.MonthlyPayment} : </td>
				<td class="td25">{$lang.Currency}{$vars.MonthlyPayment}</td>
				<td class="td25 last">{$lang.Currency}{$vars.BiWeeklyPayment}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalInterestPaid} : </td>
				<td class="td25">{$lang.Currency}{$vars.TotalInterest}</td>
				<td class="td25 last">{$lang.Currency}{$vars.BiWeeklyTotalInterest}</td>
			</tr>

			<tr class="total">
				<td class="first">{$lang.InterestSavings} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.InterestSavings}</td>
			</tr>

			<tr>
				<td class="first result35">{$lang.TaxSavings} : </td>
				<td class="td25">{$lang.Currency}{$vars.TaxSavings}</td>
				<td class="td25 last">{$lang.Currency}{$vars.BiWeeklyTaxSavings}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.TaxSavingLosses} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.TaxSavingLosses}</td>
			</tr>
			<tr class="total last">
				<td class="first">{$lang.TotalBenefits} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.TotalBenefits}</td>
			</tr>

		</table>

		{if ($vars.ShowTableSel eq 1 && not($vars.Years eq null))}
		<a name="amortization"></a>
		<div class="table-caption schedule">{$lang.PaymentSchedule}</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first">{$lang.PeriodNo}</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.TaxSavings}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.NewBalance}</th>
			</tr>
		{foreach item=item from=$vars.AmortizationTable->Schedule}
			{if ($item->Type eq SubTotal)}
			<tr>
				<td class="first subtotal"><nobr>{$item->Period} {$lang.YearShort}<br/><br/></nobr></td>
				<td class="subtotal">---<br/>{$item->InterestPaid}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->TaxSavings}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PrincipalApplied}<br/><br/></td>
				<td class="last">&nbsp;</td>
			</tr>
			{else}
			<tr>
				<td class="first">{$item->Period}</td>
				<td>{$item->InterestPaid}</td>
				<td>{$item->TaxSavings}</td>
				<td>{$item->PrincipalApplied}</td>
				<td class="last">{$item->RemainingBalance}</td>
			</tr>
			{/if}
		{/foreach}
			<tr>
				<th class="first">&nbsp;</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.TaxSavings}</th>
				<th>{$lang.Principal}</th>
				<th class="last">{$lang.RemainingBalance}</th>
			</tr>
			<tr class="last">
				<td class="first total">{$lang.Total}</td>
				<td class="total">{$vars.AmortizationTable->TotalInterestPaid}</td>
				<td class="total">{$vars.AmortizationTable->TotalTaxSavings}</td>
				<td class="total">{$vars.AmortizationTable->TotalPrincipalApplied}</td>
				<td class="total">{$vars.AmortizationTable->TotalRemainingBalance}</td>
			</tr>
		</table>

		<a name="amortization2"></a>
		<div class="table-caption schedule">{$lang.BiWeeklyPaymentSchedule}</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first">{$lang.PeriodNo}</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.TaxSavings}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.NewBalance}</th>
			</tr>
		{foreach item=item from=$vars.BiWeeklyAmortizationTable->Schedule}
			{if ($item->Type eq SubTotal)}
			<tr>
				<td class="first subtotal"><nobr>{$item->Period} {$lang.YearShort}<br/><br/></nobr></td>
				<td class="subtotal">---<br/>{$item->InterestPaid}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->TaxSavings}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PrincipalApplied}<br/><br/></td>
				<td class="last">&nbsp;</td>
			</tr>
			{else}
			<tr>
				<td class="first">{$item->Period}</td>
				<td>{$item->InterestPaid}</td>
				<td>{$item->TaxSavings}</td>
				<td>{$item->PrincipalApplied}</td>
				<td class="last">{$item->RemainingBalance}</td>
			</tr>
			{/if}
		{/foreach}
			<tr>
				<th class="first">&nbsp;</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.TaxSavings}</th>
				<th>{$lang.Principal}</th>
				<th class="last">{$lang.RemainingBalance}</th>
			</tr>
			<tr class="last">
				<td class="first total">{$lang.Total}</td>
				<td class="total">{$vars.BiWeeklyAmortizationTable->TotalInterestPaid}</td>
				<td class="total">{$vars.BiWeeklyAmortizationTable->TotalTaxSavings}</td>
				<td class="total">{$vars.BiWeeklyAmortizationTable->TotalPrincipalApplied}</td>
				<td class="total">{$vars.BiWeeklyAmortizationTable->TotalRemainingBalance}</td>
			</tr>
		</table>

		{/if}
	</form>