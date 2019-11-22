<?php
include 'config.php';
session_destroy();
header('Location: ../pages/home.php');