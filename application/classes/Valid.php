<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Valid extends Kohana_Valid
{


    public static function not_zero($value) {

        return ((int)$value != 0);
    }
}