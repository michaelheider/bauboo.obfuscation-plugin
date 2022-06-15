<?php

namespace Bauboo\Obfuscation\Components;

use Bauboo\Obfuscation\Models\Settings;
use Cms\Classes\ComponentBase;
use InvalidArgumentException;

class EMail extends ComponentBase
{
	/**
	 * {@inheritdoc}
	 */
	public function componentDetails(): array
	{
		return [
			'name' => 'bauboo.obfuscation::lang.components.email.name',
			'description' => 'bauboo.obfuscation::lang.components.email.description',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function defineProperties(): array
	{
		return [
			'email' => [
				'title' => 'bauboo.obfuscation::lang.components.email.email.title',
				'description' => 'bauboo.obfuscation::lang.components.email.email.description',
				'type' => 'string',
				'validationPattern' => '^[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,64}$',
				'validationMessage' => 'bauboo.obfuscation::lang.components.email.email.validationMessage',
				'default' => 'local@example.com',
				'required' => true,
			],
			'display' => [
				'title' => 'bauboo.obfuscation::lang.components.email.display.title',
				'description' => 'bauboo.obfuscation::lang.components.email.display.description',
				'type' => 'string',
				'default' => '',
			],
			'subject' => [
				'title' => 'bauboo.obfuscation::lang.components.email.subject.title',
				'description' => 'bauboo.obfuscation::lang.components.email.subject.description',
				'type' => 'string',
				'default' => '',
			],
			'body' => [
				'title' => 'bauboo.obfuscation::lang.components.email.body.title',
				'description' => 'bauboo.obfuscation::lang.components.email.body.description',
				'type' => 'string',
				'default' => '',
			],
		];
	}

	/** @var string Local part of email. */
	public $local;
	/** @var string Domain part except TLD of email. */
	public $domain;
	/** @var string TLD part of email. */
	public $tld;
	/** @var bool Whether optional fields are provided. */
	public $hasOptional;
	/** @var string Display text as provided by user. */
	public $display;
	/** @var string Subject as provided by user. */
	public $subject;
	/** @var string Body as provided by user. */
	public $body;

	/**
	 * {@inheritdoc}
	 */
	public function onRun(): void
	{
		if (Settings::get('obfuscation_inject', true)) {
			$this->addJs('assets/js/obfuscation.js');
		}

		$this->display = $this->property('display');
		$this->subject = $this->property('subject');
		$this->body = $this->property('body');
		$this->hasOptional = !(($this->display === '') && ($this->subject === '') && ($this->body === ''));
		$email = $this->property('email');
		$parts = $this->parseEmail($email);
		$this->local = $parts['local'];
		$this->domain = $parts['domain'];
		$this->tld = $parts['tld'];
	}

	/**
	 * @param string $email
	 *
	 * @return array
	 *
	 * @throws InvalidArgumentException if $email is not a valid email string
	 */
	protected function parseEmail($email)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// Should always be OK, since we already check in the input field.
			throw new InvalidArgumentException('E-Mail address provided is not valid.');
		}
		$at = strrpos($email, '@');
		$dot = strrpos($email, '.');
		$local = substr($email, 0, $at);
		$domain = substr($email, $at + 1, $dot - $at - 1);
		$tld = substr($email, $dot + 1);

		return ['local' => $local, 'domain' => $domain, 'tld' => $tld];
	}
}
