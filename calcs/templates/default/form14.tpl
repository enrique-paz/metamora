	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc14Title}</h1>
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
				<td class="chapter" colspan="2">{$lang.AdditionalInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.Points} : </td>
				<td class="last">
					<input class='text' name='Points' size='8' value='{$vars.Points}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.OriginationFees} : </td>
				<td class="last">
					<input class='text' name='Origination' size='8' value='{$vars.Origination}'> (%)
				</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.ClosingCost} : </td>
				<td class="last">
					<input class='text' name='Closing' size='8' value='{$vars.Closing}'> ({$lang.Currency})
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
				<td class="button" colspan="2">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>

		<div class="table-caption analysis">{$lang.FinancialAnalysis}</div>
		<table class="results" cellspacing="0">
			<tr>
				<td class="first">{$lang.TotalClosingCost}</td>
				<td class="last">{$lang.Currency}{$vars.TotalClosingCost}</td>
			</tr>
			<tr>
				<td class="first">{$lang.TotalMonthlyPayment}</td>
				<td class="last">{$lang.Currency}{$vars.TotalPayments}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.TotalCostOfLoan}</td>
				<td class="last">{$lang.Currency}{$vars.TotalCostOfLoan}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.MonthlyPaymentPerThousand}</td>
				<td class="last">{$lang.Currency}{$vars.MonthlyPaymentPerThousand}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.AnnualPaymentPerThousand}</td>
				<td class="last">{$lang.Currency}{$vars.AnnualPaymentPerThousand}</td>
			</tr>
			<tr class="total last">
				<td class="first">{$lang.LifetimePaymentPerThousand}</td>
				<td class="last">{$lang.Currency}{$vars.LifetimePaymentPerThousand}</td>
			</tr>
		</table>
	</form>