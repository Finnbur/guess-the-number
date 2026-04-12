<!-- old guesses list -->
<h3 class="fw-semibold">Guesses</h3>
<div class="list-group list-group-flush">
    <?php if (!empty($_SESSION['guesses'])): ?>
        <?php foreach (array_reverse($_SESSION['guesses']) as $index => $guess): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                <span><strong>Guess <?php echo $index + 1; ?>:</strong> <?php echo htmlspecialchars($guess['guess']); ?></span>
                <span class="badge bg-<?php echo $guess['type']; if($guess['type'] == "warning") { echo " text-dark"; }?> rounded-pill"><?php echo htmlspecialchars($guess['message']) ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-muted small">No guesses done.</div>
    <?php endif; ?>
</div>