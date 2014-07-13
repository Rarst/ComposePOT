<?php

namespace Rarst\ComposePOT\Command;

use Rarst\ComposePOT\AddTextdomain;
use Cilex\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\FormatterHelper;

/**
 * Console command to add text domain to translation calls in source.
 */
class Add_Domain extends Command {

	protected function configure() {
		$this
			->setName( 'add:domain' )
			->setDescription( 'Add text domain to translation calls in source' )
			->addArgument( 'domain', InputArgument::REQUIRED, 'Text domain' )
			->addArgument( 'file', InputArgument::REQUIRED, 'Target file' )
			->addOption( 'inplace', 'i', InputOption::VALUE_NONE, 'Add to existing file in place.' );
	}

	/**
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 *
	 * @return int execution result code
	 */
	protected function execute( InputInterface $input, OutputInterface $output ) {

		/** @var AddTextdomain $add_textdomain */
		$add_textdomain = $this->getService( 'add_textdomain' );

		// TODO input validation

		$add_textdomain->process_file(
			$input->getArgument( 'domain' ),
			$input->getArgument( 'file' ),
			$input->getOption( 'inplace' )
		);

		return 0;
	}
} 