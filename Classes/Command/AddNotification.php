<?php


namespace FelixRupp\iCalNotificationGenerator\Command;

use FelixRupp\iCalNotificationGenerator\Generator\GeneratorInterface;
use FelixRupp\iCalNotificationGenerator\Generator\iCalNotificationGenerator;
use Psr\Log\LoggerInterface;
use Sabre\VObject\Component\VAlarm;
use Sabre\VObject\InvalidDataException;
use Sabre\VObject\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class AddNotification extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-notifications';


    /**
     * @var GeneratorInterface
     */
    protected $generator;

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Adds a user_cas user to the database.')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Name to the iCal file'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('file');

        /**
         * @var LoggerInterface $logger
         */
        $logger = new ConsoleLogger($output);

        if (!empty($fileName)) {

            $fileNameExploded = explode(".", $fileName);

            $fileNameWithoutExtension = $fileNameExploded[0];
            $fileNameExtension = $fileNameExploded[1];

            $this->generator = new iCalNotificationGenerator();

            try {

                $result = $this->generator->generate($fileName);

                //echo $result;

                $fileResult = file_put_contents($fileNameWithoutExtension."-with-alarm.".$fileNameExtension, $result);


            } catch (InvalidDataException $e) {

                $logger->fatal("Fatal error: ".$e->getMessage());
            }

        } else {

            $logger->fatal("File " . $fileName . " not found.");
        }
    }
}