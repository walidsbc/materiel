<?php
/**
 * Created by PhpStorm.
 * User: Naima-PC
 * Date: 14/12/2016
 * Time: 16:49
 */

namespace SBCPlatformBundle\Entity;


class MyDate extends \DateTime
{
    function __toString()
    {
        return self::format('d.m.Y');
    }

    /**
     * @param $string
     * @return MyDate
     */
    public static function stringToDate($string){
        return self::createFromFormat('d.m.Y', $string);
    }
}