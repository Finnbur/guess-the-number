<?php
$Db = Database::instance();
$scores = $Db->run("SELECT * FROM scores ORDER BY guesses ASC LIMIT 10")->fetchAll();

?>

<div class="bd-example">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Time</th>
            <th scope="col">Guesses</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($scores as $index => $score){ 
            $user = $Db->run("SELECT * FROM users WHERE id = ?", [$score->userId])->fetch();
            ?>
            <tr>
                <th scope="row"><?php echo $index + 1; ?></th>
                <td><?php echo $user->username; ?></td>
                <td><?php echo $score->time; ?></td>
                <td><?php echo $score->guesses; ?></td>
            </tr>
        <?php } ?>
    </tbody>

    </table>
</div>