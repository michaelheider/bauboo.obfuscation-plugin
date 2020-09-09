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
				'validationPattern' => '^\+?[\d \(\)-]+$', // very loose regex, but people write phone numbers in weird formats
				'validationMessage' => 'bauboo.obfuscation::lang.components.phone.phone.validationMessage',
				'default' => '+12 123 123 4567',
				'required' => true,
			],
			'anchor' => [
				'title' => 'bauboo.obfuscation::lang.components.phone.anchor.title',
				'description' => 'bauboo.obfuscation::lang.components.phone.anchor.description',
				'type' => 'string',
				'default' => '',
			],
		];
	}

	/** @var string Anchor as provided by user. */
	public $anchor;
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
		if (Settings::get('spamspan_inject', true)) {
			$this->addJs('assets/js/spamspan.js');
		}

		$this->anchor = $this->property('anchor');

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
