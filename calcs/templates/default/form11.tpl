	<form method="POST" id="CalcForm">
		<h1>{$lang.Calc11Title}</h1>
		<div class="table-caption inputinfo">{$lang.InputInfo}</div>
		<table class="calc" cellspacing="0">
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
				<td class="button" colspan="2" align="center">
					<input type="submit" value="Calculate">
				</td>
			</tr>
		</table>

		<div class="table-caption analysis">{$lang.FinancialAnalysis}</div>
		<table class="results" cellspacing="0">
		
		</table>

		{if ($vars.ShowTableSel eq 1)}
		<div class="table-caption schedule">Payment Schedule</div>
		<table class="schedule" cellspacing="0">

		</table>
		{/if}
	</form>