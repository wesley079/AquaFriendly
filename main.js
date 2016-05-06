//global vars
var menuOptions = ["climate", "color", "TEMP"];
var loaded = false;
var foodAmount = 10;
var rgb;

//initialize plugin
$(init);

/**
 * Initializing the pluggin
 *
 * Handlers for the interface
 *
 * Functions for loading content
 */
function init() {


    //load dashboard
    if (loaded == false) {
        var item = "dashboard";
        size(item);
    }
    //loading UI jquery elements
    loadJqueryUI();

    //change logo
    $("#logo").on("mouseover", move);

    if (loaded == true) {
        //change menu items

    }

    //save submits
    $("#climateSubmit").on("click", climateChange);
    $("#tempSubmit").on("click", tempChange);
    $("#colorSubmit").on("click", colorChange);
}

/**
 * Loading all jquery UI data
 *
 */
function loadJqueryUI() {
    $.ajax({
        url: "food.php",
        data: "",
        dataType: 'json',
        success: function (data) {
            foodAmount = data[0];

            var foodAmount = data[0];
            $("#foodAmount").progressbar({
                value: parseInt(foodAmount)
            }).addClass("foodBar");
        }
    });

    //color picker
    $('.demo').each( function() {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time. Again,
        // they're only used for the purposes of this demo.
        //
        $(this).minicolors({
            control: $(this).attr('data-control') || 'hue',
            defaultValue: $(this).attr('data-defaultValue') || '',
            format: $(this).attr('data-format') || 'hex',
            keywords: $(this).attr('data-keywords') || '',
            inline: $(this).attr('data-inline') === 'true',
            letterCase: $(this).attr('data-letterCase') || 'lowercase',
            opacity: $(this).attr('data-opacity'),
            position: $(this).attr('data-position') || 'bottom left',
            change: function(hex, opacity) {
                var log;
                try {
                    log = hex ? hex : 'transparent';
                    if( opacity ) log += ', ' + opacity;
                    rgb = log;

                } catch(e) {}
            },
            theme: 'default'
        });

    });

}

/**
 * All movement will happen here
 */
function move() {
    if (this.id == "logo") {
        //move logo
        $("#logo").animate({top: "15%", marginTop: "-100px"}, 500, size);
    }
}

/**
 * Resizing all elements will happen here
 */
function size(item) {
    //If logo is mousover
    if (this.id == "logo" && this.alt == "logo of aquafriendly") {
        $('#logo').unbind("mouseover");
        $("#logo").animate({width: "200px", marginLeft: "-100px"}, 500, loadMenu);
        $('#logo').unbind("mouseover");
    }

    //If menu is mouseOut
    if ($.inArray(this.id, menuOptions) >= 0) {
        $.each(menuOptions, function (index, value) {
            $("#" + value).css('width', '220px');
        });
    }
    //animate dashboard when site loads
    if (item == "dashboard") {
        $("#dashboard").animate({
            width: "15%"
        }, 1000);
    }
}

/**
 * Popup all the menuElements
 */
function loadMenu() {

    $.each(menuOptions, function (index, value) {
            $("#" + value).delay(600 * index).fadeIn(400);
        }
    );

    //init();

    if (!loaded) {
        $.each(menuOptions, function (index, value) {
            $("#" + value).on("mouseover", menuHover);
        });


        //change back menu size
        $.each(menuOptions, function (index, value) {
            $("#" + value).on("mouseout", size);
        });

        //select menu item
        $.each(menuOptions, function (index, value) {
            $("#" + value).on("click", loadPage);
        });
        $("#home").on("click", home);
    }
    loaded = true;


}

/**
 *  Make the hovered element bigger and the rest of the elements smaller
 */
function menuHover() {
    //save id in variable to check later
    var id = this.id;

    $.each(menuOptions, function (index, value) {
        //make icon bigger
        if (value == id) {
            $("#" + value).css('width', '260px');
        }

        //make other icons smaller
        else {
            $("#" + value).css('width', '180px');
        }
    })
}

/**
 * Load the selected page
 */
function loadPage() {

    $.each(menuOptions, function (index, value) {
        $("#" + value).hide()
    });
    var logo = $('#logo');
    logo.hide(800);

    //change all elements
    logo[0].src = this.src;
    logo[0].alt = this.alt;

    logo.animate({
        width: "280px",
        marginLeft: "-140px",
        marginTop: "-140px"
    }).fadeIn(400);

    $("#home").delay(2000).animate({
        width: "100px",
        opacity: "100",
        left: "100px",
        padding: "15px"

    }, 600).fadeIn(500);

    if(this.id == "climate"){

        $("#climateSelection").show();
        $("#climateSelection").delay(2500).animate({
            opacity: "1"
        }, 600);



    }
    if(this.id == "TEMP"){
        $("#tempSelection").show();
        $("#tempSelection").delay(2500).animate({
            opacity: "1"
        }, 600);

        $("#manualButton").on("click", function(){
            $("#manual").show();

        });

        $("#automaticButton").on("click", function(){
            $("#manual").hide();
        });

        $("#tempUp").on("click", function(){
            $temp = $("#temp").html();
            $temp++;
            $("#temp").html($temp);
        });
        $("#tempDown").on("click", function(){
            $temp = $("#temp").html();

            $temp--;
            $("#temp").html($temp);
        })
    }

    if(this.id == "color"){
        $("#colorSelection").show();
        $("#colorSelection").delay(2500).animate({
            opacity: "1"
        }, 600);

        $("#manualButtonColor").on("click", function(){
            $("#manualColor").show();
        });
        $("#automaticButtonColor").on("click", function(){
            $("#manualColor").hide();
        });



    }

}

/**
 * Replace all items back to normal state
 */
function home() {
    //fadeOut everything
    $("#home").hide(800);

    //Changeback logo
    var logo = $('#logo');
    logo.hide(500);
    logo[0].src = "images/logo.png";
    logo[0].alt = "logo of aquafriendly";
    logo.fadeIn(500);
    logo.animate({top: "15%", width: "200px", marginLeft: "-100px", marginTop: "-100px"}, 500, loadMenu);

    //Fadeout all suboption
    $("#climateSelection").hide();
    $("#climateSelection").css( "opacity", "0" );

    $("#colorSelection").hide();
    $("#colorSelection").css( "opacity", "0" );

    $("#tempSelection").hide();
    $("#tempSelection").css( "opacity", "0" );

}

/**
 * Get selected climate
 */
function climateChange(){
    var result = $("input:radio[name='climate']:checked").val();


    //save with ajax
    $.ajax({
        url: "climate.php?chosen="+result,
        success: function () {
            $("#climateDashboard").text(result);
        }
    });
}

function tempChange(){
    var result = $("input:radio[name='temp']:checked").val();

    if(result == "Manual"){
        var temp = $("#temp").html();

        //save with ajax
        $.ajax({
            url: "temp.php?chosen="+result+"&manual="+temp,
            success: function () {
                $("#aimedTemp").text(temp+"°");

            }
        });
    }
    else{
        //save with ajax
        $.ajax({
            url: "temp.php?chosen="+result,
            success: function () {

            }
        });
    }


}

function colorChange(){
    var result = $("input:radio[name='color']:checked").val();

    if(result == "Manual") {
        var rgb = $("#rgb").val();
        var rgbcode = rgb.replace("rgb(", "").split(',');
        rgbcode[2].replace("(", "");
        var r = rgbcode[0];
        var g = rgbcode[1];
        var b = rgbcode[2];

        //save with ajax
        $.ajax({
            url: "rgb.php?chosen="+result+"&r="+r+"&g="+g+"&b="+b,
            success: function () {

            }
        });
    }
    else{
//save with ajax
        $.ajax({
            url: "rgb.php?chosen="+result,
            success: function () {

            }
        });
    }

}