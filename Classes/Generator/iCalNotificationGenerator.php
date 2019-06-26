<?php

namespace FelixRupp\iCalNotificationGenerator\Generator;

use Exception;
use Sabre\VObject\InvalidDataException;
use Sabre\VObject\Reader;

/**
 * Class iCalNotificationGenerator
 * @package FelixRupp\iCalNotificationGenerator\Generator
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @copyright Felix Rupp
 */
class iCalNotificationGenerator implements GeneratorInterface
{

    /**
     * @param string $fileName
     * @return string
     * @throws InvalidDataException
     * @throws Exception
     */
    public function generate($fileName)
    {

        $vcalendar = NULL;

        $vcalendar = Reader::read(
            fopen($fileName, 'r')
        );

        $validationResults = $vcalendar->validate();

        foreach($validationResults as $validationResult) {

            if($validationResult['level'] >= 3) {

                throw new Exception("Your ical file is invalid: ".$validationResult['message']);
            }
        }

        foreach ($vcalendar->VEVENT as $singleEvent) {

            if (!isset($singleEvent->VALARM)) {

                $alarm = $vcalendar->createComponent('VALARM');
                $alarm->add($vcalendar->createProperty('TRIGGER', '-PT6H'));
                $alarm->add($vcalendar->createProperty('DURATION', 'PT15M'));
                $alarm->add($vcalendar->createProperty('ACTION', 'DISPLAY'));
                $alarm->add($vcalendar->createProperty('DESCRIPTION', $singleEvent->{'SUMMARY'}));
                $alarm->add($vcalendar->createProperty('Repeat', '1'));
                $singleEvent->add($alarm);
            }
        }

        return $vcalendar->serialize();
    }
}