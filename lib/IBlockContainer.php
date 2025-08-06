<?php

namespace Mderrdx\Infoblocks;

use \Bitrix\Main\Loader;
use CIBlock;

Loader::includeModule('iblock');

class IBlockContainer
{
    private static $mapClass = [];

    public static function setClassIBlock($iblock, $className)
    {
        self::$mapClass[$iblock]['iblock'] = $className;
        return self::class;
    }

    public static function getClassSection($id)
    {
        self::$mapClass[$id]['section'];
    }

    public static function setClassSection($iblock, $className)
    {
        self::$mapClass[$iblock]['section'] = $className;
        return self::class;
    }

    public static function setClassElement($iblock, $className)
    {
        self::$mapClass[$iblock]['element'] = $className;
        return self::class;
    }

    public static function getList()
    {
        echo '<pre>';
        var_dump(self::$mapClass);
        echo '</pre>';
        $res = CIBlock::GetList([],[]);
        $iblocks = [];

        while($iblockData = $res->fetch())
        {
            // $iblocks[$iblockData['CODE']] = $iblockData['ID'];
            // echo '<pre>';
            // var_dump($iblocks);
            // echo '</pre>';
        }
    }

    public static function getById($id, $className = '')
    {
        $res = CIBlock::GetList([],['ID' => $id]);
        $iblocks = [];

        while($iblockData = $res->fetch())
        {
            return $className ? new $className($iblockData) : new IBlock($iblockData);
        }
    }

    public static function getByCode($code, $className = '')
    {
        $res = CIBlock::GetList([],['CODE' => $code]);
        $iblocks = [];

        while($iblockData = $res->fetch())
        {
            return $className ? new $className($iblockData) : new IBlock($iblockData);
        }
    }
}