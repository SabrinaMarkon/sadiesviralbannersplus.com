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

$allmembers = new Member();
$members = $allmembers->getAllMembers();

$alldownloads = new Download();
$downloads = $alldownloads->getAllDownloads();
?>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="/../js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
    tinymce.init({
        setup: function(ed) {
            ed.on('init', function() {
                this.getDoc().body.style.fontSize = '1em';
                this.getDoc().body.style.fontFamily = 'Calibri';
                this.getDoc().body.style.backgroundColor = '#ffffff';
            });
        },
        selector: 'textarea', // change this value according to your HTML
        body_id: 'elm1=message',
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

    <?php
    if ($downloads && $members) {
    ?>
        <h1 class="ja-bottompadding">Give Download Access to Member</h1>

        <form action="/admin/downloads" method="post" accept-charset="utf-8" class="form" role="form">

            <table id="admintable" class="table table-condensed table-bordered table-striped table-hover text-center table-sm">
                <tbody>
                    <tr>
                        <td><label for="username">For Username:</label></td>
                        <td>
                            <select name="username" class="form-control widetableselect">
                                <option value=""> - Select - </option>
                                <?php
                                foreach ($members as $member) {
                                    $username = $member['username'];
                                    // TODO: Show "yes" for the downloads the user already has access to.
                                    $downloadaccessarray = $alldownloads->getAllUserDownloads($username);
                                ?>
                                    <option value="<?php echo $username ?>"><?php echo $username ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php
                    foreach ($downloads as $download) {
                        $dlid = $download['id'];
                        $downloadname = $download['name'];
                    ?>
                        <tr>
                            <td><label for="download-<?php echo $dlid ?>">Give Access to Download: <?php echo $downloadname ?></label></td>
                            <td>
                                <select name="download-<?php echo $dlid ?>" class="form-control widetableselect">
                                    <option value="yes">YES</option>
                                    <option value="no">NO</option>
                                </select>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <div class="ja-bottompadding"></div>

            <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="givedownload">GIVE DOWNLOADS</button>

        </form>

        <div class="ja-bottompadding ja-toppadding"></div>
    <?php
    }
    ?>

    <h1 class="ja-bottompadding">Create New Download</h1>

    <form action="/admin/downloads" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="form" role="form">

        <label for="downloadname">Download Name:</label>
        <input type="text" name="downloadname" class="form-control input-lg" placeholder="Download Name" required>

        <label for="downloadtype">Link or File Upload?:</label>
        <select name="downloadtype" id="downloadtype" class="form-control w-50" onchange="setupExtraFields(document.getElementById('downloadtype').value)">
            <option value=""> - Select - </option>
            <option value="link">Link</option>
            <option value="file">File</option>
        </select>

        <span name="downloadoptionsfields" id="downloadoptionsfields" style="visibility: hidden; display: none;"></span>

        <label for="downloaddescription">Download Description:</label>
        <textarea name="downloaddescription" value="" class="form-control input-lg" rows="50" placeholder="Download Description" style="height: 600px;"></textarea>

        <div class="ja-bottompadding"></div>

        <input type="hidden" name="downloadsfolder" value="<?php echo $downloadsfolder ?>" />

        <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="adddownload">CREATE DOWNLOAD</button>

    </form>

    <div class="ja-bottompadding ja-toppadding"></div>

    <h1 class="ja-bottompadding ja-toppadding mb-4">All Downloads</h1>

    <?php
    if (!$downloads) {
    } else {

        foreach ($downloads as $download) {

            $dateadded = $download['dateadded'];

            if (trim($dateadded) == '' || substr($dateadded, 0, 10) == '0000-00-00') {

                $dateadded = '';
            } else {

                $dateadded = date('Y-m-d');
            }

    ?>
            <div class="table-responsive">
                <table id="admintable" class="table table-hover table-condensed table-bordered text-center" style="margin-bottom: 2px;">
                    <thead>
                        <tr>
                            <th class="text-center small">#</th>
                            <th class="text-center small" style="min-width: 150px;">Name</th>
                            <th class="text-center small">Type</th>
                            <th class="text-center small" style="min-width: 200px;">URL</th>
                            <th class="text-center small">File</th>
                            <th class="text-center small" style="min-width: 150px;">Date&nbsp;Added</th>
                            <th class="text-center small" style="min-width: 500px;">Description</th>
                            <th class="text-center small">Save</th>
                            <th class="text-center small">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="downloadtable">
                        <tr>
                            <form action="/admin/downloads/<?php echo $download['id']; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="form" role="form">
                                <td>
                                    <?php echo $download['id']; ?>
                                </td>
                                <td>
                                    <input type="text" name="downloadname" value="<?php echo $download['name']; ?>" class="form-control input-sm widetableinput" placeholder="Download Name" required>
                                </td>
                                <td>
                                    <select name="downloadtype" class="form-control input-sm widetableselect">
                                        <option value="link" <?php if ($download['type'] == "link") {
                                                                    echo "selected";
                                                                } ?>>Link</option>
                                        <option value="file" <?php if ($download['type'] != "link") {
                                                                    echo "selected";
                                                                } ?>>File</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="downloadurl" value="<?php echo $download['url']; ?>" class="form-control input-sm widetableinput" placeholder="Download URL">
                                </td>
                                <td>
                                    <?php
                                    if ($download['file'] !== "") {
                                    ?>
                                        <br><a href="<?php echo $domain ?>/downloads/<?php echo $download['file']; ?>" target="_blank"><?php echo $domain ?>/downloads/<?php echo $download['file']; ?></a><br><br>
                                    <?php
                                    }
                                    ?>
                                    <input type="file" name="downloadfile" size="14" maxlength="255" class="form-control input-sm widetableinput">
                                </td>
                                <td><?php echo $dateadded ?></td>
                                <td style="min-width: 500px;">
                                    <textarea name="downloaddescription" class="form-control input-sm widetableinput012" rows="3" placeholder="Download Description" required><?php echo $download['description']; ?></textarea>
                                </td>
                                <td>
                                    <input type="hidden" name="_method" value="PATCH">
                                    <input type="hidden" name="downloadsfolder" value="<?php echo $downloadsfolder ?>" />
                                    <input type="hidden" name="olddownloadfile" value="<?php echo $download['file']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $download['id']; ?>">
                                    <button class="btn btn-sm btn-primary" type="submit" name="savedownload">SAVE</button>
                                </td>
                            </form>
                            <td>
                                <form action="/admin/downloads/<?php echo $download['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="downloadsfolder" value="<?php echo $downloadsfolder ?>" />
                                    <input type="hidden" name="deletedownloadfile" value="<?php echo $download['file']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $download['id']; ?>">
                                    <button class="btn btn-sm btn-primary" type="submit" name="deletedownload">DELETE</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="ja-bottompadding"></div>
    <?php
        }
    }
    ?>
</div>