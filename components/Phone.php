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
                'validationPattern' => '^[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,64}$',
                'validationMessage' => 'bauboo.obfuscation::lang.components.phone.phone.validationMessage',
                'default' => 'local@example.com',
                'required' => true,
            ],
            'anchor' => [
                'title' => 'bauboo.obfuscation::lang.components.phone.anchor.title',
                'description' => 'bauboo.obfuscation::lang.components.phone.anchor.description',
                'type' => 'string',
                'default' => '',
            ],
            'subject' => [
                'title' => 'bauboo.obfuscation::lang.components.phone.subject.title',
                'description' => 'bauboo.obfuscation::lang.components.phone.subject.description',
                'type' => 'string',
                'default' => '',
            ],
            'body' => [
                'title' => 'bauboo.obfuscation::lang.components.phone.body.title',
                'description' => 'bauboo.obfuscation::lang.components.phone.body.description',
                'type' => 'string',
                'default' => '',
            ],
        ];
    }

    /** @var string Full phone. */
    public $phone;
    /** @var string Local part of phone. */
    public $local;
    /** @var string Domain part except TLD of phone. */
    public $domain;
    /** @var string TLD part of phone. */
    public $tld;
    /** @var bool Whether optional fields are provided. */
    public $hasOptional;
    /** @var string Anchor as provided by user. */
    public $anchor;
    /** @var string Subject as provided by user. */
    public $subject;
    /** @var string Body as provided by user. */
    public $body;

    /**
     * {@inheritdoc}
     */
    public function onRun(): void
    {
        if (Settings::get('spamspan_inject', true)) {
            $this->addJs('assets/js/spamspan.js');
        }

        $this->anchor = $this->property('anchor');
        $this->subject = $this->property('subject');
        $this->body = $this->property('body');
        $this->hasOptional = !(is_null($this->anchor) && is_null($this->subject) && is_null($this->body));
        $phone = $this->property('phone');
        $parts = $this->parsePhone($phone);
        $this->phone = $phone;
        $this->local = $parts['local'];
        $this->domain = $parts['domain'];
        $this->tld = $parts['tld'];
    }

    /**
     * @param string $phone
     *
     * @return array
     *
     * @throws InvalidArgumentException if $phone is not a valid phone string
     */
    protected function parsePhone($phone)
    {
        if (!filter_var($phone, FILTER_VALIDATE_EMAIL)) {
            // Should always be OK, since we already check in the input field.
            throw new InvalidArgumentException('E-Mail address provided is not valid.');
        }
        $at = strrpos($phone, '@');
        $dot = strrpos($phone, '.');
        $local = substr($phone, 0, $at);
        $domain = substr($phone, $at + 1, $dot - $at - 1);
        $tld = substr($phone, $dot + 1);

        return ['local' => $local, 'domain' => $domain, 'tld' => $tld];
    }
}
