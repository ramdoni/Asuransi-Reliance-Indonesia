<?php

function status_expense($status) {
    switch($status){
        case 1:
            return "<label class=\"badge text-warning\">Save as Draft</label>";
        break;
        case 2:
            return "<label class=\"badge text-success\">Journal</label>";
        break;
        default:
            return "<label class=\"badge text-danger\">Save as Draft</label>";
        break;
    }
}