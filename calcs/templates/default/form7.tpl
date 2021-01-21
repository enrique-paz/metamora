	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc7Title}</h1>
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
				<td class="first td50">{$lang.InterestWithPoints} : </td>
				<td class="last">
					<input class='text' name='Interest2' size='8' value='{$vars.Interest2}'> (%)
				</td>
			</tr>

			<tr>
				<td class="first td50">{$lang.Length} : </td>
				<td class="last">
					<input class='text' name='Length' size='8' value='{$vars.Length}'> ({$lang.YearsShort})
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="2">{$lang.AdditionalInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Points} : </td>
				<td class="last">
					<input class='text' name='Points' size='8' value='{$vars.Points}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.SavingsRate} : </td>
				<td class="last">
					<input class='text' name='SavingsRate' size='8' value='{$vars.SavingsRate}'> (%)
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
			<tr>
				<td class="first">&nbsp;</td>
				<td class="td25" nowrap>
				{$lang.WithoutPoints}
				{if ($vars.ShowTableSel eq 1)}	
					<br>(<a href="#amortization">{$lang.SeeAmortizationTableShort}</a>)
				{/if}
				</td>
				<td class="td25 last" nowrap>
				{$lang.WithPoints}
				{if ($vars.ShowTableSel eq 1)}	
					<br>(<a href="#amortization2">{$lang.SeeAmortizationTableShort}</a>)
				{/if}
				</td>
			</tr>
			<tr>
				<td class="first">{$lang.AmountFinanced} : </td>
				<td class="td25" nowrap>{$lang.Currency}{$vars.AmountFinanced}</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.AmountFinanced2}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyPI} : </td>
				<td class="td25" nowrap>{$lang.Currency}{$vars.MonthlyPayment}</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.MonthlyPayment2}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyPaymentSavings} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.MonthlyPaymentSavings}</td>
			</tr>
			<tr>
				<td class="first">{$lang.PointsValue} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.PointsValue}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyInvestmentSavings} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.MonthlyInvestmentSavings}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.TrueMonthlySavings} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.TrueMonthlySavings}</td>
			</tr>
			
			<tr class="total last">
				<td class="first">{$lang.BreakEven} : </td>
				<td class="last" colspan="2" align="center">
				{if not($vars.BreakEvenYears eq null and $vars.BreakEvenMonths eq null)}
					{$vars.BreakEvenYears} {$lang.Years} {$vars.BreakEvenMonths} {$lang.Months} 
				{else}
				{$lang.BadData}
				{/if}
				</td>
			</tr>
		</table>

		{if ($vars.ShowTableSel eq 1)}
		<a id="amortization"></a>
		<div class="table-caption schedule">{$lang.PaymentSchedule}</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first">{$lang.PeriodNo}</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.NewBalance}</th>
			</tr>
		{foreach item=item from=$vars.AmortizationTable->Schedule}
			{if ($item->Type eq SubTotal)}
			<tr>
				<td class="first subtotal"><nobr>{$item->Period} {$lang.YearShort}<br/><br/></nobr></td>
				<td class="subtotal">---<br/>{$item->InterestPaid}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PrincipalApplied}<br/><br/></td>
				<td class="last">&nbsp;</td>
			</tr>
			{else}
			<tr>
				<td class="first">{$item->Period}</td>
				<td>{$item->InterestPaid}</td>
				<td>{$item->PrincipalApplied}</td>
				<td class="last">{$item->RemainingBalance}</td>
			</tr>
			{/if}
		{/foreach}
			<tr>
				<th class="first">&nbsp;</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th class="last">&nbsp;</th>
			</tr>
			<tr class="last">
				<td class="first total">{$lang.Total}</td>
				<td class="total">{$vars.AmortizationTable->TotalInterestPaid}</td>
				<td class="total">{$vars.AmortizationTable->TotalPrincipalApplied}</td>
				<td class="total">{$vars.AmortizationTable->TotalRemainingBalance}</td>
			</tr>
		</table>
		
		<a id="amortization2"></a>
		<div class="table-caption schedule">{$lang.PaymentScheduleWithPoints}</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first">{$lang.PeriodNo}</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.NewBalance}</th>
			</tr>
		{foreach item=item from=$vars.AmortizationTable2->Schedule}
			{if ($item->Type eq SubTotal)}
			<tr>
				<td class="first subtotal"><nobr>{$item->Period} {$lang.YearShort}<br/><br/></nobr></td>
				<td class="subtotal">---<br/>{$item->InterestPaid}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PrincipalApplied}<br/><br/></td>
				<td class="last">&nbsp;</td>
			</tr>
			{else}
			<tr>
				<td class="first">{$item->Period}</td>
				<td>{$item->InterestPaid}</td>
				<td>{$item->PrincipalApplied}</td>
				<td class="last">{$item->RemainingBalance}</td>
			</tr>
			{/if}
		{/foreach}
			<tr>
				<th class="first">&nbsp;</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th class="last">&nbsp;</th>
			</tr>
			<tr class="last">
				<td class="first total">{$lang.Total}</td>
				<td class="total">{$vars.AmortizationTable2->TotalPaymentAmount}</td>
				<td class="total">{$vars.AmortizationTable2->TotalPrincipalApplied}</td>
				<td class="total">{$vars.AmortizationTable2->TotalRemainingBalance}</td>
			</tr>
		</table>

		{/if}
	</form>