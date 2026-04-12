<?php
$Db = Database::instance();
$scores = $Db->run("SELECT s.*, u.username
    FROM scores s
    JOIN users u ON u.id = s.userId
    WHERE s.userId = :userId
    ORDER BY s.added DESC
", [':userId' => $_SESSION['userId']])->fetchAll();
?>

<h1><?php echo $_SESSION['username'] ?></h1>

<div class="bd-example">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Score</th>
                <th scope="col">Time</th>
                <th scope="col">Guesses</th>
                <th scope="col">Between</th>
                <th scope="col">Gamemode</th>
                <th scope="col">Result</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($scores as $index => $score): ?>
                <tr>
                    <th><?php echo $index + 1; ?></th>
                    <td><?php echo $score->added; ?></td>
                    <td><?php echo $score->score; ?></td>
                    <td><?php echo $score->time; ?></td>
                    <td><?php echo $score->guesses; ?>/<?php echo $score->maxGuesses; ?></td>
                    <td><?php echo $score->minNumber; ?>/<?php echo $score->maxNumber; ?></td>
                    <td><?php echo $score->gamemode; ?></td>
                    <td><?php echo $score->gameWon ? "Won" : "Lost" ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>