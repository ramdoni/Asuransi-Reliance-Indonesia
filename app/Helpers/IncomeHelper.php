<?php

function status_income($status) {
    switch($status){
        case 1:
            return "<label class=\"badge text-warning\">Save as Draft</label>";
        break;
        case 2:
            return "<label class=\"badge text-success\">Journal</label>";
        break;
    }
}