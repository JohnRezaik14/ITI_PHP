<?php
class CountVisitors
{
    public static function getCount($config)
    {
        $visitor   = new Visitor();
        $counter   = new Counter($config['paths']['VisitorCount']);
        $lastCount = $counter->count($visitor->has_visted_before(), $config['paths']['VisitorCount']);
        return $lastCount;
    }
}
