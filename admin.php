<?php
session_start();
if (!isset($_SESSION['Name'])) { //does session variable name exist?
    header("location: login.php"); // if not redirect user to login.php web page
}

$servername = "localhost";
$username = "root";
$password = "";

$team_message = "";
$team_id = "";
$team_name = "";
$team_image = "";

$match_message = "";
$match_id = "";
$match_fixture_date = "";
$match_day = "";
$match_home_team = "";
$match_away_team = "";
$match_home_team_score = "";
$match_away_team_score = "";


if (isset($_POST["team_get"])) {
    getTeam($_POST["team_id"]);
}

function getTeam($teamId)
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->query("SELECT * FROM team WHERE ID=" . $teamId);
        $result = $statement->fetch();
        if ($result == null) {
            $GLOBALS['team_message'] = "The ID is not valid or does not exist";
        } else {
            $GLOBALS['team_id'] = $result[0];
            $GLOBALS['team_name'] = $result[1];
        }
    } catch (PDOException $e) {
        echo "An error occurred: " . $e->getMessage();
    }
    $conn = null;
}


if (isset($_POST["team_insert"])) {
    insertTeam();
}

function insertTeam()
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $tmp_image_name = $_FILES["team_image"]["tmp_name"]; //get image file

        if (!isset($tmp_image_name)) { //file hasn't been selected
            $GLOBALS['team_message'] = "Please select a file to upload";
        } else {
            $check = getimagesize($tmp_image_name);  // check if file is an image type

            if ($check) { // if file is an image
                $image_contents = file_get_contents($tmp_image_name);
                $statement = $conn->prepare("INSERT INTO team (ID, Name, Logo) VALUES (:team_id, :team_name, :team_img)");

                $statement->bindValue(":team_id", $_POST["team_id"]);
                $statement->bindValue(":team_name", $_POST["team_name"]);
                $statement->bindValue(":team_img", $image_contents);

                $result = $statement->execute();
                if ($result) {
                    $GLOBALS['team_message'] = "Team record inserted into table successfully";
                } else {
                    $GLOBALS['team_message'] = "The Team record was not inserted";
                }

            } else {
                $GLOBALS['team_message'] = "The file to be uploaded is not an image";
            }
        }

    } catch (PDOException $e) {
        echo "A problem occurred: " . $e->getMessage();
    }

    $conn = null;
}


if (isset($_POST["team_update"])) {
    updateTeam($_POST["team_id"]);
}

function updateTeam($teamId)
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $tmp_image_name = $_FILES["team_image"]["tmp_name"];

        if (!$tmp_image_name) {
            $GLOBALS['team_message'] = 'Please upload a file for this team';
        } else {

            $is_image = getimagesize($tmp_image_name);

            if (!$is_image) {
                $GLOBALS['team_message'] = 'Please upload a valid image for this team';
            } else {
                $image_content = file_get_contents($tmp_image_name);

                $statement = $conn->prepare("UPDATE team SET Name=:team_name, Logo=:team_img WHERE ID=" . $teamId);

                $statement->bindValue(":team_name", $_POST["team_name"]);
                $statement->bindValue(":team_img", $image_content);

                $result = $statement->execute();

                if ($result) {
                    $GLOBALS['team_message'] = "Team record was updated";
                } else {
                    $GLOBALS['team_message'] = "The Team record was not updated";
                }
            }
        }
    } catch (PDOException $e) {
        echo "A problem occurred " . $e->getMessage();
    }

    $conn = null;
}


if (isset($_POST["team_delete"])) {
    deleteTeam($_POST["team_id"]);
}

function deleteTeam($teamId)
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->prepare("DELETE FROM team WHERE ID=" . $teamId);

        $result = $statement->execute();

        if ($result) {
            $GLOBALS['team_message'] = "Team record was deleted successfully";
        } else {
            $GLOBALS['team_message'] = "The Team record was not deleted";
        }
    } catch (PDOException $e) {
        echo "A problem occurred " . $e->getMessage();
    }

    $conn = null;
}


if (isset($_POST["match_get"])) {
    getMatch($_POST["match_id"]);
}

function getMatch($matchId)
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->query("SELECT * FROM fixture WHERE Match_ID=" . $matchId);
        $result = $statement->fetch();
        if ($result == null) {
            $GLOBALS['match_message'] = "The Match ID is not valid or does not exist";
        } else {
            $GLOBALS['match_id'] = $result[0];
            $GLOBALS['match_home_team'] = $result[1];
            $GLOBALS['match_away_team'] = $result[2]; //fix this. how to store in $image = $_FILES["team_image"]["tmp_name"];
            $GLOBALS['match_fixture_date'] = $result[3];
            $GLOBALS['match_day'] = $result[4];
            $GLOBALS['match_home_team_score'] = $result[5];
            $GLOBALS['match_away_team_score'] = $result[6];
        }
    } catch (PDOException $e) {
        echo "An error occurred: " . $e->getMessage();
    }
    $conn = null;
}


if (isset($_POST["match_insert"])) {
    insertMatch();
}

function insertMatch()
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->prepare("INSERT INTO fixture (Match_ID, Home_team, Away_team, Fixture_date, Date, Home_team_goals, Away_team_goals) VALUES (:match_id, :match_home_team, :match_away_team, :match_fixture_date, :match_date, :match_home_team_goals, :match_away_team_goals)");


        $statement->bindValue(":match_id", $_POST["match_id"]);
        $statement->bindValue(":match_home_team", $_POST["match_home_team"]);
        $statement->bindValue(":match_away_team", $_POST["match_away_team"]);
        $statement->bindValue(":match_fixture_date", $_POST["match_fixture_date"]);
        $statement->bindValue(":match_date", $_POST["match_day"]);
        $statement->bindValue(":match_home_team_goals", $_POST["match_home_team_score"]);
        $statement->bindValue(":match_away_team_goals", $_POST["match_away_team_score"]);

        $result = $statement->execute();
        if ($result) {
            $GLOBALS['match_message'] = "Match record inserted into table successfully";
        } else {
            $GLOBALS['match_message'] = "The Match record was not inserted";
        }
    } catch (PDOException $e) {
        echo "A problem occurred: " . $e->getMessage();
    }

    $conn = null;
}


if (isset($_POST["match_update"])) {
    updateMatch($_POST["match_id"]);
}

function updateMatch($matchId)
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->prepare("UPDATE fixture SET Home_team=:match_home_team, Away_team=:match_away_team, Fixture_date=:match_fixture_date, Date=:match_date, Home_team_goals=:match_home_team_goals, Away_team_goals=:match_away_team_goals WHERE Match_ID=" . $matchId);

        $statement->bindValue(":match_home_team", $_POST["match_home_team"]);
        $statement->bindValue(":match_away_team", $_POST["match_away_team"]);
        $statement->bindValue(":match_fixture_date", $_POST["match_fixture_date"]);
        $statement->bindValue(":match_date", $_POST["match_day"]);
        $statement->bindValue(":match_home_team_goals", $_POST["match_home_team_score"]);
        $statement->bindValue(":match_away_team_goals", $_POST["match_away_team_score"]);

        $result = $statement->execute();

        if ($result) {
            $GLOBALS['match_message'] = "Match record was updated";
        } else {
            $GLOBALS['match_message'] = "The Match record was not updated";
        }
    } catch (PDOException $e) {
        echo "A problem occurred " . $e->getMessage();
    }

    $conn = null;
}


if (isset($_POST["match_delete"])) {
    deleteMatch($_POST["match_id"]);
}

function deleteMatch($matchId)
{
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->prepare("DELETE FROM fixture WHERE Match_ID=" . $matchId);

        $result = $statement->execute();

        if ($result) {
            $GLOBALS['match_message'] = "Match record was deleted successfully";
        } else {
            $GLOBALS['match_message'] = "The Match record was not deleted";
        }
    } catch (PDOException $e) {
        echo "A problem occurred " . $e->getMessage();
    }

    $conn = null;
}

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="utf-8">
    <title>Admin | Oaktown Football Club</title>
</head>
<body>
<div id="wrapper">
    <header>
        <a href="index.html"><img src="images/logo.png" alt="logo of oaktown football club"/></a>
        <h2>Oaktown Football Club</h2>
    </header>
    <nav>
        <ul>
            <?php //Left to mantain de aesthetic of the web page?>
        </ul>
    </nav>
    <div id="content">
        <h1>Admin</h1>
        <div id="form_1">
            <h3>Team Management</h3>
            <form method="post" enctype="multipart/form-data"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="team_form">
                <div class="form_field">
                    <label>ID:</label>
                    <input type="number" min="1" name="team_id" value="<?php echo $team_id; ?>">
                </div>
                <div class="form_field">
                    <label>Team Name:</label>
                    <input type="text" name="team_name" value="<?php echo $team_name; ?>">
                </div>
                <div class="form_field">
                    <label>Team Logo:</label>
                    <input type="file" name="team_image">
                </div>
                <p class="error"><?php echo $team_message; ?></p>
                <input type="submit" name="team_new" value="New" class="button">
                <input type="submit" name="team_insert" value="Insert" class="button">
                <input type="submit" name="team_get" value="Get" class="button">
                <input type="submit" name="team_update" value="Update" class="button">
                <input type="submit" name="team_delete" value="Delete" class="button">
            </form>
        </div>
        <div id="form_2">
            <h3>Fixture Management</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="fixture_form">
                <div class="form_field">
                    <label>Match ID:</label>
                    <input type="number" min="1" name="match_id" value="<?php echo $match_id; ?>">
                </div>
                <div class="form_field">
                    <label>Fixture Date:</label>
                    <input type="number" min="1" name="match_fixture_date" value="<?php echo $match_fixture_date; ?>">
                </div>
                <div class="form_field">
                    <label>Day:</label>
                    <input type="date" name="match_day" value="<?php echo $match_day; ?>">
                </div>
                <div class="form_field">
                    <label>Home Team:</label>
                    <input type="text" name="match_home_team" value="<?php echo $match_home_team; ?>">
                </div>
                <div class="form_field">
                    <label>Away Team:</label>
                    <input type="text" name="match_away_team" value="<?php echo $match_away_team; ?>">
                </div>
                <div class="form_field">
                    <label>Home Team Score:</label>
                    <input type="number" min="0" name="match_home_team_score"
                           value="<?php echo $match_home_team_score; ?>">
                </div>
                <div class="form_field">
                    <label>Away Team Score:</label>
                    <input type="number" min="0" name="match_away_team_score"
                           value="<?php echo $match_away_team_score; ?>">
                </div>
                <p class="error"><?php echo $match_message; ?></p>
                <input type="submit" name="match_new" value="New" class="button">
                <input type="submit" name="match_insert" value="Insert" class="button">
                <input type="submit" name="match_get" value="Get" class="button">
                <input type="submit" name="match_update" value="Update" class="button">
                <input type="submit" name="match_delete" value="Delete" class="button">
            </form>
        </div>
    </div>
</div>
</body>
</html>
