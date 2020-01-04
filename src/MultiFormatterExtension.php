<?php
/**
 * This file is part of juit/phpspec-multi-formatter.
 * (c) 2019-2020 JUIT GmbH (info@juit.de)
 * (c) 2019-2020 Daniel Kreuer (daniel.kreuer@juit.de)
 */

declare(strict_types=1);

namespace Juit\PhpSpec\Extension\MultiFormatter;

use InvalidArgumentException;
use Juit\PhpSpec\Extension\MultiFormatter\Formatter\MultiFormatter;
use PhpSpec\Config\OptionsConfig;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Console\Prompter;
use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\Formatter as SpecFormatter;
use PhpSpec\Formatter\BasicFormatter;
use PhpSpec\Listener\StatisticsCollector;
use PhpSpec\ServiceContainer;
use PhpSpec\Util\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\StreamOutput;

final class MultiFormatterExtension implements PhpSpecExtension
{
	/**
	 * @var array<array-key, bool>
	 */
	private array $configurableFormatters = [
		'junit' => true,
		'tap' => true,
	];

	/**
	 * @psalm-param array<array-key, mixed> $params
	 */
	public function load(ServiceContainer $container, array $params): void
	{
		/** @psalm-var array{format: string[], output: array<string, string>} $params */
		$formatters = [];

		/** @var string[] $formats */
		$formats = $params['format'] ?? [];
		if (!$formats) {
			$formats[] = (string) $container->getParam('formatter.name');
		}

		foreach ($formats as $format) {
			if (!$container->has("formatter.formatters.{$format}")) {
				throw new InvalidArgumentException(
					sprintf(
						'Formatter "%s" does not exist.',
						$format
					)
				);
			}

			$formatters[] = "formatter.formatters.{$format}";

			if (($params['output'][$format] ?? false) && ($this->configurableFormatters[$format] ?? false)) {
				$this->configureFormatter($container, $format, $params['output'][$format]);
			}
		}

		$container->define(
			'formatter.formatters.multiformatter',
			function (ServiceContainer $container) use ($formatters) {
				return new MultiFormatter(...array_map(function ($value) use ($container): BasicFormatter {
					return $this->getFormatter($container, $value);
				}, $formatters));
			}
		);

		$container->setParam('formatter.name', 'multiformatter');
	}

	private function configureFormatter(ServiceContainer $container, string $format, string $outputFile): void
	{
		$container->define("formatter.formatters.{$format}._io", function (ServiceContainer $container) use ($outputFile): ConsoleIO {
			$fs = new Filesystem();
			if (!$fs->pathExists(dirname($outputFile))) {
				$fs->makeDirectory(dirname($outputFile));
			}
			if (!$fs->isDirectory(dirname($outputFile))) {
				throw new InvalidArgumentException(sprintf(
					'Given output path\'s directory "%s" is no directory.',
					dirname($outputFile)
				));
			}
			$stream = fopen($outputFile, 'wb');

			return new ConsoleIO(
				$this->getConsoleInput($container),
				new StreamOutput($stream),
				new OptionsConfig(
					$this->getContainerParamAsBoolean($container, 'stop_on_failure', false),
					$this->getContainerParamAsBoolean($container, 'code_generation', false),
					$this->getContainerParamAsBoolean($container, 'rerun', true),
					$this->getContainerParamAsBoolean($container, 'fake', false),
					$this->getContainerParamAsBoolean($container, 'bootstrap', false),
					$this->getContainerParamAsBoolean($container, 'verbose', false)
				),
				$this->getConsolePrompter($container)
			);
		});
		switch ($format) {
			case 'junit':
				$container->define("formatter.formatters.{$format}", function (ServiceContainer $container) use ($format): BasicFormatter {
					return new SpecFormatter\JUnitFormatter(
						$this->getFormatterPresenter($container),
						$this->getFormatterIo($container, $format),
						$this->getStatisticsCollector($container)
					);
				});

				break;
			case 'tap':
				$container->define("formatter.formatters.{$format}", function (ServiceContainer $container) use ($format): BasicFormatter {
					return new SpecFormatter\TapFormatter(
						$this->getFormatterPresenter($container),
						$this->getFormatterIo($container, $format),
						$this->getStatisticsCollector($container)
					);
				});

				break;
			default:
				throw new InvalidArgumentException(sprintf(
					'The formatter "%s" cannot be configured.',
					$format
				));
		}
	}

	/**
	 * @psalm-suppress MoreSpecificReturnType
	 * @psalm-suppress LessSpecificReturnStatement
	 */
	private function getFormatter(ServiceContainer $container, string $formatterName): BasicFormatter
	{
		/** @noinspection PhpIncompatibleReturnTypeInspection */
		return $container->get($formatterName);
	}

	/**
	 * @psalm-suppress MoreSpecificReturnType
	 * @psalm-suppress LessSpecificReturnStatement
	 */
	private function getConsoleInput(ServiceContainer $container): InputInterface
	{
		return $container->get('console.input');
	}

	/**
	 * @psalm-suppress MoreSpecificReturnType
	 * @psalm-suppress LessSpecificReturnStatement
	 */
	private function getConsolePrompter(ServiceContainer $container): Prompter
	{
		return $container->get('console.prompter');
	}

	/**
	 * @psalm-suppress MoreSpecificReturnType
	 * @psalm-suppress LessSpecificReturnStatement
	 */
	private function getFormatterPresenter(ServiceContainer $container): SpecFormatter\Presenter\Presenter
	{
		return $container->get('formatter.presenter');
	}

	/**
	 * @psalm-suppress MoreSpecificReturnType
	 * @psalm-suppress LessSpecificReturnStatement
	 */
	private function getFormatterIo(ServiceContainer $container, string $formatterName): ConsoleIO
	{
		return $container->get("formatter.formatters.{$formatterName}._io");
	}

	/**
	 * @psalm-suppress MoreSpecificReturnType
	 * @psalm-suppress LessSpecificReturnStatement
	 */
	private function getStatisticsCollector(ServiceContainer $container): StatisticsCollector
	{
		return $container->get('event_dispatcher.listeners.stats');
	}

	private function getContainerParamAsBoolean(ServiceContainer $container, string $param, bool $default): bool
	{
		return (bool) $container->getParam($param, $default);
	}
}
