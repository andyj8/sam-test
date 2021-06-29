<?php declare(strict_types=1);

namespace App\Command;

use App\Input\Reader;
use App\Metric\Parse\Parser;
use App\Report\Writer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AppAnalyseMetricsCommand
 *
 * @package App\Command
 */
class AppAnalyseMetricsCommand extends Command
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Writer
     */
    private $writer;

    /**
     * @var string
     */
    protected static $defaultName = 'app:analyse-metrics';

    /**
     * @param Reader $reader
     * @param Parser $parser
     * @param Writer $writer
     */
    public function __construct(Reader $reader, Parser $parser, Writer $writer)
    {
        parent::__construct();

        $this->reader = $reader;
        $this->parser = $parser;
        $this->writer = $writer;
    }

    /**
     * Configure the command.
     */
    protected function configure(): void
    {
        $this->setDescription('Analyses the metrics to generate a report.');
        $this->addOption('input', null, InputOption::VALUE_REQUIRED, 'The location of the test input');
    }

    /**
     * Detect slow-downs in the data and output them to stdout.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->reader->read(['path' => $input->getOption('input')]);

        $this->writer->init('SamKnows Metric Analyser v1.0.0');

        $metricSet = $this->parser->parse($data);
        $this->writer->addAttributes('Period checked', [
            'From' => $metricSet->period()->start->format('Y-m-d'),
            'To'   => $metricSet->period()->end->format('Y-m-d'),
        ]);

        $stats = $metricSet->stats();
        $this->writer->addAttributes('Statistics', [
            'Unit'    => 'Megabits per second',
            'Average' => $stats->average()->asMegabits(),
            'Min'     => $stats->min()->asMegabits(),
            'Max'     => $stats->max()->asMegabits(),
            'Median'  => $stats->median()->asMegabits()
        ]);

        $underPerforming = $metricSet->underPerformingPeriods(12000000);
        if (!empty($underPerforming)) {
            $periods = [];
            foreach ($underPerforming as $period) {
                $periods[] = $period->asUnderPerformingMessage();
            }
            $this->writer->addBulletPoints('Investigate', $periods);
        }

        $output->write($this->writer->render());
    }
}
