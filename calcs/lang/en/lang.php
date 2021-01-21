<?

if (!isset($Variables))
	$Variables = new Variables();

$Variables->LangVar['Period']                    = 'Yr';
$Variables->LangVar['Months']                    = 'Months';
$Variables->LangVar['MonthsShort']               = 'Mts';
$Variables->LangVar['Years']                     = 'Years';
$Variables->LangVar['YearsShort']                = 'Yrs';
$Variables->LangVar['YearShort']                 = 'Yr';
$Variables->LangVar['Currency']                  = $Variables->Currency;

$Variables->LangVar['SeeAmortizationTableShort'] = 'Am. Table';

$Variables->LangVar['InputInfo']                 = 'Input Information';
$Variables->LangVar['FinancialAnalysis']         = 'Financial Analysis';
$Variables->LangVar['PaymentSchedule']           = 'Payment Schedule';
$Variables->LangVar['BiWeeklyPaymentSchedule']   = 'Bi-Weekly Payment Schedule';
$Variables->LangVar['Instructions']              = 'Instructions';

$Variables->LangVar['Standard']                  = 'Standard';
$Variables->LangVar['BiWeekly']                  = 'Bi-Weekly';

$Variables->LangVar['LoanInfo']                  = 'Loan Information';
$Variables->LangVar['PropertyInfo']              = 'Property Information';
$Variables->LangVar['TaxAndInsuranceInfo']       = 'Taxes And Insurance Information';
$Variables->LangVar['Amount']                    = 'Amount';
$Variables->LangVar['Interest']                  = 'Interest Rate';
$Variables->LangVar['Length']                    = 'Length';
$Variables->LangVar['TaxRate']                   = 'Tax Rate';
$Variables->LangVar['Taxes']                     = 'Tax Rates';
$Variables->LangVar['YourTaxRate']               = 'Your Tax Rate';
$Variables->LangVar['YourTaxRatesAndDeductions'] = 'Your Tax Rates And Deductions';
$Variables->LangVar['StateTaxRate']              = 'State Tax Rate';
$Variables->LangVar['MonthsPaid']                = 'Months Paid';

/* Eighteen lines below added 23-feb-2005 */
// Calc6 specific (input)
$Variables->LangVar['OriginalLoan']              = 'Before Refinance';
$Variables->LangVar['RefinancedLoan']            = 'After Refinance';
$Variables->LangVar['RefinancingFees']           = 'Fees and Points';
$Variables->LangVar['YourTaxRates']              = 'Your Taxes Rates';
// Calc6 specific (output)
$Variables->LangVar['BalanceAtRefinance']        = 'Balance at Refinance';
$Variables->LangVar['AmountReinanced']           = 'Refinance amount';
$Variables->LangVar['BalanceAtSale']             = 'Balance at Sale';
$Variables->LangVar['BalanceLosses']             = 'Balance Losses';
$Variables->LangVar['TotalLosses']               = 'Total Losses';
$Variables->LangVar['TotalBenefit']              = 'Total Benefit <br/>(Savings - Losses - Closing)';
$Variables->LangVar['TotalBenefitTxt']           = 'Total Benefit (Savings - Losses - Closing)';
$Variables->LangVar['TotalSavings']              = 'Total Savings';
// Calc6 specific (amortization)
$Variables->LangVar['OriginalPaymentSchedule']   = 'Original Payment Schedule (Before and After Refinance)';
$Variables->LangVar['RefinancedPaymentSchedule'] = 'Payment Schedule After Refinance';

// Calc12 specific output
$Variables->LangVar['ActualAPR']                 = 'Actual APR';
$Variables->LangVar['']                 = '';

// Calc11 specific (output)
$Variables->LangVar['RealRate']                  = 'Real Interest Rate';

// Calc19 specific (input)
$Variables->LangVar['RentInfo']                  = 'Rent Info';
$Variables->LangVar['PeriodRent']                = 'Monthly Rent';
$Variables->LangVar['AnnualRentIncrease']        = 'Annual Rent Increase';
$Variables->LangVar['AnnualMaintanance']         = 'Annual Maintanance';
$Variables->LangVar['AnnualAppreciation']        = 'Annual Appreciation';
$Variables->LangVar['SellingCost']               = 'Selling Cost';

//Calc19 specific (output)
$Variables->LangVar['Rent']                      = 'Rent';
$Variables->LangVar['Buy']                       = 'Buy';

$Variables->LangVar['TaxesAndInsurance']         = 'Taxes and Insurance';
$Variables->LangVar['TotalMaintanance']          = 'Total Maintanance';
$Variables->LangVar['AveragePeriodPayment']      = 'Average Monthly Payment';
$Variables->LangVar['PeriodRentSavings']         = 'Monthly Rent Savings';
$Variables->LangVar['TotalRentSavings']          = 'Total Rent Savings';
$Variables->LangVar['HouseAppreciationValue']    = 'House Appreciation Value';
$Variables->LangVar['ProceedsMinusCost']         = 'Proceeds Minus Cost';
$Variables->LangVar['LoanBalance']               = 'Loan Balance';
$Variables->LangVar['EquityAppreciation']        = 'Equity Appreciation';
$Variables->LangVar['HomePurchaseBenefits']      = 'Home Purchase Benefits';

$Variables->LangVar['HomeValue']                 = 'Home Value';
$Variables->LangVar['AnnualPropertyTaxes']       = 'Annual Taxes';
$Variables->LangVar['AnnualInsurance']           = 'Annual Insurance';
$Variables->LangVar['AnnualPMI']                 = 'Annual PMI';
$Variables->LangVar['AmortizationTable']         = 'Amortization Table';
$Variables->LangVar['PeriodNo']                  = 'No';
$Variables->LangVar['PrincipalBalance']          = 'Principal Balance';
$Variables->LangVar['PaymentAmount']             = 'Payment';
$Variables->LangVar['InterestPaid']              = 'Interest';
$Variables->LangVar['PrincipalApplied']          = 'Principal Applied';
$Variables->LangVar['Principal']                 = 'Principal';
$Variables->LangVar['PropertyTaxes']             = 'Taxes';
$Variables->LangVar['Insurance']                 = 'Insurance';
$Variables->LangVar['PMI']                       = 'PMI';
$Variables->LangVar['NewBalance']                = 'Balance';
$Variables->LangVar['RemainingBalance']          = 'Balance';
$Variables->LangVar['MonthsAlreadyPaid']         = 'Months Already Paid';
$Variables->LangVar['EstimatedFrontRatio']       = 'Estimated Front Ratio';
$Variables->LangVar['EstimatedBackRatio']        = 'Estimated Back Ratio';
$Variables->LangVar['ActualFrontRatio']          = 'Actual Front Ratio';
$Variables->LangVar['ActualBackRatio']           = 'Actual Back Ratio';
$Variables->LangVar['PeriodPayment']             = 'Considered Monthly Payment';
$Variables->LangVar['PeriodPayment']             = 'Considered Monthly Payment';
$Variables->LangVar['PeriodPayment']             = 'Considered Monthly Payment';
$Variables->LangVar['OriginalPayment']           = 'Original Payment';
$Variables->LangVar['NewPayment']                = 'New Payment';
$Variables->LangVar['NewLength']                 = 'New Length Of Loan';
$Variables->LangVar['BadLength']                 = 'You can never payout that loan !';
$Variables->LangVar['IncomeInfo']                = 'Income Information';
$Variables->LangVar['Income']                    = 'Income 1';
$Variables->LangVar['Income2']                   = 'Income 2';
$Variables->LangVar['Income3']                   = 'Income 3';
$Variables->LangVar['Income4']                   = 'Income 4';
$Variables->LangVar['Income5']                   = 'Income 5';
$Variables->LangVar['DebtPaymentInfo']           = 'Debt Payment Information';
$Variables->LangVar['AutoLoansPayment']          = 'Auto Loans';
$Variables->LangVar['StudentLoansPayment']       = 'Student Loans';
$Variables->LangVar['InstallmentLoansPayment']   = 'Installment';
$Variables->LangVar['RevolvingAccountsPayment']  = 'Revolving accts';
$Variables->LangVar['OtherDebtPayment']          = 'Other Debt';
$Variables->LangVar['YearsBeforeSell']           = 'Years Before Sell';
$Variables->LangVar['Points']                    = 'Points';
$Variables->LangVar['ClosingCost']               = 'Closing Cost';
$Variables->LangVar['Deductions']                = 'Deductions';
$Variables->LangVar['FirstYears']                = 'First Years';
$Variables->LangVar['Total']                     = 'Total';
$Variables->LangVar['InterestAndPoints']         = 'Interest and Points';
$Variables->LangVar['TotalPropertyTaxes']        = 'Total Property Taxes';
$Variables->LangVar['TotalDeductions']           = 'Total Deductions';
$Variables->LangVar['TaxSavings']                = 'Tax Savings';
$Variables->LangVar['AveragePaymentAfterTaxes']  = 'Average Payment After Taxes';
$Variables->LangVar['AdditionalPayment']         = 'Additional Payment';
$Variables->LangVar['']                          = '';
$Variables->LangVar['']                          = '';
$Variables->LangVar['InterestWithPoints']        = 'Interest Rate with Points';
$Variables->LangVar['AdditionalInfo']            = 'Additional Information';
$Variables->LangVar['SavingsRate']               = 'Your Savings Rate';
$Variables->LangVar['WithoutPoints']             = 'Without Points';
$Variables->LangVar['WithPoints']                = 'With Points';
$Variables->LangVar['MonthlyPaymentSavings']     = 'Monthly Payment Savings';
$Variables->LangVar['PointsValue']               = 'Points Value';
$Variables->LangVar['MonthlyInvestmentSavings']  = 'Monthly Investment Savings';
$Variables->LangVar['TrueMonthlySavings']        = 'True Monthly Savings';
$Variables->LangVar['BreakEven']                 = 'Break Even';
$Variables->LangVar['AmountFinanced']            = 'Amount Financed';
$Variables->LangVar['BadData']                   = 'Bad Data - please check your inputs';
$Variables->LangVar['PaymentScheduleWithPoints'] = 'Payment Schedule for Loan with Points';
$Variables->LangVar['MonthlyIncome']             = 'Monthly Income';
$Variables->LangVar['MonthlyDebtPayments']       = 'Monthly Debt Payments';
$Variables->LangVar['DebtName']                  = 'Auto Loan';
$Variables->LangVar['DebtName2']                 = 'Boat/RV';
$Variables->LangVar['DebtName3']                 = 'Credit Card 1';
$Variables->LangVar['DebtName4']                 = 'Credit Card 2';
$Variables->LangVar['DebtName5']                 = 'Other Accounts';
$Variables->LangVar['Payment']                   = 'Payment';
$Variables->LangVar['InterestShort']             = 'Interest';
$Variables->LangVar['YourTaxRate']               = 'Your Tax Rate';
$Variables->LangVar['Debt']                      = 'Debt';
$Variables->LangVar['HELOC']                     = 'HELOC';
$Variables->LangVar['AvgPayment']                = 'Average Payment';
$Variables->LangVar['AvgInterestPaid']           = 'Average Interest Paid';
$Variables->LangVar['AvgInterestRate']           = 'Average Interest Rate';
$Variables->LangVar['AnnualInterestSavings']     = 'Annual Interest Savings';
$Variables->LangVar['AvgAnnualTaxSavings']       = 'Avg Annual Tax Savings';
$Variables->LangVar['PayoffTimeline']            = 'Payoff Timeline';
$Variables->LangVar['TotalDeductibleInterest']   = 'Total Deductible Interest';
$Variables->LangVar['AllowableDebtPayments']     = 'Allowable Debt Payments';
$Variables->LangVar['80PercentLoan']             = '80% Loan';
$Variables->LangVar['SecondLoan']                = 'Second Loan';
$Variables->LangVar['Second']                    = 'Second';
$Variables->LangVar['TotalPaymentAmount']        = 'Total Payments';
$Variables->LangVar['TotalPMI']                  = 'Total PMI';
$Variables->LangVar['UpfrontCost']               = 'Upfront Cost';
$Variables->LangVar['ConsolidatedSchFor2Loans']  = 'Consolidated Payment Schedule For Two Loans';
$Variables->LangVar['PaymentScheduleForLoanWithAdditionalPayment'] = 'Payment Schedule for Loan with Additional Payment';
$Variables->LangVar['DownPayment']               = 'Down Payment';
$Variables->LangVar['RequiredDownPayment']       = 'Required Down Payment';
$Variables->LangVar['RequiredIncome']            = 'Required Income';
$Variables->LangVar['Loan1Info'] = 'Loan 1';
$Variables->LangVar['Loan2Info'] = 'Loan 2';
$Variables->LangVar['PointsValue']               = 'Points Value';
$Variables->LangVar['OriginationFees']           = 'Origination Fees';
$Variables->LangVar['TotalClosingCost']          = 'Total Closing Cost';
$Variables->LangVar['AmountFinanced']            = 'Amount Financed';
$Variables->LangVar['PaymentSavings']            = 'Payment Savings';
$Variables->LangVar['PaymentSchedule1']          = 'Payment Schedule for Loan 1';
$Variables->LangVar['PaymentSchedule2']          = 'Payment Schedule for Loan 2';
$Variables->LangVar['MonthlyPayment']            = 'Monthly Payment';
$Variables->LangVar['NewLength']                 = 'New Length Of Loan';
$Variables->LangVar['TotalInterestPaid']         = 'Total Interest Paid';
$Variables->LangVar['InterestSavings']           = 'Interest Savings';
$Variables->LangVar['TimeSaved']                 = 'Time Saved';
$Variables->LangVar['TaxSavings']                = 'Tax Savings';
$Variables->LangVar['TaxSavingLosses']           = 'Tax Saving Losses';
$Variables->LangVar['TotalBenefits']             = 'Total Benefits';
$Variables->LangVar['MonthlyPI']                 = 'Monthly Principal and Interest';
$Variables->LangVar['MonthlyPIShort']            = 'Monthly PI';
$Variables->LangVar['MonthlyPropertyTaxes']      = 'Monthly Real Estate Taxes';
$Variables->LangVar['MonthlyInsurance']          = 'Monthly Insurance';
$Variables->LangVar['MonthsWithPMI']             = 'Months With PMI';
$Variables->LangVar['MonthlyPMI']                = 'Monthly PMI';
$Variables->LangVar['TotalMonthlyPayment']       = 'Total Monthly Payments';
$Variables->LangVar['LTV']                       = 'Loan To Value Ratio';

$Variables->LangVar['TotalCostOfLoan']           = 'Total Cost of Loan';
$Variables->LangVar['MonthlyPaymentPerThousand'] = 'Monthly Payment per Thousand';
$Variables->LangVar['AnnualPaymentPerThousand']  = 'Annual Payment per Thousand';
$Variables->LangVar['LifetimePaymentPerThousand'] = 'Lifetime Payment per Thousand';
$Variables->LangVar['InterestOnly']              = 'Interest-Only';
$Variables->LangVar['WithAdditionalPayment']     = 'With Additional Payment';
$Variables->LangVar['InterestOnlyPaymentSchedule'] = 'Interest-Only Loan Payment Schedule';
$Variables->LangVar['InterestOnlyWithAdditionalPaymentSchedule'] = 'Schedule for Interest-Only Loan with Additional Payment';


$Variables->LangVar['ShowScheduleTable']  = 'Show Schedule Table';
$Variables->LangVar['ShowPdfForm']        = 'Let Me Print That Form in PDF!';

// Calculators related
$Variables->LangVar['Calc1Title']    = 'How Much Will My Mortgage Payment Be?';
$Variables->LangVar['Calc2Title']    = 'Mortgage Principal Calculator';
$Variables->LangVar['Calc3Title']    = 'Mortgage Length Calculator';
$Variables->LangVar['Calc4Title']    = 'Affordability Calculator';
$Variables->LangVar['Calc5Title']    = 'Tax Benefits Calculator';
$Variables->LangVar['Calc6Title']    = 'Should I Refinance?';
$Variables->LangVar['Calc7Title']    = 'Should I Pay Points to Lower Interest Rate ?';
$Variables->LangVar['Calc8Title']    = 'Should I use HELOC to Lower Debt Payments?';
$Variables->LangVar['Calc9Title']    = 'How Much Income do I Need to Qualify?';
$Variables->LangVar['Calc10Title']    = 'What Better: take a Second Loan or Pay PMI?';
$Variables->LangVar['Calc11Title']    = '';
$Variables->LangVar['Calc12Title']    = 'What is the real APR for that loan?';
$Variables->LangVar['Calc13Title']    = 'What if I\'ll Pay More Every Month?';
$Variables->LangVar['Calc14Title']    = 'Payment per Thousand Financed';
$Variables->LangVar['Calc15Title']    = 'Interest Only Calculator';
$Variables->LangVar['Calc16Title']    = 'Canadian mortgage calculator';
$Variables->LangVar['Calc17Title']    = 'Which Loan is Better?';
$Variables->LangVar['Calc18Title']    = 'Standard vs Bi-Weekly';
$Variables->LangVar['Calc19Title']    = 'Rent vs Buy';
$Variables->LangVar['Calc20Title']    = 'Interest-Only with Additional Payments Calculator';


$Variables->LangVar['Calc1Help']    = 'Calculate mortgage monthly payment with applicable financial charges, including PMI, hazard insurance and property taxes.';
$Variables->LangVar['Calc2Help']    = 'This calculator allow you to "peek into the future", allowing you to determine remaining balance of your mortgage after several years of payments.';
$Variables->LangVar['Calc3Help']    = 'This calculator will help you to determine your savings in the case of bigger monthly payments.';
$Variables->LangVar['Calc4Help']    = 'Want to determine, how much you can borrow from a lender ? Use this calculator to calculate a maximum amount of loan which you might afford from the lender\'s point of view.';
$Variables->LangVar['Calc5Help']    = 'This calculator is useful to determine your tax savings after house purchase. Financial analysis includes first year and total tax savings.';
$Variables->LangVar['Calc6Help']    = 'Your old APR (Annual Percentage Rate) is too high? Estimate your benefits of refinancing using this calculator. ';
$Variables->LangVar['Calc7Help']    = 'Calculate, how points might affect your monthly payments and how fast they will pay for themselves.';
$Variables->LangVar['Calc8Help']    = 'Figure out, how you can cut current monthly debt payments using money from your Home Equity Line Of Credit (HELOC).';
$Variables->LangVar['Calc9Help']    = 'Need to know, how much money you need to earn to purchase house of your dream? This calculator will help you to figure this number out.';
$Variables->LangVar['Calc10Help']   = 'Don\'t miss out an opportunity, which might slash your PMI payments to zero and you will only benefit! It\'s name - second mortgage.';
$Variables->LangVar['Calc11Help']   = '';
$Variables->LangVar['Calc12Help']   = 'This calculator estimates your real APR (Annual Percentage Rate) for the mortgage loan with points.';
$Variables->LangVar['Calc13Help']   = 'See, how your mortgage will be affected, if you\'ll pay $XX more every month.';
$Variables->LangVar['Calc14Help']   = ' Have you even wondered how much it is costs to pay every thousand of your mortgage loan? Now you can know that!';
$Variables->LangVar['Calc15Help']   = 'Housing market moves up too fast ? Try to figure out, how much you can afford with interest only mortgage loan, if you are pretty sure, that market will continue its way to the sky...';
$Variables->LangVar['Calc16Help']   = 'This calculator figures your monthly payment based on your input - conventional mortgage financing compounded semi-annually. It is also calculating required annual income, which every Canadian homebuyer need to have.';
$Variables->LangVar['Calc17Help']   = 'There are so many loan offers and you can\'t determine which of them is better than others? Input your numbers and lock the best offer you have.';
$Variables->LangVar['Calc18Help']   = 'Heard, that bi-weekly payments can significantly decrease the time of mortgage payout? That\'s true, check it out with this calculator.';
$Variables->LangVar['Calc19Help']   = 'Still renting apartments and thinking about home purchase? This calculator can help you to make the final decision.';
$Variables->LangVar['Calc20Help']   = 'Interest-Only loans can drastically cut your mortgage payments, but what if you want to pay something toward your principal? Figure it out with this calculator.';

?>