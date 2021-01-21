	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc4Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="4">{$lang.LoanInfo}</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.DownPayment} : </td>
				<td colspan="2" class="last">
					<input class='text' name='DownPayment' size='8' value='{$vars.DownPayment}'>
					<span class="radio">
						<input class='radio' type='radio' name='DownPaymentSel' id='DownPaymentSel0' {if ($vars.DownPaymentSel eq 0)}checked{/if} value='0'> <label for="DownPaymentSel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='DownPaymentSel' id='DownPaymentSel1' {if ($vars.DownPaymentSel eq 1)}checked{/if} value='1'> <label for="DownPaymentSel1"> (%) </label>
					</span>
				</td>
			</tr>

			<tr>
				<td class="first td50" colspan="2">{$lang.Interest} : </td>
				<td colspan="2" class="last">
					<input class='text' name='Interest' size='8' value='{$vars.Interest}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.Length} : </td>
				<td colspan="2" class="last">
					<input class='text' name='Length' size='8' value='{$vars.Length}'> ({$lang.YearsShort})
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.EstimatedFrontRatio} : </td>
				<td colspan="2" class="last">
					<input class='text' name='FrontRatio' size='8' value='{$vars.FrontRatio}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.EstimatedBackRatio} : </td>
				<td colspan="2" class="last">
					<input class='text' name='BackRatio' size='8' value='{$vars.BackRatio}'> (%)
				</td>
			</tr>

			<tr>
				<td class="chapter50 first" colspan="2">{$lang.IncomeInfo}</td>
				<td class="chapter50 last"  colspan="2">{$lang.DebtPaymentInfo}</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Income} : </td>
				<td class="td25">
					<input class='text' name='Income' size='8' value='{$vars.Income}'> ({$lang.Currency})
				</td>
				<td class="td25 righttext">{$lang.AutoLoansPayment} : </td>
				<td class="td25 last">
					<input class='text' name='DebtPayment' size='8' value='{$vars.DebtPayment}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Income2} : </td>
				<td class="td25">
					<input class='text' name='Income2' size='8' value='{$vars.Income2}'> ({$lang.Currency})
				</td class="td25">
				<td class="td25 righttext">{$lang.StudentLoansPayment} : </td>
				<td class="td25 last">
					<input class='text' name='DebtPayment2' size='8' value='{$vars.DebtPayment2}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Income3} : </td>
				<td class="td25">
					<input class='text' name='Income3' size='8' value='{$vars.Income3}'> ({$lang.Currency})
				</td>
				<td class="td25 righttext">{$lang.InstallmentLoansPayment} : </td>
				<td class="td25 last">
					<input class='text' name='DebtPayment3' size='8' value='{$vars.DebtPayment3}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Income4} : </td>
				<td class="td25">
					<input class='text' name='Income4' size='8' value='{$vars.Income4}'> ({$lang.Currency})
				</td>
				<td class="td25 righttext">{$lang.RevolvingAccountsPayment} : </td>
				<td class="td25 last">
					<input class='text' name='DebtPayment4' size='8' value='{$vars.DebtPayment4}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.Income5} : </td>
				<td class="td25">
					<input class='text' name='Income5' size='8' value='{$vars.Income5}'> ({$lang.Currency})
				</td>
				<td class="td25 righttext">{$lang.OtherDebtPayment} : </td>
				<td class="td25 last">
					<input class='text' name='DebtPayment5' size='8' value='{$vars.DebtPayment5}'> ({$lang.Currency})
				</td>
			</tr>

			
			<tr>
				<td class="chapter" colspan="4">{$lang.TaxAndInsuranceInfo}</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.AnnualPropertyTaxes} : </td>
				<td colspan="2" class="last">
					<input class='text' name='PropertyTaxes' size='8' value='{$vars.PropertyTaxes}'>
					<span class="radio">
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel0' {if ($vars.PropertyTaxesSel eq 0)}checked{/if} value='0'> <label for="PropertyTaxesSel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel1' {if ($vars.PropertyTaxesSel eq 1)}checked{/if} value='1'> <label for="PropertyTaxesSel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.AnnualInsurance} : </td>
				<td colspan="2" class="last">
					<input class='text' name='Insurance' size='8' value='{$vars.Insurance}'>
					<span class="radio">
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel0' {if ($vars.InsuranceSel eq 0)}checked{/if} value='0'> <label for="InsuranceSel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel1' {if ($vars.InsuranceSel eq 1)}checked{/if} value='1'> <label for="InsuranceSel1"> (%) </label>
					</span>
				</td>
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
				<td class="first">{$lang.MonthlyPMI} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyPMI}</td>
			</tr>
			{/if}

			<tr class="total">
				<td class="first">{$lang.TotalMonthlyPayment} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyTotal}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyIncome} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyIncome}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyDebtPayments} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyDebtPayments}</td>
			</tr>
			<tr>
				<td class="first">{$lang.ActualFrontRatio} : </td>
				<td class="last">{$vars.ActualFrontRatio} %</td>
			</tr>
			<tr>
				<td class="first">{$lang.ActualBackRatio} : </td>
				<td class="last">{$vars.ActualBackRatio} %</td>
			</tr>

			<tr class="total">
				<td class="first">{$lang.Amount} : </td>
				<td class="last">{$lang.Currency}{$vars.Amount}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.DownPayment} : </td>
				<td class="last">{$lang.Currency}{$vars.DownPaymentValue}</td>
			</tr>
			<tr class="total last">
				<td class="first">{$lang.HomeValue} : </td>
				<td class="last">{$lang.Currency}{$vars.HomeValue}</td>
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