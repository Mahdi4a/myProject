<?php

namespace Modules\Main\GraphQL;


class GetMutationsFile
{
    public static function GetData()
    {
        $modules = scandir('../Modules');
        unset($modules[0], $modules[1]);

        $array = [];
        foreach ($modules as $module) {
            $items = scandir('../Modules/' . $module . '/GraphQL/Mutations/Admin');
            unset($items[0], $items[1]);
            foreach ($items as $item) {
                $item = str_replace(".php", "", $item);
                $test = "\Modules\\" . $module . "\GraphQL\Mutations\Admin\\" . $item;
                $test1 = new $test();
                $array[] = '\\' . get_class($test1) . '::class';
//                    dd(get_class($test1));
//                    dd($test."::class",new $test());
//                    dd(new \Modules\Category\GraphQL\Mutations\Admin\Create());
//                    $array[] = "\Modules\\".$module . "\GraphQL\Mutations\Admin\\".$item."::class";
//                    $array[] = \Modules\Category\GraphQL\Mutations\Admin\Create::class;
            }
        }
        dd($array);

        return $array;

//        $modules = Module::all();

        $array = [];
//        foreach ($modules as $module) {
//            if(!Module::isDisabled($module->getName())) {
//                $items = scandir($module->getExtraPath('GraphQL/Mutations/Admin'), 0);
//                unset($items[0],$items[1]);
//                foreach ($items as $item) {
//                    $item = str_replace(".php","",$item);
//                    $array[] = "\Modules\\".$module->getName() . "\GraphQL\Mutations\\".$item."::class";
//                }
//            }
//        }
        return $array;
    }
}
