# Documentation

## General

The plugin features two components, one for email addresses and one for phone numbers.

## Components

Configuration:

- Display Text: If given, display this text instead of the unobfuscated email / phone. Make sure this does not contain your email/phone, as it is not obfuscated!
- E-Mail address / Phone number: Your email / phone in usual format (no obfuscation).

### Mail Component

Additional configuration:

- Subject: Default subject when the link is opened in an email program.
- Body: Default body when the link is opened in an email program.

### Phone Component

The displayed phone number (assuming no display text is provided) is equal to what was entered in the component's config. This means you can use your own phone number format. The phone number in the `href` has all non numeric characters removed, except a leading '+' if present.

## How it Works

The obfuscation is JavaScript based. This means that the HTML code contains only an obfuscated version of the data, but as soon as the document and the script are loaded it is immediately changed into a perfectly normal, human readable format.

### What about Users with JavaScript disabled

The obfuscation is designed so that even without the transformation, the data is still human readable, although slightly obfuscated. Also, it does not feature a link. If you want to see exactly what it looks like you can either temporarily disable injecting of the obfuscation script in the plugin's settings or disable JavaScript in your browser.

### How Good is the Obfuscation

No obfuscation is perfect. Given a good enough bot or one that is tailored to exactly this format, you can still scrape the email addresses or phone numbers. However, it already requires more effort. Furthermore, spammers could also execute the JavaScript before searching email addresses, but this incurs a higher load on the spammers' systems.
