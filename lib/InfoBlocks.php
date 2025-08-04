<?php

namespace Mderrdx\Infoblocks;

use \Bitrix\Main\Loader;
use CIBlock;

Loader::includeModule('iblock');

class InfoBlocks
{
    public function getList()
    {
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