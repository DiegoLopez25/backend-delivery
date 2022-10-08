<?php
function hashPassword($texto){
    return password_hash($texto,PASSWORD_BCRYPT);
}

function verificarPassword($texto,$hash){
    return password_verify($texto,$hash);
}