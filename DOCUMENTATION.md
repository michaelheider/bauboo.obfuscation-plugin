# Documentation

## General

The plugin features two components, one for email addresses and one for phone numbers.

## How it Works

The obfuscation is JavaScript based. This means that the HTML code contains only an obfuscated version of the data, but as soon as the document and the script are loaded it is immediately changed into a perfectly normal, human readable format.

### What about Users with JavaScript disabled

The obfuscation is designed so that even without the transfomration, the data is still human readable. But it is less convenient, cannot be copy pasted and does not feature a link. If you want to see exactly what it looks like you can either disable JavaScript in your browser and reload your page, or temporarily disable inject SpamSpan in the plugin's settings.

### How Good is the Obfuscation

No obfuscation is perfect. Given a good enough bot or one that is tailored to exactly this format, you can still scrap the email address or phone number. However, it already requires significantly more effort.

Furthermore, spammers could also execute the JavaScript before searching email addresses, but this is put a significantly higher load on their systems.
