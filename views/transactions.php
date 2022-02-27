<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th, table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th, tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Check #</th>
        <th>Description</th>
        <th>Amount ($)</th>
    </tr>
    </thead>
    <tbody>
     <?php if(!empty($transactions)): ?>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo formatDate($transaction['date']); ?></td>
                <td><?php echo $transaction['check']; ?></td>
                <td><?php echo $transaction['description']; ?></td>
                <td style="color: <?php echo ($transaction['amount'] >= 0 ? 'blue' : 'red'); ?>;"><?php echo formatDollarAmount($transaction['amount']); ?></td>
            </tr>
        <?php endforeach; ?>
     <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?php $totalIncome = $total_income ?? 0; echo "$totalIncome"; ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?php $totalExpense = $total_expense ?? 0; echo "$total_expense"; ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?php $totalNet = $total_net ?? 0; echo "$total_net"; ?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>