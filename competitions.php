<?php
$servername = "localhost";
$username = "root";
$password = "";

function getFixture($fixture_date) {
    try {
        $matches = [];
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=oaktown_fc", $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->query("SELECT fixture.Match_ID, team_home.name AS home_team_name, team_away.name AS away_team_name, fixture.Date, fixture.Home_team_goals, fixture.Away_team_goals FROM fixture INNER JOIN team AS team_home ON fixture.Home_team = team_home.ID INNER JOIN team AS team_away ON fixture.Away_team = team_away.ID WHERE fixture.Fixture_date = " . $fixture_date);

        while($result = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($matches, $result);
        }

    }
    catch(PDOException $e) {
        echo "An error occurred: " . $e->getMessage();
    }

    $conn = null;
    return $matches;
}

if (isset($_GET['fixture_date'])){
    $get_fixture_date = $_GET['fixture_date'];
}else{
    $get_fixture_date = 1;
}

$result_matches = getFixture($get_fixture_date);

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset="utf-8">
	<title>Competitions | Oaktown Football Club</title>
</head>
<body>
	<div id="wrapper">
		<header>
			<a href="index.html"><img src="images/logo.png" alt="logo of oaktown football club"/></a>
			<h2>Oaktown Football Club</h2>
		</header>
		<nav>
			<ul>
				<li><a href="index.html">Home</a></li>
				<li><a href="competitions.php">Competitions</a></li>
				<li><a href="contact.html">Contact</a></li>
				<li><a href="login.php">Login</a></li>
			</ul>
		</nav>
		<div id="content">
            <p class="content_description">Choose a Fixture Date to be displayed below</p>
            <div id="fixture">
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=1">1</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=2">2</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=3">3</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=4">4</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=5">5</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=6">6</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=7">7</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=8">8</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=9">9</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=10">10</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=11">11</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=12">12</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=13">13</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=14">14</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=15">15</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=16">16</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=17">17</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=18">18</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=19">19</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=20">20</a>
                </div>
                <div class="fixture_date">
                    <a href="competitions.php?fixture_date=21">21</a>
                </div>
            </div>
			<h1>Competitions</h1>
			<p>This week’s game scores are:</p>
			<table id="competitions">
				<thead>
                    <tr>
                        <td>Fixture Date</td>
                        <td>Day</td>
                        <td>Home Team</td>
                        <td>Away Team</td>
                        <td>Home Team Score</td>
                        <td>Away Team Score</td>
                    </tr>
                </thead>
                <tbody>
                <?php for($i=0;$i<count($result_matches);$i++){ ?>
                    <?php $match = $result_matches[$i]; ?>
                    <tr>
                        <td><?php echo $get_fixture_date; ?></td>
                        <td><?php echo $match["Date"]; ?></td>
                        <td><?php echo $match["home_team_name"]; ?></td>
                        <td><?php echo $match["away_team_name"]; ?></td>
                        <td><?php echo $match["Home_team_goals"]; ?></td>
                        <td><?php echo $match["Away_team_goals"]; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
			</table>
		</div>
	</div>
</body>
</html>
