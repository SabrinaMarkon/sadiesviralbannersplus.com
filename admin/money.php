<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
if (isset($show))
{
    echo $show;
}
$alltransactions = new Money();
$transactions = $alltransactions->getAllTransactions();
if (empty($transactions)) {
    $transactions = [];
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">		
			<h1 class="ja-bottompadding">Create Transaction Record</h1>
			
			<form action="/admin/money" method="post" accept-charset="utf-8" class="form" role="form">

                <label for="username" class="ja-toppadding">* Username (Payer):</label>
                <input type="text" name="username" value="" class="form-control input-lg" placeholder="Username" required>

                <label for="item" class="ja-toppadding">* Item Name:</label>
                <input type="text" name="item" value="" class="form-control input-lg" placeholder="Item Name" required>

                <label for="amount" class="ja-toppadding">* Amount Owing:</label>
                <input type="text" name="amount" value="" class="form-control input-lg" placeholder="Amount Owing" required>

                <label for="datepaid" class="ja-toppadding">Payment Date:</label>
                <input type="text" name="datepaid" value="" class="form-control input-lg" placeholder="Date Paid">

                <label for="paymethod" class="ja-toppadding">Payment Method:</label>
                <input type="text" name="paymethod" value="" class="form-control input-lg" placeholder="Payment Method">

                <label for="transaction" class="ja-toppadding">Transaction:</label>
                <input type="text" name="transaction" value="" class="form-control input-lg" placeholder="Transaction">

                <div class="ja-bottompadding"></div>

                <button class="btn btn-lg btn-primary ja-toppadding ja-bottompadding" type="submit" name="addtransaction">Add Transaction</button>

			</form>				

			<div class="ja-bottompadding"></div>
            
            <h1 class="ja-bottompadding">Transaction Records</h1>

            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-striped table-hover text-center table-sm">
                    <thead>
                    <tr>
                        <th class="text-center small">#</th>
                        <th class="text-center small">Payer</th>
                        <th class="text-center small">Item</th>
                        <th class="text-center small">Amount</th>
                        <th class="text-center small">Date&nbsp;Paid</th>
                        <th class="text-center small">Payment Method</th>
                        <th class="text-center small">Transaction</th>
                        <th class="text-center small">Edit</th>
                        <th class="text-center small">Delete</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($transactions as $transaction) {

                        $datepaid = $transaction['datepaid'];
                        if(empty($datepaid)) { $datepaid = 'Not Yet'; }
                    ?>
                        <tr>
                            <form action="/admin/money/<?php echo $transaction['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                            <td><?php echo $transaction['id']; ?>
                            </td>
                            <td>
                                <label class="sr-only" for="username">Payer:</label>
                                <input type="text" name="username" value="<?php echo $transaction['username']; ?>" class="form-control input-sm widetableinput" placeholder="Payer" required>
                            </td>
                            <td>
                                <label class="sr-only" for="item">Item Name:</label>
                                <input type="text" name="item" value="<?php echo $transaction['item']; ?>" class="form-control input-sm widetableinput" placeholder="Item Name" required>
                            </td>
                            <td>
                                <label class="sr-only" for="amount">Amount:</label>
                                <input type="text" name="amount" value="<?php echo $transaction['amount']; ?>" class="form-control input-sm widetableinput" placeholder="Amount" required>
                            </td>
                            <td>
                                <label class="sr-only" for="datepaid">Date Paid:</label>
                                <input type="text" name="datepaid" value="<?php echo $datepaid ?>" class="form-control input-sm widetableinput" size="50" placeholder="Date Paid">
                            </td>
                            <td>
                                <label class="sr-only" for="paymethod">Payment Method:</label>
                                <input type="text" name="paymethod" value="<?php echo $transaction['paymethod']; ?>" class="form-control input-sm widetableinput" size="60" placeholder="Payment Method">
                            </td>
                            <td>
                                <label class="sr-only" for="transaction">Transaction:</label>
                                <input type="text" name="transaction" value="<?php echo $transaction['transaction']; ?>" class="form-control input-sm widetableinput" size="60" placeholder="Transaction">
                            </td>
                            <td>
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="btn btn-sm btn-primary" type="submit" name="savetransaction">SAVE</button>
                            </td>
                            </form>
                            <td>
                                <form action="/admin/money/<?php echo $transaction['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-sm btn-primary" type="submit" name="deletetransaction">DELETE</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                    </tbody>
                </table>
            </div>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>

