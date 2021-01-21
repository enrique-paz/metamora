	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc19Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="2">{$lang.RentInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.PeriodRent} : </td>
				<td class="last">
					<input class='text' name='PeriodRent' size='8' value='{$vars.PeriodRent}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualRentIncrease} : </td>
				<td class="last">
					<input class='text' name='AnnualRentIncrease' size='8' value='{$vars.AnnualRentIncrease}'> (%)
				</td>
			</tr>

			<tr>
				<td class="chapter" colspan="2">{$lang.PropertyInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.HomeValue} : </td>
				<td class="last">
					<input class='text' name='HomeValue' size='8' value='{$vars.HomeValue}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualMaintanance} : </td>
				<td class="last">
					<input class='text' name='AnnualMaintanance' size='8' value='{$vars.AnnualMaintanance}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualAppreciation} : </td>
				<td class="last">
					<input class='text' name='AnnualAppreciation' size='8' value='{$vars.AnnualAppreciation}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.YearsBeforeSell} : </td>
				<td class="last">
					<input class='text' name='YearsBeforeSell' size='8' value='{$vars.YearsBeforeSell}'> ({$lang.YearsShort})
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.SellingCost} : </td>
				<td class="last">
					<input class='text' name='SellingCost' size='8' value='{$vars.SellingCost}'> (%)
				</td>
			</tr>

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
					<input class='text' name='Length' size='8' value='{$vars.Length}'> ({$lang.YearsShort})
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Points} : </td>
				<td class="last">
					<input class='text' name='Points' size='8' value='{$vars.Points}'> (%)
				</td>
			</tr>
			<tr>
				<td class="chapter" colspan="2">{$lang.TaxAndInsuranceInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.YourTaxRate} : </td>
				<td class="last">
					<input class='text' name='Taxes' size='8' value='{$vars.Taxes}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualPropertyTaxes} : </td>
				<td class="last">
					<input class='text' name='PropertyTaxes' size='8' value='{$vars.PropertyTaxes}'>
					<span class="radio">
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel0' {if ($vars.PropertyTaxesSel eq '0')}checked{/if} value='0'> <label for="PropertyTaxesSel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='PropertyTaxesSel' id='PropertyTaxesSel1' {if ($vars.PropertyTaxesSel eq '1')}checked{/if} value='1'> <label for="PropertyTaxesSel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualInsurance} : </td>
				<td class="last">
					<input class='text' name='Insurance' size='8' value='{$vars.Insurance}'>
					<span class="radio">
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel0' {if ($vars.InsuranceSel eq '0')}checked{/if} value='0'> <label for="InsuranceSel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='InsuranceSel' id='InsuranceSel1' {if ($vars.InsuranceSel eq '1')}checked{/if} value='1'> <label for="InsuranceSel1"> (%) </label>
					</span>
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.AnnualPMI} : </td>
				<td class="last">
					<input class='text' name='PMI' size='8' value='{$vars.PMI}'>
					<span class="radio">
						<input class='radio' type='radio' name='PMISel' id='PMISel0' {if ($vars.PMISel eq '0')}checked{/if} value='0'> <label for="PMISel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='PMISel' id='PMISel1' {if ($vars.PMISel eq '1')}checked{/if} value='1'> <label for="PMISel1"> (%) </label>
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
						<input class='radio' type='checkbox' name='ShowTableSel' id='ShowTableSel' {if ($vars.ShowTableSel eq '1')}checked{/if} value='1'> <label for="ShowTableSel">{$lang.ShowScheduleTable}</label><br/>
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
				<td class="td25">{$lang.Rent}
				{if ($vars.ShowTableSel eq '1')}	
					<br>
				{/if}
				</td>
				<td class="td25 last">{$lang.Buy}
				{if ($vars.ShowTableSel eq '1')}	
					<br>(<a href="#amortization">{$lang.SeeAmortizationTableShort}</a>)
				{/if}
				</td>
			</tr>
			<tr>
				<td class="first">{$lang.TaxesAndInsurance} : </td>
				<td class="td25" nowrap>{$lang.Currency}0.00</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.TotalTaxesAndInsurance2}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalPMI} : </td>
				<td class="td25" nowrap>{$lang.Currency}0.00</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.TotalPMI2}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalMaintanance} : </td>
				<td class="td25" nowrap>{$lang.Currency}0.00</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.TotalMaintanance2}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.TotalPaymentAmount} : </td>
				<td class="td25" nowrap>{$lang.Currency}{$vars.TotalPaymentAmount}</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.TotalPaymentAmount2}</td>
			</tr>
			<tr>
				<td class="first">{$lang.AveragePeriodPayment} : </td>
				<td class="td25" nowrap>{$lang.Currency}{$vars.AveragePeriodPayment}</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.AveragePeriodPayment2}</td>
			</tr>
			<tr>
				<td class="first">{$lang.PeriodRentSavings} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.PeriodRentSavings}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TaxSavings} : </td>
				<td class="td25" nowrap>{$lang.Currency}0.00</td>
				<td class="td25 last" nowrap>{$lang.Currency}{$vars.TaxSavings2}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.TotalRentSavings} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.TotalRentSavings}</td>
			</tr>
			<tr>
				<td class="first">{$lang.HouseAppreciationValue} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.HouseAppreciationValue}</td>
			</tr>
			<tr>
				<td class="first">{$lang.ProceedsMinusCost} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.ProceedsMinusCost}</td>
			</tr>
			<tr>
				<td class="first">{$lang.LoanBalance} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.LoanBalance}</td>
			</tr>
			<tr>
				<td class="first">{$lang.EquityAppreciation} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.EquityAppreciation}</td>
			</tr>
			<tr class="total last">
				<td class="first">{$lang.HomePurchaseBenefits} : </td>
				<td class="last" colspan="2" align="center">{$lang.Currency}{$vars.HomePurchaseBenefits}</td>
			</tr>
		</table>

		{if ($vars.ShowTableSel eq '1')}
		<div class="table-caption schedule">Payment Schedule</div>
		<table class="schedule" cellspacing="0">
			<tr>
				<th class="first">{$lang.PeriodNo}</th>
				<th>{$lang.InterestPaid}</th>
				<th>{$lang.Principal}</th>
				<th>{$lang.PMI}</th>
				<th>{$lang.NewBalance}</th>
			</tr>
		{foreach item=item from=$vars.AmortizationTable2->Schedule}
			{if ($item->Type eq 'SubTotal')}
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
				<td class="total">{$vars.AmortizationTable2->TotalInterestPaid}</td>
				<td class="total">{$vars.AmortizationTable2->TotalPrincipalApplied}</td>
				<td class="total">{$vars.AmortizationTable2->TotalPMI}</td>
				<td class="total last">{$vars.AmortizationTable2->TotalRemainingBalance}</td>
			</tr>
		</table>
		{/if}
	</form>