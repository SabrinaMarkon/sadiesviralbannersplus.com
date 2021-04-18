// PHPSS-BannerMakerApp by Sabrina Markon 2016 phpsitescripts@outlook.com
// 2020 TODO: Rewrite without jQuery - make a React component or library.
// TODO: arrows to allow layers to be moved up or down in the stack.
// TODO: image uploads.
// TODO: Make mobile friendly.
$(function() {

    // $.unblockUI();

    $('#sidebarCollapse').on('click', function() {
        $('#bannermaker__sidebar').toggleClass('active');
    });

    $('#savebuttondiv').hide(); // Default hide the save banner button when page is loaded.

    // *** Uncomment if license watermarks will be used in this website:
    // ADD WATERMARK IF USER IS UNLICENSED:
    // var username = $('#username').val();
    // $.ajax({
    //     url: 'banners/licensecheck/' + username,
    //     type: 'post',
    //     data: { 'username' : username, '_method' : 'POST' },
    //     success: function(data) {
    //         // data = yes if a watermark is needed.
    //         if (data === 'no') {
    //             $('#canvascontainer').append($('<div id="watermark"  class="ui-widget-content"></div>')
    //                 .draggable({ containment : "#canvascontainer" }));
    //         } else {
    //             $('#canvascontainer').append($('<div id="watermark"  class="ui-widget-content">SadiesBannerCreator.com</div>')
    //                 .draggable({ containment : "#canvascontainer" }));
    //         }
    //         $('#watermark').css({
    //             'background' : '#fff',
    //             'border' : '1px solid #000',
    //             'color' : '#000',
    //             'font-family' : 'Roboto, sans-serif',
    //             'padding-left' : '1px',
    //             'padding-right' : '1px',
    //             'font-size' : '10px',
    //             'z-index' : '1001',
    //             'cursor' : 'pointer',
    //             'position' : 'absolute',
    //             'right' : '0',
    //             'bottom' : '0'
    //         });
    //         if (data === 'no') {
    //             $('#watermark').css({
    //                 'display' : 'none'
    //             });
    //         } else {
    //             $('#watermark').css({
    //                 'display' : 'inline-block'
    //             });
    //         }
    //     }
    // });

    // BANNER WIDTH:
    $('#bannerwidth').on('keyup mouseup', function() {
        var value = $(this).val();
        if ($.isNumeric(value) && Math.floor(value) == +value && (value > 0 && value < 1001 && value !== null)) {
            $('#bannerwidtherror').css({'visibility' : 'hidden', 'display' : 'none'});
            var canvascontainer = document.getElementById("canvascontainer");
            $(canvascontainer).css('width', value);
            $('#watermark').css({ 'right' : '0', 'bottom' : '0' });
        } else {
            $('#bannerwidtherror').css({'visibility' : '', 'display' : 'block'});
        }
    }).keyup();

    // BANNER HEIGHT:
    $('#bannerheight').on('keyup mouseup', function() {
        var value = $(this).val();
        if ($.isNumeric(value) && Math.floor(value) == +value && (value > 0 && value < 1001 && value !== null)) {
            $('#bannerheighterror').css({'visibility' : 'hidden', 'display' : 'none'});
            var canvascontainer = document.getElementById("canvascontainer");
            $(canvascontainer).css('height', value);
            // change below: We want to REMOVE the watermark div then readd in the right position!!!!!!!!!!!!
            $('#watermark').css({ 'right' : '0', 'bottom' : '0' });
        } else {
            $('#bannerheighterror').css({'visibility' : 'visible', 'display' : 'block'});
        }
    }).keyup();

    // BACKGROUND COLOR:
    $('#pickbgcolor').on('change', function() {
        if (this.value === 'transparent') {
            $('#pickbgcolor').css({ 'background' : 'transparent', 'color' : '' });
            $('#canvascontainer').css({ 'background' : 'transparent url("/images/canvasbg.gif")' });
        } else {
            $('#pickbgcolor').css({ 'background' : this.value, 'color' : idealTextColor(this.value) });
            $('#canvascontainer').css({ 'background' : this.value });
        }
    });

    //  SELECT BACKGROUND IMAGE DIRECTORY FROM SELECT ELEMENT. LOAD BACKGROUND FILE SELECTION BOX WiTH FILES FROM THIS DIRECTORY:
    $('#pickbgimagefolder').on('change', function() {
        //var which = this.id; // gives the id of the select box - pickbgimagefolder
        var folder = this.value; // gives the id value of the SELECTED image directory in the selection box.
        if (folder === 'none') {
            $('#pickbgimage').empty();
            var pickbgcolor = $('#pickbgcolor').val();
            if (pickbgcolor === 'transparent') {
                $('#canvascontainer').css({ 'background' : 'transparent url("/images/canvasbg.gif")' });
            } else {
                $('#canvascontainer').css({ 'background' : pickbgcolor });
            }
        } else {
            $('#pickbgimage').empty();
            $.ajax({
                url: 'apis/bannermakerfolderimages.php',
                type: "post",
                data: folder,
                success: function(data){
                    // update the display to show the chosen images in pickbgimage div:
                    $('#pickbgimage').append(data);
                }
            });
        }
    });

    // MAKE BACKGROUND IMAGE FILES IN THE BACKGROUND FILE SELECTION BOX SELECTABLE. ADD BACKGROUND IMAGE:
    $("#pickbgimage").selectable({
        selected: function(event, ui) {
            $(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");
            var pickbgimage_filename = $(ui.selected).attr('id');
            //alert(pickbgimage_filename);
            if (pickbgimage_filename !== 'none' && pickbgimage_filename !== undefined && pickbgimage_filename !== '') {
                var pickbgimage_folder = $('#pickbgimagefolder').val();
                // apply the full sized image from editorimages image library, rather than the thumbnail.
                var pickbgimage_path = 'images/editorimages/' + pickbgimage_folder + '/' + pickbgimage_filename;
                $('#canvascontainer').css({ 'background' : 'url("' + pickbgimage_path + '")', 'background-size' : '100% 100%' });
            } else {
                $('#canvascontainer').css({ 'background' : '' });
            }
        },
        selecting: function(event, ui){
            // if( $(".ui-selected, .ui-selecting").length > 1){
            //     $(ui.selecting).removeClass("ui-selecting");
            // }
        },
        cancel: 'a'
    });

    // BORDER COLOR:
    $('#pickbordercolor').on('change', function() {
        var pickborderwidth = document.getElementById('pickborderwidth').value;
        var pickborderstyle = document.getElementById('pickborderstyle').value;
        if (this.value === 'transparent') {
            $('#pickbordercolor').css({ 'background' : 'transparent', 'color' : '' });
        } else {
            $('#pickbordercolor').css({ 'background' : this.value, 'color' : idealTextColor(this.value) });
        }
    });

    // BORDER WIDTH:
    $('#pickborderwidth').on('keyup mouseup', function() { // works with both keyboard entry or the number field's up/down arrows.
        var value = $(this).val();
        if ($.isNumeric(value) && Math.floor(value) == +value && (value > -1 && value < 21 && value !== null)) {
            $('#borderwidtherror').css({'visibility' : 'hidden', 'display' : 'none'});
        } else {
            $('#borderwidtherror').css({'visibility' : 'visible', 'display' : 'block'});
        }
    }).keyup();

    // ADD BORDER:
    $('#borderadd').on('click', function() {
        var pickbordercolor = document.getElementById('pickbordercolor').value;
        var pickborderwidth = document.getElementById('pickborderwidth').value;
        var pickborderstyle = document.getElementById('pickborderstyle').value;
        if (pickbordercolor === 'transparent' || pickborderwidth < 1 || pickborderstyle === 'none') {
            $('#canvascontainer').css({ 'border' : '0 transparent' });
        } else {
            $('#canvascontainer').css( { 'border' : pickborderwidth + 'px ' + pickborderstyle + ' ' + pickbordercolor });
        }
    });

    // DELETE BORDER:
    $('#borderdelete').on('click', function() {
        $('#canvascontainer').css({ 'border' : '0 transparent' });
    });

    // FONT COLOR:
    $('#picktextcolor').on('change', function() {
        $('#picktextcolor').css({ 'background' : this.value, 'color' : idealTextColor(this.value) });
    });

    // FONT SIZE:
    $('#picktextsize').on('keyup mouseup', function() {
        var value = $(this).val();
        if ($.isNumeric(value) && Math.floor(value) == +value && (value > 0 && value < 301 && value !== null)) {
            $('#textsizeerror').css({'visibility' : 'hidden', 'display' : 'none'});
        } else {
            $('#textsizeerror').css({'visibility' : 'visible', 'display' : 'block'});
        }
    }).keyup();


    // ADD TEXT:
    $('#textadd').on('click', function() {
        var text = document.getElementById('texttoadd').value;
        // spaces in text result in undesireable word wrapping sometimes so we can do css white-space: nowrap or replace spaces with nbsp;
        text = text.split(" ").join("&nbsp;");
        var fontcolor = document.getElementById('picktextcolor').value;
        var fontfamily = document.getElementById('picktextfont').value;
        var fontsize = document.getElementById('picktextsize').value;
        var bold = document.getElementById('bold').checked;
        var italic = document.getElementById('italic').checked;
        var underline = document.getElementById('underline').checked;
        var textstyle = "white-space: nowrap;  color: " + fontcolor + "; font-family: " + fontfamily + "; font-size: " + fontsize + "px; background: none; border: 0px;";
        if (bold) { textstyle += " font-weight: bold;"; } else { textstyle += " font-weight: normal;"; }
        if (italic) { textstyle += " font-style: italic;"; } else { textstyle += " font-style: normal;"; }
        if (underline) { textstyle += " text-decoration: underline;"; } else { textstyle += " text-decoration: none;"; }

        var newid = $("#canvascontainer > div").length + 1;

        // RESIZABLE TEXT (commented out because between this and the images, there are too many resize handles and font size can be specified beforehand)
        // $('#canvascontainer').append($('<div id="' + newid + '"  class="ui-widget-content canvaslayer draggable" style="' + textstyle + '">' + text + '</div>')
        //     .draggable({ containment : "#canvascontainer" })
        //     .resizable({
        //       containment: "#canvascontainer",
        //       handles: "nw, ne, sw, se",
        //       resize : function(event, ui) {
        //       // handle fontsize here
        //       //console.log(ui.size); // gives you the current size of the div
        //       var size = ui.size;
        //       // something like this change the values according to your requirements
        //       $(this).css("font-size", (size.width * size.height)/1000 + "px");
        //       }
        //   }));

        $('#canvascontainer').append($('<div id="' + newid + '"  class="ui-widget-content canvaslayer draggable" style="' + textstyle + '">' + text + '</div>')
            .draggable({ containment : "#body" }));
    });

    // TEXT BOLD:
    $('#bold').click(function(){
        $('#texttoadd').toggleClass('bold');
        $("#textcount").toggleClass('bold');
        if($('#textcount').hasClass('bold')) {
            $('#textcount').css('font-weight', 'bold');
        } else {
            $('#textcount').css('font-weight', 'normal');
        }
    });

    // TEXT ITALIC:
    $('#italic').click(function(){
        $('#texttoadd').toggleClass('italic');
        $("#textcount").toggleClass('italic');
        if($('#textcount').hasClass('italic')) {
            $('#textcount').css('font-style', 'italic');
        } else {
            $('#textcount').css('font-style', 'normal');
        }
    });

    //  SELECT IMAGE DIRECTORY FROM SELECT ELEMENT. LOAD FILE SELECTION BOX WiTH FILES FROM THIS DIRECTORY:
    $('#pickimagefolder').on('change', function() {
        //var which = this.id; // gives the id of the select box - pickimagefolder
        var folder = this.value; // gives the id value of the SELECTED image directory in the selection box.
        if (folder === 'none') {
            $('#pickimage').empty();
        } else {
            $('#pickimage').empty();
            $.ajax({
                url: 'apis/bannermakerfolderimages.php',
                type: "post",
                data: folder,
                success: function(data){
                    // update the display to show the chosen images in pickbgimage div:
                    $('#pickimage').append(data);
                }
            });
        }
    });

    // MAKE IMAGE FILES IN THE FILE SELECTION BOX SELECTABLE:
    $("#pickimage").selectable({
        selected: function(event, ui) {
            $(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");
            var chosenfile = $(ui.selected).attr('id');
            //alert(chosenfile);
        },
        selecting: function(event, ui){
            // if( $(".ui-selected, .ui-selecting").length > 1){
            //     $(ui.selecting).removeClass("ui-selecting");
            // }
        },
        cancel: 'a'
    });

    // ADD IMAGE:
    $('#imageadd').on('click', function() {
        var pickimage_filename = $('#pickimage > .ui-selected').attr('id'); // pickimage_filename is the id of the selected image.
        //alert(pickimage_filename);

        if (pickimage_filename !== 'none' && pickimage_filename !== undefined && pickimage_filename !== '') {
            var canvascontainer = document.getElementById("canvascontainer");
            var imgstyle = "background: none; display:inline-block; width: 100%; height: 100%;";
            var newid = $("#canvascontainer > div").length + 1;
            var pickimage_folder = $('#pickimagefolder').val();
            // apply the full sized image from editorimages image library, rather than the thumbnail.
            var pickimage_path = 'images/editorimages/' + pickimage_folder + '/' + pickimage_filename;
            var elem = $('<div id="' + newid + '" class="ui-widget-content canvaslayer picture draggable"><img src="' + pickimage_path + '" style="' + imgstyle + '"></div>');
            $('#canvascontainer').append(elem);
            elem.resizable({
                handles: "nw, ne, sw, se",
                aspectRatio: false
            });
            elem.draggable();
            $(".ui-resizable-handle").show();
            $('#imagehandles').val('yes');
        }
    });

    // TOGGLE RESIZE HANDLES:
    $('#imagehandles').on('change', function() {
        if (document.getElementById('imagehandles').value === 'no') {
            $(".ui-resizable-handle").hide();
        } else {
            $(".ui-resizable-handle").show();
        }
    });

    // UNDO ONE BY ONE:
    $('#undo').on('click', function() {
        if ($('#canvascontainer').find('.canvaslayer').length) {
            if (canvascontainer.lastChild.id !== 'watermark') {
                canvascontainer.removeChild(canvascontainer.lastChild);
                $('#savediv').empty();
                $('#img_val').empty();
                $('#img_obj').empty();
                $('#savebuttondiv').hide();
            }
        }
    });

    // UNDO ALL OR START A NEW IMAGE:
    var UndoAllOrStartNew = function(){
        $('#canvascontainer').contents().filter(function () {
            return this.id != "watermark";
        }).remove();
        $('#canvascontainer').css({ 'border' : '0 transparent', 'background' : '' });
        $('#savediv').empty();
        $('#img_val').empty();
        $('#img_obj').empty();
        $("#bannerwidth").val('1000');
        $("#bannerheight").val('300');
        $('#pickbgcolor').val('transparent');
        $('#pickbgcolor').css({ 'background' : 'transparent' });
        $('#pickbgimage').val('none');
        $('#pickbordercolor').val('transparent');
        $('#pickbordercolor').css({ 'background' : 'transparent' });
        $("#pickborderwidth").val('14');
        $("#pickborderstyle").val('solid');
        $('#savebuttondiv').hide();
        $('#canvascontainer').css({ 'width' : '1000px', 'height' : '300px' });
        $('#editingexistingimageid').val();
    }
    $('#clear, #new').on('click', UndoAllOrStartNew);

    // PREVIEW IMAGE:
    $("#preview").click(function() {
        $('#savediv').empty();
        // is there a background image?
        var bg = '';
        if ($('#canvascontainer').css('background-image') !== 'none') {
            var sub = $('#canvascontainer').css('background-image');
            // is it the default background?
            if (sub.substr(sub.length - 14) === 'canvasbg.gif")') {
                bg = 'undefined';
            } else {
                bg = sub;
            }
        } else {
            bg = $('#canvascontainer').css('background-color');
        }
        $(".ui-resizable-handle").hide();
        html2canvas($("#canvascontainer"), {
            background: bg,
            logging: true,
            allowTaint: true,
            onrendered: function(canvas) {
                theCanvas = canvas;
                $('#savediv').append('<h3>Your Banner:</h3><br />');
                $('#savediv').append(canvas);
                //Show the download button.
                $('#savebuttondiv').show();
                // Set hidden field's value to image data (base-64 string)
                $('#img_val').val(canvas.toDataURL("image/png"));
                // Put other settings for the image in an object and assign to img_obj hidden field.
                var img_obj = new Object();
                img_obj.width = $("#bannerwidth").val();
                img_obj.height = $("#bannerheight").val();
                img_obj.bgcolor = $("#pickbgcolor").val();
                img_obj.bordercolor = $("#pickbordercolor").val();
                img_obj.borderwidth = $("#pickborderwidth").val();
                img_obj.borderstyle = $("#pickborderstyle").val();
                // get img_obj.bgimage if there is one:
                var pickbgimage_url = $('#canvascontainer').css('background-image');
                img_obj.bgimage = 'none'; // by default
                if (pickbgimage_url !== 'none') {
                    // chance img_ob.bgimage to file path instead of 'none'.
                    var pickbgimage_path = pickbgimage_url.substring(5, pickbgimage_url.length - 2); // remove the url('') part of the background-image property.
                    var pickbgimage_filename = String(pickbgimage_path.split('/').slice(-1)); // get the filename of the background-image property.
                    var pickbgimage_folder_and_filename = String(pickbgimage_path.split('/').slice(-2). join('/')); // get the folder and filename of the background-image property.
                    //alert(pickbgimage_filename + ' ' + pickbgimage_folder_and_filename);
                    if (pickbgimage_filename !== 'none' && pickbgimage_filename !== undefined && pickbgimage_filename !== '' && pickbgimage_filename !== 'canvasbg.gif') {
                        // apply the full sized image from editorimages image library, rather than the thumbnail.
                        var pickbgimage_path = 'images/editorimages/' + pickbgimage_folder_and_filename;
                        img_obj.bgimage = pickbgimage_path;
                    }
                }
                $('#img_obj').val(JSON.stringify(img_obj));
                // htmlcode field to save into the database.
                document.getElementById('htmlcode').value = document.getElementById('canvascontainer').innerHTML;
            }
        });
    });

    // SAVE IMAGE:
    $("#savebutton").on('click', function() {
        document.getElementById("saveform").submit();
    });

    // EDIT OR DELETE IMAGE:
    $("#savedimageslist li").each(function(e) {
        var id = $(this).attr('id').split('-')[1];
        // EDIT SAVED IMAGE:
        $('#edit-' + id).click(function() {
            $.ajax({
                url: 'apis/bannermakeractions.php',
                type: "post",
                data: { 'action': 'edit', 'id' : id },
                success: function(data){
                   console.log(data);
                    // update the display to show the chosen database object (in data variable):
                    $("#canvascontainer").css( { 'width' : data.width });
                    $("#canvascontainer").css( { 'height' : data.height });
                    $("#canvascontainer").css( { 'background' : data.bgcolor });
                    if (data.bgimage === 'none') {
                        $('#canvascontainer').css({ 'background' : data.bgcolor });
                        $('#pickbgcolor').css({ 'background' : data.bgcolor });
                        $('#pickbgcolor').val(data.bgcolor);
                        $('#pickbgimage').val('none');
                    } else {
                        $('#canvascontainer').css({ 'background' : 'url("' + data.bgimage + '")', 'background-size' : '100% 100%', 'background-size' : '100% 100%' });
                        $('#pickbgcolor').css({ 'background' : '' });
                        $('#pickbgcolor').val('transparent');
                        $('#pickbgimage').val(data.bgimage);
                    }
                    if (data.bordercolor === 'none') {
                        $('#canvascontainer').css({ 'border-color' : '' });
                        $('#pickbordercolor').val('transparent');
                        $('#pickbordercolor').css({ 'background' : '' });
                    } else {
                        $('#canvascontainer').css({ 'border-color' : data.bordercolor });
                        $('#pickbordercolor').val(data.bordercolor);
                        $('#pickbordercolor').css({ 'background' : data.bordercolor });
                    }
                    $("#canvascontainer").css( { 'border-width' : data.borderwidth });
                    if (data.bordercolor !== 'transparent') {
                        $("#canvascontainer").css( { 'border-style' : data.borderstyle });
                    }
                    $("#bannerwidth").val(data.width);
                    $("#bannerheight").val(data.height);
                    $("#pickborderwidth").val(data.borderwidth);
                    $("#pickborderstyle").val(data.borderstyle);
                    // data.htmlcode needs to be added to the canvascontainer one div at a time (????)
                    var htmlcode = data.htmlcode;
                    htmlcode = htmlcode.replace(/hidden/g, 'visible');
                    $('#canvascontainer').empty();
                    $(htmlcode + ' .canvaslayer[id]').each(function() {
                        var elem = $(this);
                        $('#canvascontainer').append(elem);
                            if (elem.hasClass('picture')) { // it is an image so needs to be resizable.
                            elem.resizable({
                                handles: "nw, ne, sw, se",
                                aspectRatio: false
                            });
                            $('.ui-resizable-handle').css({ 'display' : 'block' });
                        }
                        if (elem.attr('id') === 'watermark') {
                        elem.draggable({ containment : "#canvascontainer" });
                        } else {
                        elem.draggable();
                        }
                    });
                    $('#editingexistingimageid').val(data.id);
                }
            });
        });


        // DELETE SAVED IMAGE:
        $('#delete-' + id).click(function(e) {
            $.ajax({
                url: 'apis/bannermakeractions.php',
                type: "post",
                data: { 'action': 'delete', 'id' : id },
                success: function(data){
                    // update the display:
                    $('#banner-' + id).remove();
                    // if that was the last banner, hide the div for the saved banners entirely:
                    if ($('#savedimageslist li').length < 1) {
                        // remove the block with the saved banners until we have some:
                        $('#savedimagesdiv').remove();
                    }
                }
            });
        });
    });

    // DRAG AND DROP TEXT OR IMAGE LAYER TO TRASHCAN:
    $( ".draggable" ).draggable();
    $( "#trashcandiv" ).droppable({
        over: function(event, ui) {

            $(this).css('opacity', 0.8);
            
        },
        drop: function(event, ui) {

            var draggableId = ui.draggable.attr("id"); // get id of the item being dropped in the trash
            var droppableId = $(this).attr("id"); // get id of the trashcan (trashcandiv)

            $(this).css({'opacity' : 1.0, 'cursor' : 'pointer'});

            //alert('dropped ' + draggableId);
            $('#' + draggableId).remove();
            // ui.draggable.remove();  // works this way too

        }
    });

    // SUPPORTING FUNCTIONS:

    // GET CONTRASTING TEXT COLOR FOR BACKGROUNDS:
    function idealTextColor(bgColor) {

        var nThreshold = 105;
        var components = getRGBComponents(bgColor);
        var bgDelta = (components.R * 0.299) + (components.G * 0.587) + (components.B * 0.114);

        return ((255 - bgDelta) < nThreshold) ? "#000000" : "#ffffff";
    }

    function getRGBComponents(color) {

        var r = color.substring(1, 3);
        var g = color.substring(3, 5);
        var b = color.substring(5, 7);

        return {
            R: parseInt(r, 16),
            G: parseInt(g, 16),
            B: parseInt(b, 16)
        };
    }

     // COLORS
    var colorNames = [
        "Black", "White", "Radical Red", "Wild Watermelon", "Outrageous Orange", "Atomic Tangerine", "Neon Carrot", "Sunglow",
        "Laser Lemon", "Unmellow Yellow", "Electric Lime", "Screamin' Green", "Magic Mint", "Blizzard Blue", "Shocking Pink",
        "Razzle Dazzle Rose", "Hot Magenta", "Purple Pizzazz", "Red", "Maroon", "Scarlet", "Brick Red", "English Vermilion",
        "Madder Lake", "Permanent Geranium Lake", "Maximum Red", "Indian Red", "Orange-Red", "Sunset Orange", "Bittersweet",
        "Dark Venetian Red", "Venetian Red", "Light Venetian Red", "Vivid Tangerine", "Middle Red", "Burnt Orange", "Red-Orange",
        "Orange", "Macaroni and Cheese", "Middle Yellow Red", "Mango Tango", "Yellow-Orange", "Maximum Yellow Red", "Banana Mania",
        "Maize", "Orange-Yellow", "Goldenrod", "Dandelion", "Yellow", "Green-Yellow", "Middle Yellow", "Olive Green", "Spring Green",
        "Maximum Yellow", "Canary", "Lemon Yellow", "Maximum Green Yellow", "Middle Green Yellow", "Inchworm", "Light Chrome Green",
        "Yellow-Green", "Maximum Green", "Asparagus", "Granny Smith Apple", "Fern", "Middle Green", "Green", "Medium Chrome Green",
        "Forest Green", "Sea Green", "Shamrock", "Mountain Meadow", "Jungle Green", "Caribbean Green", "Tropical Rain Forest",
        "Middle Blue Green", "Pine Green", "Maximum Blue Green", "Robin's Egg Blue", "Teal Blue", "Light Blue", "Aquamarine",
        "Turquoise Blue", "Outer Space", "Sky Blue", "Middle Blue", "Blue-Green", "Pacific Blue", "Cerulean", "Maximum Blue",
        "Blue (I)", "Cerulean Blue", "Cornflower", "Green-Blue", "Midnight Blue", "Navy Blue", "Denim", "Blue (III)",
        "Cadet Blue", "Periwinkle", "Blue (II)", "Wild Blue Yonder", "Indigo", "Manatee", "Cobalt Blue", "Celestial Blue",
        "Blue Bell", "Maximum Blue Purple", "Violet-Blue", "Blue-Violet", "Ultramarine Blue", "Middle Blue Purple", "Purple Heart",
        "Royal Purple", "Violet (II)", "Medium Violet", "Wisteria", "Lavender (I)", "Vivid Violet", "Maximum Purple",
        "Purple Mountains' Majesty", "Fuchsia", "Pink Flamingo", "Violet (I)", "Brilliant Rose", "Orchid", "Plum", "Medium Rose",
        "Thistle", "Mulberry", "Red-Violet", "Middle Purple", "Maximum Red Purple", "Jazzberry Jam", "Eggplant", "Magenta",
        "Cerise", "Wild Strawberry", "Lavender (II)", "Cotton Candy", "Carnation Pink", "Violet-Red", "Razzmatazz", "Pig Pink",
        "Carmine", "Blush", "Tickle Me Pink", "Mauvelous", "Salmon", "Middle Red Purple", "Mahogany", "Melon", "Pink Sherbert",
        "Burnt Sienna", "Brown", "Sepia", "Fuzzy Wuzzy", "Beaver", "Tumbleweed", "Raw Sienna", "Van Dyke Brown", "Tan",
        "Desert Sand", "Peach", "Burnt Umber", "Apricot", "Almond", "Raw Umber", "Shadow", "Raw Sienna (I)", "Timberwolf", "Gold (I)",
        "Gold (II)", "Silver", "Copper", "Antique Brass", "Charcoal Gray", "Gray", "Blue-Gray", "Sizzling Red",
        "Red Salsa", "Tart Orange", "Orange Soda", "Bright Yellow", "Yellow Sunshine", "Slimy Green", "Green Lizard", "Denim Blue",
        "Blue Jeans", "Plump Purple", "Purple Plum", "Sweet Brown", "Brown Sugar", "Eerie Black", "Black Shadows", "Fiery Rose",
        "Sizzling Sunrise", "Heat Wave", "Lemon Glacier", "Spring Frost", "Absolute Zero", "Winter Sky", "Frostbite" ];

    var colorHex = [
        "#000000", "#FFFFFF", "#FF355E", "#FD5B78", "#FF6037", "#FF9966", "#FF9933", "#FFCC33", "#FFFF66", "#FFFF66", "#CCFF00",
        "#66FF66", "#AAF0D1", "#50BFE6", "#FF6EFF", "#EE34D2", "#FF00CC", "#FF00CC", "#ED0A3F", "#C32148", "#FD0E35", "#C62D42",
        "#CC474B", "#CC3336", "#E12C2C", "#D92121", "#B94E48", "#FF5349", "#FE4C40", "#FE6F5E", "#B33B24", "#CC553D", "#E6735C", "#FF9980",
        "#E58E73", "#FF7F49", "#FF681F", "#FF8833", "#FFB97B", "#ECB176", "#E77200", "#FFAE42", "#F2BA49", "#FBE7B2", "#F2C649",
        "#F8D568", "#FCD667", "#FED85D", "#FBE870", "#F1E788", "#FFEB00", "#B5B35C", "#ECEBBD", "#FAFA37", "#FFFF99", "#FFFF9F",
        "#D9E650", "#ACBF60", "#AFE313", "#BEE64B", "#C5E17A", "#5E8C31", "#7BA05B", "#9DE093", "#63B76C", "#4D8C57", "#3AA655",
        "#6CA67C", "#5FA777", "#93DFB8", "#33CC99", "#1AB385", "#29AB87", "#00CC99", "#00755E", "#8DD9CC", "#01786F", "#30BFBF",
        "#00CCCC", "#008080", "#8FD8D8", "#95E0E8", "#6CDAE7", "#2D383A", "#76D7EA", "#7ED4E6", "#0095B7", "#009DC4", "#02A4D3",
        "#47ABCC", "#4997D0", "#339ACC", "#93CCEA", "#2887C8", "#00468C", "#0066CC", "#1560BD", "#0066FF", "#A9B2C3", "#C3CDE6",
        "#4570E6", "#7A89B8", "#4F69C6", "#8D90A1", "#8C90C8", "#7070CC", "#9999CC", "#ACACE6", "#766EC8", "#6456B7", "#3F26BF",
        "#8B72BE", "#652DC1", "#6B3FA0", "#8359A3", "#8F47B3", "#C9A0DC", "#BF8FCC", "#803790", "#733380", "#D6AEDD", "#C154C1",
        "#FC74FD", "#732E6C", "#E667CE", "#E29CD2", "#8E3179", "#D96CBE", "#EBB0D7", "#C8509B", "#BB3385", "#D982B5", "#A63A79",
        "#A50B5E", "#614051", "#F653A6", "#DA3287", "#FF3399", "#FBAED2", "#FFB7D5", "#FFA6C9", "#F7468A", "#E30B5C", "#FDD7E4",
        "#E62E6B", "#DB5079", "#FC80A5", "#F091A9", "#FF91A4", "#A55353", "#CA3435", "#FEBAAD", "#F7A38E", "#E97451", "#AF593E",
        "#9E5B40", "#87421F", "#926F5B", "#DEA681", "#D27D46", "#664228", "#D99A6C", "#EDC9AF", "#FFCBA4", "#805533", "#FDD5B1",
        "#EED9C4", "#665233", "#837050", "#E6BC5C", "#D9D6CF", "#92926E", "#E6BE8A", "#C9C0BB", "#DA8A67", "#C88A65",
        "#736A62", "#8B8680", "#C8C8CD", "#FF3855", "#FD3A4A", "#FB4D46", "#FA5B3D", "#FFAA1D", "#FFF700", "#299617", "#A7F432",
        "#2243B6", "#5DADEC", "#5946B2", "#9C51B6", "#A83731", "#AF6E4D", "#1B1B1B", "#BFAFB2", "#FF5470", "#FFDB00", "#FF7A00",
        "#FDFF00", "#87FF2A", "#0048BA", "#FF007C", "#E936A7" ];

    var colors = '';
    colorNames.forEach(function(color, id) {
        var hex = colorHex[id];
        var textcolor = idealTextColor(hex);
        colors += '<option value="' + hex + '" style="background-color: ' + hex + '; color: ' + textcolor + '">' + color + ': ' + hex + '</option>';
    });

    document.getElementById('pickbgcolor').innerHTML = '<option value="transparent" selected="selected">None</option>' + colors;
    document.getElementById('pickbordercolor').innerHTML = '<option value="transparent" selected="selected">None</option>' + colors;
    document.getElementById('picktextcolor').innerHTML = '<option disabled selected="selected">Select</option>' + colors;

});
