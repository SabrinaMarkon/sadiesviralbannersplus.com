<?php
 /**
Handles admin adding, updating, or deleting financial transactions.
PHP 5.4+
@author Sabrina Markon
@copyright 2018 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
**/
// if (count(get_included_files()) === 1) { exit('Direct Access is not Permitted'); }
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class Money
{

    private $pdo;

    public function getAllTransactions() {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from transactions order by id desc";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $transactions = $q->fetchAll();

        Database::disconnect();

        if ($transactions) {

            return $transactions;
        }
    }

    /* Find out how much a user owes or is owed by others. */
    public function getUserTransactions($username) {

        
        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "select * from transactions where username=? order by id";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $transactions = $q->fetchAll();

        Database::disconnect();
        
        if ($transactions) {

            return $transactions;
        }
    }

    public function addTransaction() {

        $username = $_POST['username'];
        $amount = $_POST['amount'];
        $transaction = $_POST['transaction'];

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        # create a transactions.
        $sql = "insert into transactions (username,amount,transaction) values (?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute([$username,$amount,$transaction]);
        
        DATABASE::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Transaction Created where " . $username . " owes " . $amount . "</strong></div>";
    }

    public function saveTransaction($id) {

        $username = $_POST['username'];
        $amount = $_POST['amount'];
        $datepaid = $_POST['datepaid'];
        if (($datepaid === '') or ($datepaid === 'Not Yet')) { 
            $datepaid = ''; 
        }
        $transaction = $_POST['transaction'];

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "update transactions set username=?, amount=?, datepaid=?, transaction=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username, $amount, $datepaid, $transaction, $id));

        DATABASE::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Transaction ID #" . $id . " was Saved!</strong></div>";

    }        


    public function deleteTransaction($id) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "delete from transactions where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));

        Database::disconnect();
        
        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Transaction ID " . $id . " was Deleted</strong></div>";
    }

}