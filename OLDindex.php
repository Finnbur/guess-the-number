<?php
require_once 'inc/functions.php';
init();

// Handle any incoming form submissions
handleRequest();

// Debug: show all session data
dump($_SESSION);

head();

// Check if the game has started
if(!gameStarted())
{
    // Game hasn't started yet - show the start form
    startForm();
}
else
{
    // Game is in progress - show the game form
    gameForm();
}

?>