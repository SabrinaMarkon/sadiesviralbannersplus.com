<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
if (isset($show)) {
    echo $show;
}

$allfaqs = new Faq();
$faqs = $allfaqs->getAllFaqs();
?>
<div class="container">

    <h1 class="ja-bottompadding">Create New FAQ</h1>

    <form action="/admin/faq" method="post" accept-charset="utf-8" class="form" role="form">

        <label for="question">FAQ Question:</label>
        <input type="text" name="question" class="form-control input-lg" placeholder="FAQ Question" required>

        <label for="answer">FAQ Answer:</label>
        <input type="text" name="answer" class="form-control input-lg" placeholder="FAQ Answer" required>

        <div class="ja-bottompadding"></div>

        <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="createfaq">CREATE FAQ</button>

    </form>

    <div class="ja-bottompadding ja-toppadding"></div>

    <h1 class="ja-bottompadding ja-toppadding mb-4">All FAQs</h1>

    <div class="table-responsive">
        <table id="admintable" class="table table-hover table-condensed table-bordered text-center">
            <thead>
                <tr>
                    <th class="text-center">Reorder</th>
                    <th class="text-center">ID</th>
                    <th class="text-center" style="min-width: 100px;">Question</th>
                    <th class="text-center" style="min-width: 100px;">Answer</th>
                    <th class="text-center">Order</th>
                    <th class="text-center">Save</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody class="faqtable">

                <?php
                if (!$faqs) {
                } else {

                    foreach ($faqs as $faq) {

                ?>
                        <tr>
                            <form action="/admin/faq/<?php echo $faq['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                                <td class="reorder"><i class="fas fa-sort fa-lg"></i></td>
                                <td>
                                    <?php echo $faq['id']; ?>
                                </td>
                                <td>
                                    <textarea name="question" class="form-control input-lg" rows="3" placeholder="FAQ Question" required><?php echo $faq['question']; ?></textarea>
                                </td>
                                <td>
                                    <textarea name="answer" class="form-control input-lg" rows="3" placeholder="FAQ Answer" required><?php echo $faq['answer']; ?></textarea>
                                </td>
                                <td>
                                    <?php echo $faq['positionnumber']; ?>
                                </td>
                                <td>
                                    <input type="hidden" name="_method" value="PATCH">
                                    <input type="hidden" name="positionnumber" value="<?php echo $faq['positionnumber']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
                                    <button class="btn btn-sm btn-primary" type="submit" name="savefaq">SAVE</button>
                                </td>
                            </form>
                            <td>
                                <form action="/admin/faq/<?php echo $faq['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="positionnumber<?php echo $faq['id']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
                                    <button class="btn btn-sm btn-primary" type="submit" name="deletefaq">DELETE</button>
                                </form>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>

    <div class="ja-bottompadding"></div>

</div>