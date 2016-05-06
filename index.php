<?php
require_once("settings.php");

//connect to database - define at "Settings.php"
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

//check connection
if ($mysqli->connect_errno) {
    printf("DB connect failed: %s\n", $mysqli->connect_error);
    exit;
}

//get data
$queryAquarium = "SELECT * FROM aquarium WHERE id= 1";  //id hard-coded - only 1 aquarium
$aquaInfo = $mysqli->query($queryAquarium);
if ($aquaInfo->num_rows > 0) {

    //save aquarium data to
    while ($row = $aquaInfo->fetch_assoc()) {
        $_SESSION["climateNumber"] = $row["climate"];
        $_SESSION["temp"] = $row["temp"];
        $_SESSION["color"] = $row["color"];
        $_SESSION["co2"] = $row["co2"];
        $_SESSION["manual"] = $row["manual"];
        $_SESSION["manual_temp"] = $row["manual_temp"];
        $_SESSION["nitrate"] = $row["nitrate"];
        $_SESSION["ph"] = $row["ph"];
        $_SESSION["food"] = $row["food"];
        $_SESSION["automatic"] = $row["automatic"];
        $_SESSION["colorManual"] = $row["colorManual"];
    }
    //get selected aquarium climate data
    $queryClimate = "SELECT * FROM climate WHERE id=" . $_SESSION['climateNumber'];
    $climateInfo = $mysqli->query($queryClimate);
    while ($row = $climateInfo->fetch_assoc()) {
        $_SESSION["climate"] = $row["name"];
        $_SESSION["aimed_temp"] = $row["aimed_temp"];
        $_SESSION["aimed_color"] = $row["aimed_color"];
    }

} else {
    echo "No matched Aquarium. Contact Aquafriendly for more help.";
    exit;
}

//check Temp for angle of the arrow (up or down)
if ($_SESSION["temp"] < $_SESSION["aimed_temp"]) {
    $_SESSION["arrowSide"] = "arrowUp";
}
if ($_SESSION["temp"] > $_SESSION["aimed_temp"]) {
    $_SESSION["arrowSide"] = "arrowDown";
}


?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8"/>
    <title>AquaFriendly</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>


    <!--    Loading scripts     -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <!-- MiniColors -->
    <script src="jquery-minicolors-master/jquery.minicolors.js"></script>
    <link rel="stylesheet" href="jquery-minicolors-master/jquery.minicolors.css">


    <script src="main.js"></script>

    <!--    End of Loading scripts     -->

    <script>
        $(document).ready(function () {

            $('.demo').each(function () {
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
                    change: function (hex, opacity) {
                        var log;
                        try {
                            log = hex ? hex : 'transparent';
                            if (opacity) log += ', ' + opacity;
                            console.log(log);
                        } catch (e) {
                        }
                    },
                    theme: 'default'
                });

            });

        });
    </script>
</head>
<body>
<div id="backgrounds">
    <div id="red"></div>
    <div id="blue"></div>
</div>

<div id="mainPage">
    <img id="home" src="images/Home2.png" alt="Icon for home"/>
    <img id="logo" src="images/logo.png" alt="logo of aquafriendly"/>
    <div id="menu">
        <img id="climate" src="images/CLIMATE.png" class="menu" alt="Option for climate"/>
        <img id="color" src="images/COLOR.png" class="menu" alt="Option for color"/>
        <img id="TEMP" src="images/TEMP.png" class="menu" alt="Option for Temperature"/>
    </div>

    <div id="dataSelection">
        <div id="climateSelection" class="selection">
            <div class="selectionInformation">
                <p class="textSelect">Select your climate</p>

                <div class="item">
                    <input type="radio" name="climate"
                           value="Tropical" <?php if ($_SESSION["climate"] == "Tropical") { ?> checked <?php } ?>>
                    <label>Tropical</label>
                </div>
                <div class="item">
                    <input type="radio" name="climate"
                           value="Sunny" <?php if ($_SESSION["climate"] == "Sunny") { ?> checked <?php } ?>>
                    <label>Sunny</label>
                </div>
                <div class="item">
                    <input type="radio" name="climate"
                           value="Cloudy" <?php if ($_SESSION["climate"] == "Cloudy") { ?> checked <?php } ?>>
                    <label>Cloudy</label>
                </div>
                <div class="item">
                    <input type="radio" name="climate"
                           value="Rainy" <?php if ($_SESSION["climate"] == "Rainy") { ?> checked <?php } ?>>
                    <label>Rainy</label>
                </div>
                <div class="item">
                    <input type="radio" name="climate" value="Automatic">
                    <label>Automatic</label>
                </div>
                <?php if ($_SESSION["automatic"] == 1) { ?>
                    <p class="infoSelect">Time for the next climate change</p>
                    <p class="timeSelect">13:15</p>

                <?php } ?>
                <input id="climateSubmit" type="submit"/>

            </div>
        </div>
        <div id="tempSelection" class="selection">

            <p class="textSelect">Select your prefered type of temperature selection</p>

            <div class="item">
                <input id="automaticButton" type="radio" name="temp"
                       value="Automatic" <?php if ($_SESSION["manual"] == 0) { ?> checked <?php } ?>>
                <label>Automatic</label>
            </div>
            <div class="item">
                <input id="manualButton" type="radio" name="temp"
                       value="Manual" <?php if ($_SESSION["manual"] == 1) { ?> checked <?php } ?>>
                <label>Manual</label>
            </div>

            <div id="manual" <?php if ($_SESSION["manual"] == 0) { ?> style="display:none;" <?php } ?>>
                <img id="tempUp" class="tempSelect" src="images/arrow.png" alt="temperature up"/>
                <p id="temp"><?= $_SESSION["aimed_temp"] ?></p>
                <img id="tempDown" class="tempSelect" src="images/arrow.png" alt="temperature down"/>
            </div>
            <input id="tempSubmit" type="submit"/>

        </div>
        <div id="colorSelection" class="selection">
            <div class="item">
                <input id="automaticButtonColor" type="radio" name="color"
                       value="Automatic" <?php if ($_SESSION["colorManual"] == 0) { ?> checked <?php } ?>>
                <label>Automatic</label>
            </div>
            <div class="item">
                <input id="manualButtonColor" type="radio" name="color"
                       value="Manual" <?php if ($_SESSION["colorManual"] == 1) { ?> checked <?php } ?>>
                <label>Manual</label>
            </div>
            <div id="manualColor" <?php if ($_SESSION["colorManual"] == 0) { ?> style="display:none;" <?php } ?>>

                <div class="form-group">

                    <input type="text" id="rgb" class="demo" data-format="rgb" value="rgb(33, 147, 58)" style="opacity: 0;">
                </div>
            </div>
            <input id="colorSubmit" type="submit"/>

        </div>
    </div>
</div>

<aside id="dashboard">
    <!--    Header for the dashboard    -->
    <header id="dashboardTitle">
        <h1>My aquarium</h1>
    </header>

    <!--    Data about the aquarium     -->
    <div id="dataLog" class="subDashboard">
        <div id="statusDashboard" class="dataTpe">Status</div>

        <div id="co2" class="subData">
            <p class="dataType"> CO² </p>
            <p class="dataAmount"><?= $_SESSION["co2"] ?>%</p>
            <p class="dataFeedback">Good</p>
        </div>

        <div id="ph" class="subData">
            <p class="dataType"> Ph </p>
            <p class="dataAmount"><?= $_SESSION["ph"] ?></p>
            <p class="dataFeedback">Good </p>
        </div>

        <div id="nitrate" class="subData">
            <p class="dataType"> Nitrate </p>
            <p class="dataAmount"><?= $_SESSION["nitrate"] ?></p>
            <p class="dataFeedback">Good </p>
        </div>
    </div>
    <!--    Temperature data    -->
    <div id="tempLog" class="subDashboard">

        <div id="temperature" class="subData">
            <p class="dataType"> Temperature </p>
            <p class="dataAmount"><?= $_SESSION["temp"] ?>°</p>
            <p id="aimedTemp" class="dataAmountSmall"> (<?php if ($_SESSION["manual"] == 0) {
                    echo $_SESSION["aimed_temp"];
                } else {
                    echo $_SESSION["manual_temp"];
                } ?>°)</p>
            <img class="<?= $_SESSION["arrowSide"] ?>" src="images/arrow-right.png" alt="temperature icon"/>
        </div>
    </div>
    <!--  Current climate  -->
    <div id="climateLog" class="subDashboard">
        <div id="clim" class="subData">
            <p class="dataType"> Current Climate </p>
            <p id="climateDashboard" class="dataAmount"><?= $_SESSION["climate"] ?></p>
        </div>
    </div>

    <!--    The amount of food left (#foodAmount is loaded in main.js)     -->
    <div id="foodLog" class="subDashboard">
        <p id="foodTitle"> Food amount </p>
        <div id="foodAmount" class="<?= $_SESSION["food"] ?>"></div>
        <p id="foodFeedback"> <?php echo number_format($_SESSION["food"] / 8) ?> Days left!</p>
    </div>

</aside>

</body>
</html>