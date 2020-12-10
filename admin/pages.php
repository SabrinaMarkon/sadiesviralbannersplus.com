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
$allpages = new Page();
$pages = $allpages->getAllPages();
?>

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="/../js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
    tinymce.init({
        setup : function(ed) {
            ed.on('init', function() {
                this.getDoc().body.style.fontSize = '22px';
                this.getDoc().body.style.fontFamily = 'Calibri';
                this.getDoc().body.style.backgroundColor = $('.ja-content').css('background-color');
                this.getDoc().body.style.color = $('.ja-content').css('color');
            });
        },
        selector: 'textarea',  // change this value according to your HTML
        body_id: 'elm1=htmlcode',
        body_class: 'elm1=ja-content',
        height: 600,
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
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
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
    <div class="row">
        <div class="col-md-12">

            <h1 class="ja-bottompadding">Webpage Content</h1>

            <form action="/admin/pages" method="post" accept-charset="utf-8" class="form" role="form">
                <div class="form-group textfield">
                    <div class="row">
                        <div class="col-sm-2"><label for="id">Edit Page:</label></div>
                        <div class="col-sm-7">
                            <select name="id" class="form-control">
                                <option value="" disabled selected>Select page to edit</option>
                                <?php
                                foreach($pages as $page)
                                    if (isset($showeditpage) && $showeditpage !== '') {
                                        if ($page['id'] === $showeditpage['id']) {
                                            echo "<option value='" . $page['id'] . "' selected>" . $page['name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $page['id'] . "'>" . $page['name'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value='" . $page['id'] . "'>" . $page['name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="hidden" name="_method" value="POST">
                            <button class="btn btn-md btn-primary pull-left" type="submit" name="editpage" style="margin-right:10px;">EDIT</button>
                            <?php
                            if (isset($showeditpage) && $showeditpage !== '') {
                                ?>
                                <button class="btn btn-md btn-primary pull-left" type="button" name="showallpages"
                                        onclick="parent.location = '/admin/pages'">RETURN
                                </button>
                                <?php
                            }
                            ?>

                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
            </form>

            <?php
            if (isset($showeditpage) && $showeditpage !== '') {

                // EDIT EXISTING PAGE:
                ?>
                <form action="/admin/pages/<?php echo $showeditpage['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="name">Page Name</label>
                            <input type="text" name="name" placeholder="Page Name" class="form-control" value="<?php echo $showeditpage['name']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="slug">Page Slug (url)</label>
                            <?php
                            if ($showeditpage['core'] === 'yes') {
                                $disabled = "disabled";
                            } else {
                                $disabled = "";
                            }
                            ?>
                            <input type="text" name="slug" placeholder="Page Slug (url)" class="form-control" size="12"<?php echo $disabled ?> value="<?php echo $showeditpage['slug']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            Page URL: <a href="<?php echo $domain ?>/<?php echo $showeditpage['slug'] ?>" target="_blank"><?php echo $domain ?>/<?php echo $showeditpage['slug'] ?></a>
                            <div class="ja-bottompadding"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="htmlcode">Page HTML</label>
                            <textarea name="htmlcode" id="htmlcode" placeholder="Page HTML" class="form-control" rows="20"><?php echo $showeditpage['htmlcode']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="_method" value="GET">
                            <span>
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="id" value="<?php echo $showeditpage['id']; ?>">
                                <button class="btn btn-md btn-primary" type="submit" name="savepage">SAVE</button>
                            </span>
                            <span><button class="btn btn-md btn-primary" type="button" name="showallpages" onclick="parent.location = '/admin/pages'">CREATE NEW</button></span>
                </form>
                            <span>
                                <form action="/admin/pages/<?php echo $showeditpage['id']; ?>" method="post" accept-charset="utf-8" class="form inlineform" role="form">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="name" value="<?php echo $showeditpage['name'] ?>">
                                <button class="btn btn-md btn-primary" type="submit" name="deletepage">DELETE</button>
                                </form>           
                            </span>
                        </div>
                    </div>
                </div>
                <?php

            } else {

                // CREATE NEW PAGE:
                ?>
                <form action="/admin/pages" method="post" accept-charset="utf-8" class="form" role="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 mb-3"><label for="id">Create New Page:</label></div>
                            <div class="col-sm-12">
                                <label for="name">Page Name</label>
                                <input type="text" name="name" placeholder="Page Name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="name">Page Slug (url)</label>
                                <input type="text" name="slug" placeholder="Page Slug (url)" class="form-control" size="12">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="htmlcode">Page HTML</label>
                                <textarea name="htmlcode" id="htmlcode" placeholder="Page HTML" class="form-control" rows="20"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="_method" value="ADD">
                                <button class="btn btn-lg btn-primary" type="submit" name="addpage">ADD</button>
                            </div>
                        </div>
                    </div>
                </form>
                <?php

            }

        ?>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>