<?php

namespace Bauboo\Obfuscation\Components;

use Bauboo\Obfuscation\Models\Settings;
use Cms\Classes\ComponentBase;
use InvalidArgumentException;

class Phone extends ComponentBase
{
	/**
	 * {@inheritdoc}
	 */
	public function componentDetails(): array
	{
		return [
			'name' => 'bauboo.obfuscation::lang.components.phone.name',
			'description' => 'bauboo.obfuscation::lang.components.phone.description',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function defineProperties(): array
	{
		return [
			'phone' => [
				'title' => 'bauboo.obfuscation::lang.components.phone.phone.title',
				'description' => 'bauboo.obfuscation::lang.components.phone.phone.description',
				'type' => 'string',
				// People write phone numbers in weird formats, see
				// https://en.wikipedia.org/wiki/National_conventions_for_writing_telephone_numbers
				// regex: May start with a +, then sequences of digits, single spaces or any single in "/-.()".
				'validationPattern' => '^\+?(\d ?|[\/\-\.\(\)](\d| |$))+$',
				'validationMessage' => 'bauboo.obfuscation::lang.components.phone.phone.validationMessage',
				'default' => '+44 113 496 0000',
				'required' => true,
			],
			'display' => [
				'title' => 'bauboo.obfuscation::lang.components.phone.display.title',
				'description' => 'bauboo.obfuscation::lang.components.phone.display.description',
				'type' => 'string',
				'default' => '',
			],
		];
	}

	/** @var string display as provided by user. */
	public $display;
	/** @var string Part 1 of phone number. */
	public $part1;
	/** @var string Part 2 of phone number. */
	public $part2;
	/** @var string Part 3 of phone number. */
	public $part3;

	/**
	 * {@inheritdoc}
	 */
	public function onRun(): void
	{
		if (Settings::get('obfuscation_inject', true)) {
			$this->addJs('assets/js/obfuscation.js');
		}

		$this->display = $this->property('display');

		$phone = $this->property('phone');
		$len = strlen($phone) / 3;
		$this->part1 = substr($phone, 0, $len);
		$this->part2 = substr($phone, $len, $len);
		$this->part3 = substr($phone, 2 * $len);
	}

	/**
	 * @param string $phone
	 *
	 * @return string Clean phone number. At least one digit, optionally a leading '+' and nothing else.
	 *
	 * @throws InvalidArgumentException If $phone is not a valid phone number.
	 */
	protected function cleanPhone($phone)
	{
		// Remove everything except digits and plus signs.
		$phoneClean = preg_replace("/[^\d\+]/", '', $phone);
		if (0 === preg_match("/\+?\d+/", $phoneClean)) {
			throw new InvalidArgumentException('Phone number provided is not valid.');
		}

		return $phoneClean;
	}
}
