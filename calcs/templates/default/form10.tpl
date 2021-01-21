	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc10Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="4">{$lang.PropertyInfo}</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.HomeValue} : </td>
				<td colspan="2" class="last">
					<input class='text' name='HomeValue' size='8' value='{$vars.HomeValue}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="4">{$lang.AdditionalInfo}</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.AnnualPMI} : </td>
				<td colspan="2" class="last">
					<input class='text' name='PMI' size='8' value='{$vars.PMI}'>
					<span class="radio">
						<input class='radio' type='radio' name='PMISel' id='PMISel0' {if ($vars.PMISel eq 0)}checked{/if} value='0'> <label for="PMISel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='PMISel' id='PMISel1' {if ($vars.PMISel eq 1)}checked{/if} value='1'> <label for="PMISel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.DownPayment} : </td>
				<td colspan="2" class="last">
					<span class="radio">
						<input class='radio' type='radio' name='DownPayment' id='DownPayment1' {if ($vars.DownPayment eq 5)}checked{/if} value='5'> <label for="DownPayment1"> 5 % </label>
						<input class='radio' type='radio' name='DownPayment' id='DownPayment2' {if ($vars.DownPayment eq 10)}checked{/if} value='10'> <label for="DownPayment2"> 10 % </label>
						<input class='radio' type='radio' name='DownPayment' id='DownPayment3' {if ($vars.DownPayment eq 15)}checked{/if} value='15'> <label for="DownPayment3"> 15 % </label>
					</span>
				</td>
			</tr>

			<tr>
				<td class="td25 first">&nbsp;</td>
				<td class="chapter25">
					{$lang.Standard}
					
				</td>
				<td class="chapter25">
					{$lang.80PercentLoan}
				
				</td>
				<td class="chapter25 last">
					{$lang.SecondLoan}
				
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Interest} : </td>
				<td class="td25">
					<input class='text' name='Interest' size='8' value='{$vars.Interest}'> (%)
				</td>
				<td class="td25">
					<input class='text' name='Interest2' size='8' value='{$vars.Interest2}'> (%)
				</td>
				<td class="td25 last">
					<input class='text' name='Interest3' size='8' value='{$vars.Interest3}'> (%)
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Length} : </td>
				<td class="td25">
					<input class='text' name='Length' size='8' value='{$vars.Length}'> {$lang.YearsShort}
				</td>
				<td class="td25">
					<input class='text' name='Length2' size='8' value='{$vars.Length2}'> {$lang.YearsShort}
				</td>
				<td class="td25 last">
					<input class='text' name='Length3' size='8' value='{$vars.Length3}'> {$lang.YearsShort}
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Points} : </td>
				<td class="td25">
					<input class='text' name='Points' size='8' value='{$vars.Points}'> (%)
				</td>
				<td class="td25">
					<input class='text' name='Points2' size='8' value='{$vars.Points2}'> (%)
				</td>
				<td class="td25 last">
					<input class='text' name='Points3' size='8' value='{$vars.Points3}'> (%)
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.ClosingCost} : </td>
				<td class="td25">
					<input class='text' name='Closing' size='8' value='{$vars.Closing}'> ({$lang.Currency})
				</td>
				<td class="td25">
					<input class='text' name='Closing2' size='8' value='{$vars.Closing2}'> ({$lang.Currency})
				</td>
				<td class="td25 last">
					<input class='text' name='Closing3' size='8' value='{$vars.Closing3}'> ({$lang.Currency})
				</td>
			</tr>
			
			<tr>
				<td colspan="4" class="chapter" align="center">
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
				<td colspan="4" class="chapter">
					<span class="radio">
						<input class='radio' type='checkbox' name='ShowTableSel' id='ShowTableSel' {if ($vars.ShowTableSel eq 1)}checked{/if} value='1'> <label for="ShowTableSel">{$lang.ShowScheduleTable}</label><br/>
					</span>
				</td>
			</tr>
			<tr>
				<td class="button" colspan="4" align="center">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>
		<div class="table-caption analysis">{$lang.FinancialAnalysis}</div>
		<table class="results" cellspacing="0">
			<tr class="total">
				<td class="first">&nbsp;</td>
				<td class="td25">
				{$lang.Standard}
				{if ($vars.ShowTableSel eq 1)}	
					<br>(<a href="#amortization">{$lang.SeeAmortizationTableShort}</a>)
				{/if}
				</td>
				<td class="td25">
					{$lang.80PercentLoan}
					{if ($vars.ShowTableSel eq 1)}	
						<br>(<a href="#amortization2">{$lang.SeeAmortizationTableShort}</a>)
					{/if}
				</td>
				<td class="td25 last">
					{$lang.Second}
					{if ($vars.ShowTableSel eq 1)}	
						<br><nobr>(<a href="#amortization2">{$lang.SeeAmortizationTableShort}</a>)</nobr>
					{/if}
					</td>
			</tr>
			<tr>
				<td class="first">{$lang.PointsValue} : </td>
				<td class="td25">{$lang.Currency}{$vars.PointsValue}</td>
				<td class="td25">{$lang.Currency}{$vars.PointsValue2}</td>
				<td class="td25 last">{$lang.Currency}{$vars.PointsValue3}</td>
			</tr>
			<tr>
				<td class="first">{$lang.ClosingCost} : </td>
				<td class="td25">{$lang.Currency}{$vars.Closing}</td>
				<td class="td25">{$lang.Currency}{$vars.Closing2}</td>
				<td class="td25 last">{$lang.Currency}{$vars.Closing3}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalClosingCost} : </td>
				<td class="td25">{$lang.Currency}{$vars.TotalClosing}</td>
				<td class="td25 last" colspan="2">{$lang.Currency}{$vars.TotalClosing2and3}</td>
			</tr>
			<tr>
				<td class="first">{$lang.DownPayment} : </td>
				<td class="td25 last" colspan="3">{$lang.Currency}{$vars.DownPaymentValue}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.UpfrontCost} : </td>
				<td class="td25">{$lang.Currency}{$vars.Upfront}</td>
				<td class="td25 last" colspan="2">{$lang.Currency}{$vars.Upfront2and3}</td>
			</tr>

			<tr class="total">
				<td class="first">{$lang.AmountFinanced} : </td>
				<td class="td25">{$lang.Currency}{$vars.AmountFinanced}</td>
				<td class="td25">{$lang.Currency}{$vars.AmountFinanced2}</td>
				<td class="td25 last">{$lang.Currency}{$vars.AmountFinanced3}</td>
			</tr>

			<tr>
				<td class="first">{$lang.MonthlyPIShort} : </td>
				<td class="td25">{$lang.Currency}{$vars.MonthlyPayment}</td>
				<td class="td25">{$lang.Currency}{$vars.MonthlyPayment2}</td>
				<td class="td25 last">{$lang.Currency}{$vars.MonthlyPayment3}</td>
			</tr>
			{if not($vars.LoanToValue eq null)}
			<tr>
				<td class="first">{$lang.MonthsWithPMI} : </td>
				<td class="td25">{$vars.MonthsWithPMI}</td>
				<td class="td25">0</td>
				<td class="td25 last">0</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyPMI} : </td>
				<td class="td25">{$lang.Currency}{$vars.MonthlyPMI}</td>
				<td class="td25">{$lang.Currency}{$vars.MonthlyPMI2}</td>
				<td class="td25 last">{$lang.Currency}{$vars.MonthlyPMI3}</td>
			</tr>
			{/if}
			<tr class="total">
				<td class="first">{$lang.MonthlyPayment} : </td>
				<td class="td25">{$lang.Currency}{$vars.MonthlyTotal}</td>
				<td class="td25 last" colspan="2">{$lang.Currency}{$vars.MonthlyTotal2and3}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalInterestPaid} : </td>
				<td class="td25">{$lang.Currency}{$vars.TotalInterestPaid}</td>
				<td class="td25 last" colspan="2">{$lang.Currency}{$vars.TotalInterestPaid2and3}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalPMI} : </td>
				<td class="td25">{$lang.Currency}{$vars.TotalPMI}</td>
				<td class="td25">{$lang.Currency}{$vars.TotalPMI2}</td>
				<td class="td25 last">{$lang.Currency}{$vars.TotalPMI3}</td>
			</tr>
			<tr class="total last">
				<td class="first">{$lang.TotalPaymentAmount} : </td>
				<td class="td25">{$lang.Currency}{$vars.TotalPaymentAmount}</td>
				<td class="td25 last" colspan="2">{$lang.Currency}{$vars.TotalPaymentAmount2and3}</td>
			</tr>

		</table>

		{if ($vars.ShowTableSel eq 1)}
		<a name="amortization"></a>
		<div class="table-caption schedule">{$lang.PaymentSchedule}</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first">{$lang.PeriodNo}</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.PMI}</th>
				<th>{$lang.NewBalance}</th>
			</tr>
		{foreach item=item from=$vars.AmortizationTable->Schedule}
			{if ($item->Type eq SubTotal)}
			<tr>
				<td class="first subtotal"><nobr>{$item->Period} {$lang.YearShort}<br/><br/></nobr></td>
				<td class="subtotal">---<br/>{$item->InterestPaid}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PrincipalApplied}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PMI}<br/><br/></td>
				<td class="last">&nbsp;</td>
			</tr>
			{else}
			<tr>
				<td class="first">{$item->Period}</td>
				<td>{$item->InterestPaid}</td>
				<td>{$item->PrincipalApplied}</td>
				<td>{$item->PMI}</td>
				<td class="last">{$item->RemainingBalance}</td>
			</tr>
			{/if}
		{/foreach}
			<tr>
				<th class="first">&nbsp;</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.PMI}</th>
				<th class="last">&nbsp;</th>
			</tr>
			<tr class="last">
				<td class="first total">{$lang.Total}</td>
				<td class="total">{$vars.AmortizationTable->TotalInterestPaid}</td>
				<td class="total">{$vars.AmortizationTable->TotalPrincipalApplied}</td>
				<td class="total">{$vars.AmortizationTable->TotalPMI}</td>
				<td class="total">&nbsp;</td>
			</tr>
		</table>
		{/if}

		{if ($vars.ShowTableSel eq 1)}
		<a name="amortization2"></a>
		<div class="table-caption schedule">{$lang.ConsolidatedSchFor2Loans}</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first">{$lang.PeriodNo}</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.PMI}</th>
				<th>{$lang.NewBalance}</th>
			</tr>
		{foreach item=item from=$vars.AmortizationTable2and3->Schedule}
			{if ($item->Type eq SubTotal)}
			<tr>
				<td class="first subtotal"><nobr>{$item->Period} {$lang.YearShort}<br/><br/></nobr></td>
				<td class="subtotal">---<br/>{$item->InterestPaid}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PrincipalApplied}<br/><br/></td>
				<td class="subtotal">---<br/>{$item->PMI}<br/><br/></td>
				<td class="last">&nbsp;</td>
			</tr>
			{else}
			<tr>
				<td class="first">{$item->Period}</td>
				<td>{$item->InterestPaid}</td>
				<td>{$item->PrincipalApplied}</td>
				<td>{$item->PMI}</td>
				<td class="last">{$item->RemainingBalance}</td>
			</tr>
			{/if}
		{/foreach}
			<tr>
				<th class="first">&nbsp;</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.PMI}</th>
				<th class="last">&nbsp;</th>
			</tr>
			<tr class="last">
				<td class="first total">{$lang.Total}</td>
				<td class="total">{$vars.AmortizationTable2and3->TotalInterestPaid}</td>
				<td class="total">{$vars.AmortizationTable2and3->TotalPrincipalApplied}</td>
				<td class="total">{$vars.AmortizationTable2and3->TotalPMI}</td>
				<td class="total">{$vars.AmortizationTable->TotalRemainingBalance}</td>
			</tr>
		</table>
		{/if}
	</form>