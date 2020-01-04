<?php
/**
 * This file is part of juit/phpspec-multi-formatter.
 * (c) 2019-2020 JUIT GmbH (info@juit.de)
 * (c) 2019-2020 Daniel Kreuer (daniel.kreuer@juit.de)
 */

declare(strict_types=1);

namespace Juit\PhpSpec\Extension\MultiFormatter\Formatter;

use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SpecificationEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Formatter\BasicFormatter;

final class MultiFormatter extends BasicFormatter
{
	/**
	 * @var BasicFormatter[]
	 */
	private array $formatters;

	public function __construct(BasicFormatter $formatter, BasicFormatter ...$formatters)
	{
		array_unshift($formatters, $formatter);
		$this->formatters = $formatters;
	}

	public function beforeSuite(SuiteEvent $event): void
	{
		foreach ($this->formatters as $formatter) {
			$formatter->beforeSuite($event);
		}
	}

	public function afterSuite(SuiteEvent $event): void
	{
		foreach ($this->formatters as $formatter) {
			$formatter->afterSuite($event);
		}
	}

	public function beforeExample(ExampleEvent $event): void
	{
		foreach ($this->formatters as $formatter) {
			$formatter->beforeExample($event);
		}
	}

	public function afterExample(ExampleEvent $event): void
	{
		foreach ($this->formatters as $formatter) {
			$formatter->afterExample($event);
		}
	}

	public function beforeSpecification(SpecificationEvent $event): void
	{
		foreach ($this->formatters as $formatter) {
			$formatter->beforeSpecification($event);
		}
	}

	public function afterSpecification(SpecificationEvent $event): void
	{
		foreach ($this->formatters as $formatter) {
			$formatter->afterSpecification($event);
		}
	}
}
