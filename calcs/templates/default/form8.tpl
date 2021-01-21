	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc8Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="4">{$lang.LoanInfo}</td>
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
				<td class="first td50" colspan="2">{$lang.ClosingCost} : </td>
				<td colspan="2" class="last">
					<input class='text' name='Closing' size='8' value='{$vars.Closing}'> ({$lang.Currency})
				</td>
			</tr>
			<tr>
				<td class="first td50" colspan="2">{$lang.YourTaxRate} : </td>
				<td colspan="2" class="last">
					<input class='text' name='Taxes' size='8' value='{$vars.Taxes}'> (%)
				</td>
			</tr>
			<tr>
				<td class="td25 first">&nbsp;</td>
				<td class="chapter25">{$lang.Amount} ({$lang.Currency})</td>
				<td class="chapter25">{$lang.Payment} ({$lang.Currency})</td>
				<td class="chapter25 last">{$lang.InterestShort} (%)</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.DebtName} : </td>
				<td class="td25">
					<input class='text' name='DebtAmount' size='8' value='{$vars.DebtAmount}'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment' size='8' value='{$vars.DebtPayment}'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest' size='8' value='{$vars.DebtInterest}'>
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.DebtName2} : </td>
				<td class="td25">
					<input class='text' name='DebtAmount2' size='8' value='{$vars.DebtAmount2}'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment2' size='8' value='{$vars.DebtPayment2}'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest2' size='8' value='{$vars.DebtInterest2}'>
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.DebtName3} : </td>
				<td class="td25">
					<input class='text' name='DebtAmount3' size='8' value='{$vars.DebtAmount3}'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment3' size='8' value='{$vars.DebtPayment3}'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest3' size='8' value='{$vars.DebtInterest3}'>
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.DebtName4} : </td>
				<td class="td25">
					<input class='text' name='DebtAmount4' size='8' value='{$vars.DebtAmount4}'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment4' size='8' value='{$vars.DebtPayment4}'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest4' size='8' value='{$vars.DebtInterest4}'>
				</td>
			</tr>
			<tr>
				<td class="td25 first">{$lang.DebtName5} : </td>
				<td class="td25">
					<input class='text' name='DebtAmount5' size='8' value='{$vars.DebtAmount5}'>
				</td>
				<td class="td25">
					<input class='text' name='DebtPayment5' size='8' value='{$vars.DebtPayment5}'>
				</td>
				<td class="td25 last">
					<input class='text' name='DebtInterest5' size='8' value='{$vars.DebtInterest5}'>
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
				<td class="button" colspan="4" align="center">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>
		<div class="table-caption analysis">{$lang.FinancialAnalysis}</div>
		<table class="results" cellspacing="0">
			<tr class="total">
				<td class="first">&nbsp;</td>
				<td class="td25">{$lang.Debt}</td>
				<td class="td25 last">{$lang.HELOC}</td>
			</tr>
			<tr>
				<td class="first">{$lang.Amount} : </td>
				<td colspan="2" class="td25 last">{$lang.Currency}{$vars.DebtValue}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyPayment} : </td>
				<td class="td25">{$lang.Currency}{$vars.DebtPaymentAmount}</td>
				<td class="td25 last">{$lang.Currency}{$vars.LoanPaymentAmount}</td>
			</tr>
			<tr>
				<td class="first">{$lang.AvgInterestRate} : </td>
				<td class="td25">{$vars.DebtInterestRate}%</td>
				<td class="td25 last">{$vars.LoanInterestRate}%</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.PayoffTimeline} : </td>
				<td class="td25">{$vars.DebtYears} {$lang.YearsShort} {$vars.DebtMonths} {$lang.MonthsShort}</td>
				<td class="td25 last">{$vars.LoanYears} {$lang.YearsShort} {$vars.LoanMonths} {$lang.MonthsShort}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalMonthlyPayment} : </td>
				<td class="td25">{$lang.Currency}{$vars.TotalDebtPayment}</td>
				<td class="td25 last">{$lang.Currency}{$vars.TotalLoanPayment}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalDeductibleInterest} : </td>
				<td class="td25">{$lang.Currency}{$vars.TotalDebtInterest}</td>
				<td class="td25 last">{$lang.Currency}{$vars.TotalLoanInterest}</td>
			</tr>
			<tr class="total last">
				<td class="first">{$lang.AvgAnnualTaxSavings} : </td>
				<td class="td25">{$lang.Currency}{$vars.DebtTaxSavings}</td>
				<td class="td25 last">{$lang.Currency}{$vars.LoanTaxSavings}</td>
			</tr>
		</table>
	</form>