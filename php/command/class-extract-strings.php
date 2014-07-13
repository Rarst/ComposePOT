<?php

namespace Rarst\ComposePOT\Command;

use Cilex\Command\Command;
use Rarst\ComposePOT\MakePOT;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\FormatterHelper;

/**
 * Console command to generate POT files from sources.
 */
class Extract_Strings extends Command {

	protected function configure() {
		$this
			->setName( 'extract:strings' )
			->setDescription( 'Generate POT file from the files in directory' )
			->addArgument( 'project', InputArgument::OPTIONAL, 'Project type', 'generic' )
			->addArgument( 'directory', InputArgument::OPTIONAL, 'Target directory', getcwd() )
			->addArgument( 'output', InputArgument::OPTIONAL, 'Output file' );
	}

	/**
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 *
	 * @return int execution result code
	 */
	protected function execute( InputInterface $input, OutputInterface $output ) {

		/** @var MakePOT $makepot */
		$makepot = $this->getService( 'makepot' );

		/** @var FormatterHelper $formatter */
		$formatter = $this->getHelperSet()->get( 'formatter' );

		$project = $input->getArgument( 'project' );
		$method  = str_replace( '-', '_', $project );

		if ( ! method_exists( $makepot, $method ) ) {
			$error = 'Invalid project type "' . $project . '"';
			$output->writeln( $formatter->formatSection( 'Error', $error, 'error' ) );

			$projects = 'Valid project types are: ' . implode( ', ', $makepot->projects );
			$output->writeln( $formatter->formatSection( 'Info', $projects, 'info' ) );

			return 1;
		}

		// TODO directory exists validation

		$result = call_user_func(
			array( $makepot, $method ),
			$input->getArgument( 'directory' ),
			$input->getArgument( 'output' )
		);

		return (bool) $result;
	}
}
