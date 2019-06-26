<?php


namespace FelixRupp\iCalNotificationGenerator\Generator;

/**
 * Interface GeneratorInterface
 * @package FelixRupp\iCalNotificationGenerator\Generator
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @copyright Felix Rupp
 */
interface GeneratorInterface
{

    public function generate($fileName);
}