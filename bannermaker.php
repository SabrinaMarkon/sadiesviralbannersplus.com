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

$showcontent = new PageContent();
echo $showcontent->showPage('Members Area Banner Maker Page');

$today = date("YmdHis");
$bannermaker = new BannerMaker();
$directory = "images/thumbnails";
$foldertree = $bannermaker->folderTree($directory);
$savedimages = $bannermaker->getAllBannersForUsername($username);
?>
<div class="bannermaker">

    <!-- Sidebar -->
    <nav id="bannermaker__sidebar" class="pb-3">
        <div class="bannermaker__sidebar-header">
            Make a Banner!
        </div>

        <div style="height: 10px;"></div>
        <div class="controlbuttons text-center">
            <button id="new" class="btn btn-yellow undoallorstartnew">NEW</button>
            <button id="preview" class="btn btn-yellow undoallorstartnew">PREVIEW</button>
            <button id="undo" class="btn btn-yellow">UNDO</button>
            <button id="clear" class="btn btn-yellow">CLEAR ALL</button>

            <div style="height: 10px;"></div>
            <div class="bannermaker__sidebar-header">
            Stuff To Add!
            </div>

            <div style="height: 10px;"></div>
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#collapse1" class="btn btn-yellow">DIMENSIONS</a>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body my-2">
                            Banner Width: <input type="number" id="bannerwidth" value="1000" class="editorinput"><span id="bannerwidtherror">
                                <span class="glyphicon glyphicon-exclamation-sign has-error" aria-hidden="true"></span><span class="has-error">Please enter an integer between 1 and 1000</span></span>
                            <div style="height: 10px;"></div>
                            Banner Height: <input type="number" id="bannerheight" value="300" class="editorinput"><span id="bannerheighterror">
                                <span class="glyphicon glyphicon-exclamation-sign has-error" aria-hidden="true"></span><span class="has-error">Please enter an integer between 1 and 1000</span></span>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#collapse2" class="btn btn-yellow">BACKGROUND</a>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body my-2">
                            Background Color: <select id="pickbgcolor" class="editorinput"></select>
                            <div style="height: 10px;"></div>
                            Select Image Category:<select id="pickbgimagefolder" class="editorinput">
                                <option value="none">None</option>
                                <?php echo $foldertree ?>
                            </select>
                            <div style="height: 10px;"></div>
                            Select Image:
                            <div style="height: 5px;"></div>
                            <div id="pickbgimage" class="editorinput ui-selectable">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#collapse3" class="btn btn-yellow">BORDER</a>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div class="panel-body my-2">
                            Border Color: <select id="pickbordercolor" class="editorinput"></select>
                            <div style="height: 10px;"></div>
                            Border Width: <input type="number" id="pickborderwidth" value="14" class="editorinput"><span id="borderwidtherror">
                                <span class="glyphicon glyphicon-exclamation-sign has-error" aria-hidden="true"></span><span class="has-error">Please enter an integer between 0 and 20</span></span>
                            <input type="hidden" id="pickborderstyle" value="solid">
                            <!-- <div style="height: 10px;"></div>
                            Border Style: <select id="pickborderstyle" class="editorinput">
                                <option value="none" selected="selected">None</option>
                                <option value="solid">solid</option>
                                <option value="dotted">dotted</option>
                                <option value="dashed">dashed</option>
                                <option value="double">double</option>
                                <option value="groove">groove</option>
                                <option value="ridge">ridge</option>
                                <option value="inset">inset</option>
                                <option value="outset">outset</option>
                            </select> -->
                            <div style="height: 10px;"></div>
                            <button id="borderadd" class="btn btn-pink half">APPLY!</button>&nbsp;<button id="borderdelete" class="btn btn-pink half">REMOVE</button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#collapse4" class="btn btn-yellow">ADD TEXT</a>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                        <div class="panel-body my-2">
                            Text to Add: <input type="text" id="texttoadd" class="editorinput">
                            <div style="height: 10px;"></div>
                            Font Color: <select id="picktextcolor" class="editorinput"></select>
                            <div style="height: 10px;"></div>
                            Font: <select id="picktextfont" class="editorinput">
                                <option value="Arial" style="font-family: Arial;" selected="selected">Arial</option>
                                <option value="Arial Black" style="font-family: Arial Black;">Arial Black</option>
                                <option value="Arial Narrow" style="font-family: Arial Narrow;">Arial Narrow</option>
                                <option value="Bebas Neue" style="font-family: Bebas Neue;">Bebas Neue</option>
                                <option value="Cabin" style="font-family: Cabin;">Cabin</option>
                                <option value="Century Gothic" style="font-family: Century Gothic;">Century Gothic</option>
                                <option value="Copperplate Gothic Light" style="font-family: Copperplate Gothic Light;">Copperplate / Copperplate Gothic Light</option>
                                <option value="Courier New" style="font-family: Courier New;">Courier New</option>
                                <option value="Franchise" style="font-family: Franchise;">Franchise</option>
                                <option value="Georgia" style="font-family: Georgia;">Georgia</option>
                                <option value="Gill Sans" style="font-family: Gill Sans;">Gill Sans / Gill Sans MT</option>
                                <option value="Helvetica" style="font-family: Helvetica;">Helvetica</option>
                                <option value="Impact" style="font-family: Impact;">Impact</option>
                                <option value="League Gothic" style="font-family: League Gothic;">League Gothic</option>
                                <option value="Lobster" style="font-family: Lobster;">Lobster</option>
                                <option value="Lucida Console" style="font-family: Lucida Console;">Lucida Console</option>
                                <option value="Lucida Sans Unicode" style="font-family: Lucida Sans Unicode;">Lucida Sans Unicode</option>
                                <option value="Luckiest Guy" style="font-family: Luckiest Guy;">Luckiest Guy</option>
                                <option value="Museo Slab" style="font-family: Museo Slab;">Museo Slab</option>
                                <option value="Myriad Pro" style="font-family: Myriad Pro;">Myriad Pro</option>
                                <option value="Palatino Italic" style="font-family: Palatino Italic;">Palatino Italic</option>
                                <option value="Palatino Linotype" style="font-family: Palatino Linotype;">Palatino Linotype</option>
                                <option value="PT Serif" style="font-family: PT Serif;">PT Serif</option>
                                <option value="Roboto" style="font-family: Roboto;">Roboto</option>
                                <option value="Tahoma" style="font-family: Tahoma;">Tahoma</option>
                                <option value="Tangerine" style="font-family: Tangerine;">Tangerine</option>
                                <option value="Times New Roman" style="font-family: Times New Roman;">Times New Roman</option>
                                <option value="Trebuchet MS" style="font-family: Trebuchet MS;">Trebuchet MS</option>
                                <option value="Ubuntu" style="font-family: Ubuntu;">Ubuntu</option>
                                <option value="Verdana" style="font-family: Verdana;">Verdana</option>
                            </select>
                            <div style="height: 10px;"></div>
                            Font Size: <input type="number" id="picktextsize" value="40" class="editorinput"><span id="textsizeerror">
                                <span class="glyphicon glyphicon-exclamation-sign has-error" aria-hidden="true"></span><span class="has-error">Please enter an integer between 1 and 300</span></span>
                            <div style="height: 10px;"></div>
                            <div class="checkboxes">
                                <div class="checkbox">
                                    <input id="bold" type="checkbox">
                                    <label for="bold"><strong>Bold</strong></label>
                                </div>
                                <div class="checkbox">
                                    <input id="italic" type="checkbox">
                                    <label for="italic"><em>Italic</em></label>
                                </div>
                                <div class="checkbox">
                                    <input id="underline" type="checkbox">
                                    <label for="underline"><u>Underline</u></label>
                                </div>
                            </div>
                            <button id="textadd" class="btn btn-pink half">APPLY!</button>
                            <!-- &nbsp;<button id="textdelete" class="btn btn-pink half">REMOVE</button> -->
                        </div>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#collapse5" class="btn btn-yellow">IMAGES</a>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse">
                        <div class="panel-body my-2">
                            Select Image Category:<select id="pickimagefolder" class="editorinput">
                                <option value="none">None</option>
                                <?php echo $foldertree ?>
                            </select>
                            <div style="height: 10px;"></div>
                            Select Image:
                            <div style="height: 5px;"></div>
                            <div id="pickimage" class="editorinput ui-selectable">
                            </div>
                            <div style="height: 10px;"></div>
                            <button id="imageadd" class="btn btn-pink half">APPLY!</button>
                            <!-- &nbsp;<button id="imagedelete" class="btn btn-pink half">REMOVE</button> -->
                            <div style="height: 15px;"></div>
                            Show Resize Handles: <select id="imagehandles" class="editorinput">
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                            </select>

                            <!--
                            <div style="height: 10px;"></div>
                            <label class="btn btn-default btn-file">
                            Upload Image: <input type="file" style="display: none;">
                            </label> UPLOAD FUNCTIONALITY AFTER -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Right Content to SLIDING NAV -->
    <div id="bannermaker__content">

        <nav class="navbar navbar-expand-lg">
            <button type="button" id="sidebarCollapse" class="btn btn-leftdrawer">
                <i class="fas fa-align-left fa-lg"></i>
            </button>
        </nav>

        <div id="maineditpane">

            <?php
            if (count($savedimages) > 0) {
            ?>
                <div id="savedimagesdiv">
                    <div class="panel-group" id="accordion2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapsesaved">
                                        Your Saved Banners</a>
                                </h4>
                            </div>
                            <div id="collapsesaved" class="panel-collapse collapse">
                                <div class="panel-body my-2">
                                    <ul id="savedimageslist" class="editorinput list-unstyled">
                                        <?php
                                        foreach ($savedimages as $savedimage) {
                                        ?>
                                            <li id="banner-<?php echo $savedimage['id']; ?>">
                                                <div><a href="<?php echo $domain; ?>/mybanners/<?php echo $savedimage['filename']; ?>" target="_blank"><?php echo $domain; ?>/mybanners/<?php echo $savedimage['filename']; ?></a></div>
                                                <div style="height: 10px;"></div>
                                                <div>
                                                    <?php
                                                    if ($savedimage['width'] > 300) {
                                                    ?>
                                                        <img src="mybanners/<?php echo $savedimage['filename']; ?>" width="300">
                                                    <?php
                                                    } elseif ($savedimage['height'] > 300) {
                                                    ?>
                                                        <img src="mybanners/<?php echo $savedimage['filename']; ?>" height="300">
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img src="mybanners/<?php echo $savedimage['filename']; ?>">
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div style="height: 10px;"></div>
                                                <div class="center">
                                                    <span>
                                                        <form method="GET" action="/bannermaker/<?php echo $savedimage['id']; ?>" accept-charset="UTF-8" class="form-horizontal">
                                                            <input name="id" type="hidden" value="<?php echo $savedimage['id']; ?>">
                                                            <button id="edit-<?php echo $savedimage['id']; ?>" class="btn btn-pink d-inline-block" type="button">EDIT</button>
                                                        </form>
                                                    </span>
                                                    <span>
                                                        <a href="/mybanners/<?php echo $savedimage['filename']; ?>" download="banner-<?php echo $savedimage['id']; ?>.png" class="btn btn-pink">DOWNLOAD</a>
                                                    </span>
                                                    <span>
                                                        <form method="POST" action="/bannermaker/<?php echo $savedimage['id']; ?>" accept-charset="UTF-8">
                                                            <input name="id" type="hidden" value="<?php echo $savedimage['id']; ?>">
                                                            <button id="delete-<?php echo $savedimage['id']; ?>" name="deletebannermaker" class="btn btn-pink d-inline-block" type="button">DELETE</button>
                                                        </form>
                                                    </span>
                                                </div>
                                                <hr>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <div id="canvascontainer">

            </div>
            <div id="trashcandiv">
                <img src="/images/trashcan.png" class="img-responsive" id="trashcan">
                <span>You can drag stuff to the trash and drop it in!</span>
            </div>
            <div id="savediv">

            </div>
            <div id="savebuttondiv">
                <input type="hidden" id="username" value="<?php echo $username; ?>">
                <form method="post" enctype="multipart/form-data" action="/bannermaker" id="saveform">
                    <input type="hidden" name="editingexistingimageid" id="editingexistingimageid" value="">
                    <input type="hidden" name="img_val" id="img_val" value="">
                    <input type="hidden" name="img_obj" id="img_obj" value="">
                    <input type="hidden" name="htmlcode" id="htmlcode" value="">
                    <button id="savebutton" name="savebannermaker" class="btn btn-yellow">SAVE BANNER</button>
                </form>
            </div>
            <div style="height: 20px;"></div>
        </div>
    </div>

    <div class="ja-bottompadding"></div>
</div>