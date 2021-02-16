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

    <div id="faqpanel" class="faqpanel" role="tablist" aria-multiselectable="true">

        <?php
        foreach ($faqs as $faq) {
        ?>

            <div class="faq mb-4">
                <h5 class="faq-heading" role="tab" id="heading<?php echo $faq['positionnumber']; ?>">
                    <a data-toggle="collapse" data-parent="#faqpanel" href="#collapse<?php echo $faq['positionnumber']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $faq['positionnumber']; ?>" class="collapsed d-block">
                        <i class="fa fa-chevron-down"></i> <?php echo $faq['question']; ?>
                    </a>
                </h5>

                <div id="collapse<?php echo $faq['positionnumber']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $faq['positionnumber']; ?>">
                    <div class="faq-body p-3">
                        <p><?php echo $faq['answer']; ?></p>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>

        <div class="mb-5"></div>

    </div>

</div>