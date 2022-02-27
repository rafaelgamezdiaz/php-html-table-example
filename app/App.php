<?php
declare(strict_types=1);

/**
 * Read files from the directory
 * @param string $dirPath
 * @return array
 */
function getTransactionFiles(string $dirPath): array {
    $files = [];

    foreach (scandir($dirPath) as $file) {
        if (is_dir($file)) {
            continue;
        }
        $files[] = $dirPath . $file;
    }
    return $files;
}

/**
 * Process each transaction file
 * @param string $fileName
 * @param callable|null $transactionHandler
 * @return array
 */
function getTransactions(string $fileName, ?callable $transactionHandler = null): array {
    if (!file_exists($fileName)) {
        trigger_error('The file "' . $fileName . '" does not exist!', E_USER_ERROR);
    }
    if (pathinfo($fileName)['extension'] !== 'csv') {
        return [];
    }
    $file = fopen($fileName, 'r');
    $transactions = [];
    fgetcsv($file); // Ignore the first line. Read the header of the file to set the pointer in the first data register
    while (($transaction = fgetcsv($file)) !== false) {
        if ($transactionHandler !== null) {
            $transaction = $transactionHandler($transaction);
        }
        $transactions[] = $transaction;
    }
    fclose($file);
    return $transactions;
}

/**
 * Format one transaction register
 * @param array $transaction
 * @return array
 */
function extractTransaction(array $transaction): array {
    [$date, $check, $description, $amount] = $transaction;
    $amount = (float) str_replace(['$', ','], '', $amount);
    return [
        'date' => $date,
        'check' => $check,
        'description' => $description,
        'amount' => $amount
    ];
}

/**
 * Calculates the totals
 * @param array $transactions
 * @return array
 */
function totals(array $transactions): array {
    [$total_income, $total_expense, $total_net] = [0, 0, 0];
    foreach ($transactions as $transaction) {
        $total_net += $transaction['amount'];
        if ($transaction['amount'] >= 0) {
            $total_income += $transaction['amount'];
        } else {
            $total_expense += $transaction['amount'];
        }
    }
    return [$total_income, $total_expense, $total_net];
}