<?php

namespace Mderrdx\Infoblocks;

use \Bitrix\Main\Loader;
use CIBlock;

Loader::includeModule('iblock');

class IBlockContainer
{
    private static $mapClass = [];

    public static function setClassIBlock($iblockCode, $className)
    {
        $iblockId = 0;
        if (empty(self::$mapClass[$iblockCode]) || !isset(self::$mapClass[$iblockCode]['iblock'])) {
            $iblockId = self::getByCode($iblockCode)->id();
        }
        self::$mapClass[$iblockCode]['iblock'] = $className;
        self::$mapClass[$iblockId]['iblock'] = $className;
        return self::class;
    }

    public static function getClassSection($iblock)
    {
        return self::$mapClass[$iblock]['section'];
    }

    public static function setClassSection($iblockCode, $className)
    {
        $iblockId = 0;
        if (empty(self::$mapClass[$iblockCode]) || !isset(self::$mapClass[$iblockCode]['section'])) {
            $iblockId = self::getByCode($iblockCode)->id();
        }
        self::$mapClass[$iblockCode]['section'] = $className;
        self::$mapClass[$iblockId]['section'] = $className;
        return self::class;
    }

    public static function getClassElement($iblock)
    {
        return self::$mapClass[$iblock]['element'];
    }

    public static function setClassElement($iblockCode, $className)
    {
        $iblockId = 0;
        if (empty(self::$mapClass[$iblockCode]) || !isset(self::$mapClass[$iblockCode]['element'])) {
            $iblockId = self::getByCode($iblockCode)->id();
        }
        self::$mapClass[$iblockCode]['element'] = $className;
        self::$mapClass[$iblockId]['element'] = $className;
        return self::class;
    }

    public static function getList()
    {
        // echo '<pre>';
        // var_dump(self::$mapClass);
        // echo '</pre>';
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

        while($iblockData = $res->fetch())
        {
            $className = ($className === '' ? self::getClassIBlock($iblockData['ID']) : '');
            return $className ? new $className($iblockData) : new IBlock($iblockData);
        }
    }

    public static function getByCode($code, $className = '')
    {
        $res = CIBlock::GetList([],['CODE' => $code]);
        while($iblockData = $res->fetch())
        {
            $className = ($className === '' ? self::getClassIBlock($iblockData['ID']) : '');
            return $className ? new $className($iblockData) : new IBlock($iblockData);
        }
    }

    public static function getClassIBlock($id)
    {
        return self::$mapClass[$id]['iblock'];
    }
}