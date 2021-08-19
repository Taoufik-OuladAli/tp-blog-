<?php

function afficheMessage(){
    echo '<div class="message">';
    echo $_SESSION['message'];
    echo '</div>';
    unset($_SESSION['message']);
}