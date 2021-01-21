	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc1Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="2">{$lang.LoanInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Amount} : </td>
				<td class="last">
					<input class="text" name="Amount" size="8" value="{$vars.Amount}"> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Interest} : </td>
				<td class="last">
					<input class="text" name="Interest" size="8" value="{$vars.Interest}"> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Length} : </td>
				<td class="last">
					<input class="text" name="Length" size="8" value="{$vars.Length}"> ({$lang.YearsShort})
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="2">{$lang.PropertyInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.HomeValue} : </td>
				<td class="last">
					<input class="text" name="HomeValue" size="8" value="{$vars.HomeValue}"> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="2">{$lang.TaxAndInsuranceInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualPropertyTaxes} : </td>
				<td class="last">
					<input class="text" name="PropertyTaxes" size="8" value="{$vars.PropertyTaxes}">
					<span class="radio">
						<input class="radio" type="radio" name="PropertyTaxesSel" id="PropertyTaxesSel0" {if ($vars.PropertyTaxesSel eq 0)}checked{/if} value="0"> <label for="PropertyTaxesSel0">({$lang.Currency})</label>
						<input class="radio" type="radio" name="PropertyTaxesSel" id="PropertyTaxesSel1" {if ($vars.PropertyTaxesSel eq 1)}checked{/if} value="1"> <label for="PropertyTaxesSel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualInsurance} : </td>
				<td class="last">
					<input class="text" name="Insurance" size="8" value="{$vars.Insurance}">
					<span class="radio">
						<input class="radio" type="radio" name="InsuranceSel" id="InsuranceSel0" {if ($vars.InsuranceSel eq 0)}checked{/if} value="0"> <label for="InsuranceSel0">({$lang.Currency})</label>
						<input class="radio" type="radio" name="InsuranceSel" id="InsuranceSel1" {if ($vars.InsuranceSel eq 1)}checked{/if} value="1"> <label for="InsuranceSel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualPMI} : </td>
				<td class="last">
					<input class="text" name="PMI" size="8" value="{$vars.PMI}">
					<span class="radio">
						<input class="radio" type="radio" name="PMISel" id="PMISel0" {if ($vars.PMISel eq 0)}checked{/if} value="0"> <label for="PMISel0">({$lang.Currency})</label>
						<input class="radio" type="radio" name="PMISel" id="PMISel1" {if ($vars.PMISel eq 1)}checked{/if} value="1"> <label for="PMISel1"> (%) </label>
					</span>
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
				<td colspan="2" align="center" class="chapter">
					<span class="radio">
						<input class="radio" type="checkbox" name="ShowTableSel" id="ShowTableSel" {if ($vars.ShowTableSel eq 1)}checked{/if} value="1"> <label for="ShowTableSel">{$lang.ShowScheduleTable}</label><br/>
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
				<td class="first">{$lang.MonthlyPI} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyPayment}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyPropertyTaxes} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyTaxes}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyInsurance} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyInsurance}</td>
			</tr>
			{if not($vars.LoanToValue eq null)}
			<tr>
				<td class="first">{$lang.LTV} : </td>
				<td class="last">{$vars.LoanToValue}%</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthsWithPMI} : </td>
				<td class="last">{$vars.MonthsWithPMI}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyPMI} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyPMI}</td>
			</tr>
			{/if}
			<tr class="total last">
				<td class="first">{$lang.TotalMonthlyPayment} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyTotal}</td>
			</tr>
		</table>

		{if ($vars.ShowTableSel eq 1)}
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
				<td class="total">{$vars.AmortizationTable->TotalRemainingBalance}</td>
			</tr>
		</table>
		{/if}
	</form>