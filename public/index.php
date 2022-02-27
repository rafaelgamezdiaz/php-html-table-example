<?php
declare(strict_types=1);

# Init Files and Paths constants
$root = dirname(__DIR__) .DIRECTORY_SEPARATOR;
define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transactions_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

require APP_PATH . 'helper.php';
require APP_PATH . 'App.php';

# Get all transactions files
$files = getTransactionFiles(FILES_PATH);

# Processing each transaction file
$transactions = [];
foreach ($files as $file) {
    $element = getTransactions($file, 'extractTransaction');
    if (count($element) > 0) {
        $transactions = array_merge($transactions, $element);
    }
}

# Calculating Totals
[$total_income, $total_expense, $total_net] = totals($transactions);

# Show Table in view
require VIEWS_PATH . 'transactions.php';

