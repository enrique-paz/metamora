	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc12Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
			<tr>
				<td class="chapter" colspan="2">{$lang.LoanInfo}</td>
			</tr>
			<tr>
				<td class="first td50">{$lang.HomeValue} : </td>
				<td class="last">
					<input class="text" name="HomeValue" size="8" value="{$vars.HomeValue}"> ({$lang.Currency})
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
				<td class="first td50">{$lang.DownPayment} : </td>
				<td class="last">
					<input class='text' name='DownPayment' size='8' value='{$vars.DownPayment}'>
					<span class="radio">
						<input class='radio' type='radio' name='DownPaymentSel' id='DownPaymentSel0' {if ($vars.DownPaymentSel eq 0)}checked{/if} value='0'> <label for="DownPaymentSel0">({$lang.Currency})</label>
						<input class='radio' type='radio' name='DownPaymentSel' id='DownPaymentSel1' {if ($vars.DownPaymentSel eq 1)}checked{/if} value='1'> <label for="DownPaymentSel1"> (%) </label>
					</span>
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
				<td class="first">{$lang.DownPayment} : </td>
				<td class="td50">{$lang.Currency}{$vars.DownPaymentValue}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.AmountFinanced} : </td>
				<td class="last">{$lang.Currency}{$vars.AmountFinanced}</td>
			</tr>
			<tr>
				<td class="first">{$lang.MonthlyPI} : </td>
				<td class="last">{$lang.Currency}{$vars.MonthlyPayment}</td>
			</tr>
			<tr>
				<td class="first">{$lang.PointsValue} : </td>
				<td class="last">{$lang.Currency}{$vars.PointsValue}</td>
			</tr>
			<tr>
				<td class="first">{$lang.OriginationFees}</td>
				<td class="last">{$lang.Currency}{$vars.OriginationValue}</td>
			</tr>
			<tr class="total">
				<td class="first">{$lang.TotalClosingCost}</td>
				<td class="last">{$lang.Currency}{$vars.TotalClosingCost}</td>
			</tr>
			<tr class="last total">
				<td class="first">{$lang.ActualAPR}</td>
				<td class="last">{$vars.ActualAPR}%</td>
			</tr>

		</table>
	</form>