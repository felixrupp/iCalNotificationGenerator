<?php


namespace FelixRupp\iCalNotificationGenerator\Generator;


use Sabre\VObject\Reader;

class iCalNotificationGenerator implements GeneratorInterface
{


    /**
     * @param string $fileName
     * @return string
     * @throws \Sabre\VObject\InvalidDataException
     */
    public function generate($fileName)
    {

        $vcalendar = NULL;

        $vcalendar = Reader::read(
            fopen($fileName, 'r')
        );

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