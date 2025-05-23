<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
if (isset($showad)) {
    echo $showad;
}

// if (isset($_GET['showad'])) {
// 	echo $showad;
// }

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
    $$key = $value;
}

$allmembers = new Member();
$members = $allmembers->getAllMembers();

$adtable = 'networksolos';
$allads = new NetworkSolo($adtable);
$ads = $allads->getAllAds();
?>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="/../js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
    tinymce.init({
        setup: function(ed) {
            ed.on('init', function() {
                this.getDoc().body.style.fontSize = '22px';
                this.getDoc().body.style.fontFamily = 'Calibri';
                this.getDoc().body.style.backgroundColor = $('.ja-content').css('background-color');
                this.getDoc().body.style.color = $('.ja-content').css('color');
            });
        },
        selector: 'textarea', // change this value according to your HTML
        body_id: 'elm1=htmlcode',
        body_class: 'elm1=ja-content',
        // height: 600,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        templates: [{
                title: 'Test template 1',
                content: 'Test 1'
            },
            {
                title: 'Test template 2',
                content: 'Test 2'
            }
        ],
        content_css: [
            //            '/../css/bootstrap.min.css',
            //            '/../css/bootstrap-theme.min.css',
            //            '/../css/custom.css'
        ]
    });
</script>
<!-- /tinyMCE -->

<div class="container">

    <h1 class="mb-2 pt-4">Sell Network Solos</h1>

    <form action="/admin/networksolos" method="post" class="form" role="form">

        <label for="networksoloprice" class="ja-toppadding">Price to Buy a Network Solo:</label>
        <input type="text" name="networksoloprice" value="<?php echo $networksoloprice ?>" class="form-control input-lg" placeholder="Price to Buy a Network Solo" maxlength="8" required>

        <div class="ja-bottompadding"></div>

        <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
        <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="saveadsettings">SAVE SETTINGS</button>

    </form>

    <div class="ja-bottompadding ja-toppadding"></div>

    <h1 class="ja-bottompadding">Give Member Blank Network Solos</h1>

    <form action="/admin/networksolos" method="post" class="form" role="form">

        <label for="username" class="ja-toppadding">Username:</label>
        <select name="username" class="form-control input-lg">
            <?php
            foreach ($members as $member) {
                $username = $member['username'];
                ?>
                <option value="<?php echo $username ?>"><?php echo $username ?></options>
                <?php
                }
                ?>
        </select>

        <label for="howmanytogive" class="ja-toppadding">How many?:</label>
        <input type="number" min="1" step="1" value="1" name="howmanytogive" class="form-control smallselect" required>

        <div class="ja-bottompadding"></div>

        <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
        <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="givememberblankad">GIVE BLANK ADS</button>

    </form>

    <div class="ja-bottompadding ja-toppadding"></div>

    <h1 class="ja-bottompadding">Create Network Solo</h1>

    <form action="/admin/networksolos" method="post" accept-charset="utf-8" class="form" role="form">

        <label for="username">For Username:</label>
        <select name="username" class="form-control input-lg">
            <option value="admin">admin</option>
            <?php
            foreach ($members as $member) {
                $username = $member['username'];
                $selected = "";
				if (isset($_POST['username'])) {
					if ($_POST['username'] === $username) {
						$selected = " selected";
					}
				}
                ?>
                <option value="<?php echo $username ?>"<?php echo $selected; ?>><?php echo $username ?></options>
                <?php
                }
                ?>
        </select>

        <label for="name">Name of Ad:</label>
        <input type="text" name="name" id="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"]: ''; ?>" class="form-control input-lg" placeholder="Name" required>

        <label for="title">Subject:</label>
        <input type="text" name="subject" id="subject" value="<?php echo isset($_POST["subject"]) ? $_POST["subject"]: ''; ?>" class="form-control input-lg" placeholder="Subject" required>

        <label for="url">URL:</label>
        <input type="url" name="url" id="url" value="<?php echo isset($_POST["url"]) ? $_POST["url"]: ''; ?>" class="form-control input-lg" placeholder="URL" required>

        <label for="description">Message:</label>
        <textarea name="message" class="form-control input-lg" rows="50" placeholder="Message" style="height: 600px;"><?php echo isset($_POST["message"]) ? $_POST["message"]: ''; ?></textarea>

        <div class="ja-bottompadding"></div>

        <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
        <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="createad">CREATE AD</button>

    </form>

    <div class="ja-bottompadding ja-toppadding"></div>

    <h1 class="ja-bottompadding ja-toppadding mb-4">All Member Network Solos</h1>

    <form action="/admin/networksolos" method="post" accept-charset="utf-8" class="form" role="form">
    <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
    <button class="btn btn-lg btn-primary mt-3 mb-5" type="submit" name="approveallads">APPROVE ALL</button>
    </form>

</div>

<div class="admintable-wrap mt-4">
    <table id="admintable" class="table table-hover text-center table-sm">
        <thead>
            <tr>
                <th class="text-center small">Ad&nbsp;#</th>
                <th class="text-center small">Approved</th>
                <th class="text-center small" style="min-width: 100px;">Username</th>
                <th class="text-center small" style="min-width: 100px;">Name</th>
                <th class="text-center small" style="min-width: 100px;">Subject</th>
                <th class="text-center small" style="min-width: 200px;">URL</th>
                <th class="text-center small">Short&nbsp;URL</th>
                <th class="text-center small" style="min-width: 400px;">Message</th>
                <th class="text-center small">Sent</th>
                <th class="text-center small">Clicks</th>
                <th class="text-center small" style="min-width: 150px;">Date</th>
                <th class="text-center small">Save</th>
                <th class="text-center small">Delete</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (!$ads) {
            } else {

                foreach ($ads as $ad) {

                    $adddate = $ad['adddate'];

                    if (trim($adddate) == '' || substr($adddate, 0, 10) == '0000-00-00') {

                        $dateadadded = 'Not Yet';
                    } else {

                        $dateadadded = date('Y-m-d');
                    }
            ?>
                    <tr>
                        <form action="/admin/networksolos/<?php echo $ad['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                            <td class="small align-baseline"><?php echo $ad['id']; ?>
                            </td>
                            <td class="small align-baseline<?php if ($ad['approved'] !== "1") { echo ' ja-coralbg'; } ?>">
                                <select name="approved" class="form-control widetableselect">
                                    <option value="0" <?php if ($ad['approved'] !== "1") {
                                                            echo "selected";
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($ad['approved'] === "1") {
                                                            echo "selected";
                                                        } ?>>Yes</option>
                                </select>
                            </td>
                            <td class="small align-baseline">
                                <select name="username" class="form-control input-sm widetableinput">
                                    <option value="admin"<?php if ($ad['username'] === 'admin') { echo " selected"; } ?>>admin</option>
                                    <?php
                                    foreach ($members as $member) {
                                        $username = $member['username'];
                                        ?>
                                        <option value="<?php echo $username ?>"<?php if ($ad['username'] === $username) { echo " selected"; } ?>><?php echo $username ?></options>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </td>
                            <td class="small align-baseline">
                                <input type="text" name="name" value="<?php echo $ad['name']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Name" required>
                            </td>
                            <td class="small align-baseline">
                                <input type="text" name="subject" value="<?php echo $ad['subject']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Subject" required>
                            </td>
                            <td class="align-baseline">
                                <input type="url" name="url" value="<?php echo $ad['url']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="http://" required>
                            </td>
                            <td class="align-baseline">
                                <a href="<?php echo $ad['shorturl'] ?>" target="_blank"><?php echo $ad['shorturl'] ?></a>
                            </td>
                            <td class="align-baseline">
                                <textarea class="form-control input-sm widetableinput" name="message" id="message" style="width: 400px; height: 150px;" placeholder="Message"><?php echo $ad['message'] ?></textarea>
                            </td>
                            <td class="small align-baseline">
                                <input type="sent" name="sent" value="<?php echo $ad['sent']; ?>" class="form-control input-sm widetableinput" size="12" placeholder="Sent">
                            </td>
                            <td class="small align-baseline">
                                <?php echo $ad['clicks']; ?>
                            </td>
                            <td class="small align-baseline">
                                <?php echo $dateadadded ?>
                            </td>
                            <td class="align-baseline">
                                <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
                                <input type="hidden" name="added" value="<?php echo $ad['added']; ?>">
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="btn btn-sm btn-primary" type="submit" name="savead">SAVE</button>
                            </td>
                        </form>
                        <td class="align-baseline">
                            <form action="/admin/networksolos/<?php echo $ad['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="name" value="<?php echo $ad['name']; ?>">
                                <button class="btn btn-sm btn-primary" type="submit" name="deletead">DELETE</button>
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
