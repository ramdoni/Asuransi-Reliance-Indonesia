<?php

function status_income($status) {
    switch($status){
        case 1:
            return "<label class=\"badge text-danger\">Waiting</label>";
        break;
        case 2:
            return "<label class=\"badge text-warning\">Kurang Bayar</label>";
        break;
        case 3:
            return "<label class=\"badge text-success\">Complete</label>";
        break;
        default:
            return "<label class=\"badge text-danger\">Waiting</label>";
        break;
    }
}