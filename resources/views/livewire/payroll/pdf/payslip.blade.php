
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payslip - {{ $payroll->employee?->user?->name ?? 'Employee' }}</title>

    <style>
        @page {
            margin: 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.5;
        }

        .header {
            border-bottom: 3px solid #dc2626;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #dc2626;
            margin: 0;
        }

        .subtitle {
            color: #64748b;
            font-size: 10px;
        }

        .document-title {
            font-size: 17px;
            font-weight: bold;
            margin-top: 15px;
        }

        .period {
            font-size: 11px;
            color: #475569;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .details td {
            padding: 5px 7px;
            border: 1px solid #e2e8f0;
        }

        .label {
            color: #64748b;
            width: 22%;
        }

        .section-title {
            margin: 18px 0 7px;
            padding: 7px 9px;
            font-size: 11px;
            font-weight: bold;
            background: #f1f5f9;
            border-left: 3px solid #dc2626;
        }

        .items th {
            padding: 8px;
            background: #334155;
            color: #ffffff;
            text-align: left;
        }

        .items td {
            padding: 7px 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        .amount {
            text-align: right;
            white-space: nowrap;
        }

        .total-row td {
            font-weight: bold;
            background: #f8fafc;
        }

        .net-box {
            margin-top: 15px;
            padding: 12px;
            border: 1px solid #fecaca;
            background: #fff7f7;
        }

        .net-label {
            font-size: 11px;
            color: #64748b;
        }

        .net-amount {
            font-size: 21px;
            font-weight: bold;
            color: #dc2626;
        }

        .payment-summary {
            margin-top: 12px;
        }

        .footer {
            margin-top: 28px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 9px;
            text-align: center;
        }

        .muted {
            color: #64748b;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="company-name">HITEK AUTOMOBILES</p>
        <div class="subtitle">Employee Payroll Statement</div>

        <div class="document-title">PAYSLIP</div>
        <div class="period">
            {{ \Carbon\Carbon::createFromDate($payroll->year, $payroll->month, 1)->format('F Y') }}
        </div>
    </div>

    <table class="details">
        <tr>
            <td class="label">Employee Name</td>
            <td>
                <strong>
                    {{ $payroll->employee?->user?->name ?? 'Employee #'.$payroll->employee_id }}
                </strong>
            </td>
            <td class="label">Employee ID</td>
            <td>{{ $payroll->employee_id }}</td>
        </tr>
        <tr>
            <td class="label">Department</td>
            <td>{{ $payroll->employee?->department?->name ?? '—' }}</td>
            <td class="label">Payroll Status</td>
            <td class="status">{{ $payroll->status }}</td>
        </tr>
        <tr>
            <td class="label">Working Days</td>
            <td>{{ $payroll->working_days }}</td>
            <td class="label">Present Days</td>
            <td>{{ number_format((float) $payroll->present_days, 1) }}</td>
        </tr>
        <tr>
            <td class="label">Absent Days</td>
            <td>{{ number_format((float) $payroll->absent_days, 1) }}</td>
            <td class="label">Half Days</td>
            <td>{{ number_format((float) $payroll->half_days, 1) }}</td>
        </tr>
    </table>

    <div class="section-title">Earnings</div>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th class="amount">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td class="amount">{{ number_format((float) $payroll->basic_salary, 2) }}</td>
            </tr>
            <tr>
                <td>House Rent Allowance (HRA)</td>
                <td class="amount">{{ number_format((float) $payroll->hra, 2) }}</td>
            </tr>
            <tr>
                <td>Transport Allowance</td>
                <td class="amount">{{ number_format((float) $payroll->transport_allowance, 2) }}</td>
            </tr>
            <tr>
                <td>Other Allowances</td>
                <td class="amount">{{ number_format((float) $payroll->other_allowances, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Gross Salary</td>
                <td class="amount">{{ number_format((float) $payroll->gross_salary, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="section-title">Deductions</div>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th class="amount">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Absence Deduction</td>
                <td class="amount">
                    {{ number_format((float) $payroll->absence_deduction, 2) }}
                </td>
            </tr>
            <tr>
                <td>Unpaid Holiday Deduction</td>
                <td class="amount">
                    {{ number_format((float) $payroll->unpaid_holiday_deduction, 2) }}
                </td>
            </tr>
            <tr>
                <td>Half-Day Deduction</td>
                <td class="amount">
                    {{ number_format((float) $payroll->half_day_deduction, 2) }}
                </td>
            </tr>
            <tr>
                <td>Leave Deduction</td>
                <td class="amount">
                    {{ number_format((float) $payroll->leave_deduction, 2) }}
                </td>
            </tr>
            <tr>
                <td>Other Deductions</td>
                <td class="amount">
                    {{ number_format((float) $payroll->other_deductions, 2) }}
                </td>
            </tr>
            <tr class="total-row">
                <td>Total Deductions</td>
                <td class="amount">
                    {{ number_format((float) $payroll->total_deductions, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="net-box">
        <table>
            <tr>
                <td>
                    <div class="net-label">Net Salary</div>
                    <div class="net-amount">
                        ₹{{ number_format((float) $payroll->net_salary, 2) }}
                    </div>
                </td>
                <td class="amount">
                    <div class="muted">Total Paid</div>
                    <strong>
                        ₹{{ number_format($totalPaid, 2) }}
                    </strong>

                    <div class="muted" style="margin-top: 8px;">Outstanding Balance</div>
                    <strong>
                        ₹{{ number_format($remainingBalance, 2) }}
                    </strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Payment History</div>

    <table class="items">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Method</th>
                <th>Reference</th>
                <th class="amount">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_date->format('d M Y') }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $payment->payment_type)) }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    <td>{{ $payment->payment_reference ?: '—' }}</td>
                    <td class="amount">{{ number_format((float) $payment->amount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted">No payments recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        This is a computer-generated payslip from Hitek Automobiles.
        Please contact the Admin if you notice any discrepancy.
    </div>
</body>
</html>
