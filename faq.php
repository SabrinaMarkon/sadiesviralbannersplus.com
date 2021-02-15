<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$faqarray = new Faq();
$faqs = $faqarray->getAllFaqs();

$showcontent = new PageContent();
echo $showcontent->showPage('FAQ Page');
?>
<div class="container">

    <h1 class="text-center mb-5">FAQ</h1>

    <div class="panel-group panel-faqs" id="accordion">

        <?php
        foreach ($faqs as $faq) {
        ?>
            <div class="faqpanel panel panel-default text-left pb-2">
                <div class="panel-heading pb-2">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $faq['positionnumber']; ?>">
                            <?php echo $faq['question']; ?>
                        </a>
                    </h4>
                </div>
                <?php
                if ($faq['positionnumber'] === 1) {
                ?>
                    <div class="panel-collapse collapse in" id="collapse<?php echo $faq['positionnumber']; ?>">
                    <?php
                } else {
                    ?>
                        <div class="panel-collapse collapse" id="collapse<?php echo $faq['positionnumber']; ?>">
                        <?php
                    }
                        ?>
                        <div class="panel-body">
                            <p><?php echo $faq['answer']; ?></p>
                        </div>
                        </div>
                    </div>
                <?php
            }
                ?>
            </div>
            <div class="pb-4"></div>
    </div>