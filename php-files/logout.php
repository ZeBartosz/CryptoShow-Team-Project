<?php
session_start();

session_destroy();

header("Location: public_php/index.html");
exit();