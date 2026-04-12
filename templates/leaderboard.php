<?php
$Db = Database::instance();
$scores = $Db->run("SELECT userId, username, score, time, guesses, maxGuesses, minNumber, maxNumber, gamemode
    FROM (
        SELECT 
            s.*,
            u.username,
            ROW_NUMBER() OVER(
                PARTITION BY s.userId 
                ORDER BY s.score DESC, s.time ASC, s.guesses ASC
            ) AS rn
        FROM scores s
        JOIN users u ON u.id = s.userId
        WHERE s.gameWon = 1
    ) AS ranked
    WHERE rn = 1
    ORDER BY score DESC
    LIMIT 10
")->fetchAll();

?>

<div class="bd-example">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Score</th>
                <th scope="col">Time</th>
                <th scope="col">Guesses</th>
                <th scope="col">Between</th>
                <th scope="col">Gamemode</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($scores as $index => $score): ?>
                <tr>
                    <th><?php echo $index + 1; ?></th>
                    <td><?php echo $score->username; ?></td>
                    <td><?php echo $score->score; ?></td>
                    <td><?php echo $score->time; ?></td>
                    <td><?php echo $score->guesses; ?>/<?php echo $score->maxGuesses; ?></td>
                    <td><?php echo $score->minNumber; ?>/<?php echo $score->maxNumber; ?></td>
                    <td><?php echo $score->gamemode; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>