<?php
declare(strict_types=1);

namespace App\Command;
use App\Entity\UserDetails;
use App\Entity\CustomerDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class MoveDataCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:move-data';

    private $_container;

    private const BATCH_SIZE = 20;
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        
        $this->_container = $container;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Copies users data to customer data table.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command performs copy of data from user_details table to customer_details table.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $doctrine = $this->_container->get('doctrine');

        $em = (object)[
            'source' => $doctrine->getManager('source'),
            'destination' =>$doctrine->getManager('destination'),
        ];
        $userDetailsRepository = $em->source->getRepository(UserDetails::class);

        // creates a new progress bar (50 units)
        $progressBar = new ProgressBar($output, $userDetailsRepository->count([]));

        // starts and displays the progress bar
        $progressBar->start();

        $i = 1;
        foreach($userDetailsRepository->iterate() as $row) {
            /** @var UserDetails $userDetails */
            $userDetails = $row[0];

            $customerDetails = new CustomerDetails();
            $customerDetails->setFullname($userDetails->getName() . ' ' . $userDetails->getSurname());
            $customerDetails->setEMail($userDetails->getEmail());
            $customerDetails->setBalance((string)$userDetails->getData());
            $customerDetails->setTotalpurchase((string)$userDetails->getData2());
            $em->destination->persist($customerDetails);

            if (($i++ % self::BATCH_SIZE) === 0) {
                $em->source->clear(); // Detaches all objects from Doctrine!
                $em->destination->flush(); // Executes all deletions.
                $em->destination->clear(); // Detaches all objects from Doctrine!
            }
            $progressBar->advance();
        }
        $em->destination->flush();
        $progressBar->finish();

        return 0;
    }
}