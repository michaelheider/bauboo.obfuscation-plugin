'use strict';

/*
	---------------------------------------------------------------------------
	Version: 1.1.0
	Release date: 2006-05-13
	Last update: 2020-09-09

	Original code by [SpamSpan](www.spamspan.com) (c) 2006.
	Edited 2020 by Bauboo.
	Changes 1.1.0:
	- modernize JS
	- use jQuery
	- remove obscurifications (there is no email address in the JS code)
	- change default class names
	- support for phone number obscurification
	- fully backwards compatible, appart from the changed default class names
	  and the new dependeny on jQuery

	This program is distributed under the terms of the GNU General Public
	Licence version 2, available at http://www.gnu.org/licenses/gpl.txt
	---------------------------------------------------------------------------
*/

/*
	---------------------------------------------------------------------------
	Replacements.

	E-Mail:
	- '[dot]' and similar replaced iwth '.'
	- remove whitespace

	Phone number visual:
	Character that are removed are good for scripted obscurification, e.g. '//'.
	- '[/]' and similar replaced with '/'
	- '[\]' and similar replaced with '\'
	- '[-]' and similar replaced with '-'
	- '/' removed
	- '-' removed
	- '\' removed
	Phone number link:
	- remove everything that is not a digit except leading '+' if present
	---------------------------------------------------------------------------
*/


/*
	---------------------------------------------------------------------------
	Configuration.
	---------------------------------------------------------------------------
*/

const mailClasses = {
	mainClass: 'spamspan-email',
	localClass: 'local',
	domainClass: 'domain',
	anchorClass: 'anchor',
	urlParams: ['subject', 'body']
};

const phoneClasses = {
	mainClass: 'spamspan-phone',
	phone: 'phone',
	anchorClass: 'anchor'
};

/*
	---------------------------------------------------------------------------
	Do not edit past this point unless you know what you are doing.
	---------------------------------------------------------------------------
*/

$(document).ready(function () {
	let spans = $('span');
	let mailSpans = spans.filter('.' + mailClasses.mainClass);
	let phoneSpans = spans.filter('.' + phoneClasses.mainClass);
	mailSpans.each(function (index, span) {
		// Get data.
		let user = getText(span, mailClasses.localClass);
		let domain = getText(span, mailClasses.domainClass);
		let anchorText = getText(span, mailClasses.anchorClass);
		// Prepare parameter data.
		let params = [];
		for (let j = 0; j < mailClasses.urlParams.length; j++) {
			let paramSpanValue = getText(span, mailClasses.urlParams[j]);
			if (paramSpanValue !== '') {
				params.push(mailClasses.urlParams[j] + '=' +
					encodeURIComponent(paramSpanValue));
			}
		}
		// Create new anchor tag.
		let email = cleanMail(user) + '@' + cleanMail(domain);
		let anchorTagText = anchorText === '' ? email : anchorText;
		let href = 'mailto:' + email;
		if (params.length > 0) {
			href += '?' + params.join('&');
		}
		let anchorTag = $('<a></a>').addClass(mailClasses.mainClass).attr('href', href).text(anchorTagText);
		// Replace the obscurified span with the clean one.
		$(span).replaceWith(anchorTag);
	});
	phoneSpans.each(function (index, span) {
		// Get data.
		let obscurePhone = getText(span, phoneClasses.phone);
		let anchorText = getText(span, phoneClasses.anchorClass);
		let humanPhone = cleanPhone(obscurePhone); // hopefully close to what was entered by user
		// Create new anchor tag.
		let anchorTagText = anchorText === '' ? humanPhone : anchorText;
		let href = 'tel:' + machinePhone(obscurePhone); // only digits, optional leading '+'
		let anchorTag = $('<a></a>').addClass(phoneClasses.mainClass).attr('href', href).text(anchorTagText);
		// Replace the obscurified span with the clean one.
		$(span).replaceWith(anchorTag);
	});
});

/**
 * Given a span with mainClass as the scope, return the text in the sub-span with searchClass.
 * 
 * @param {Document | HTMLElement} scope
 * @param {string} searchClass
 * @return {string}
 */
function getText(scope, searchClass) {
	return $(scope).find('.' + searchClass).first().text();
}

/**
 * Remove obfuscation from an email.
 * 
 * @param {string} mail
 * @return {string}
 */
function cleanMail(mail) {
	// Replace letiations of [dot] with '.'.
	mail = mail.replace(/[\[\(\{]?[dD][oO0][tT][\}\)\]]/g, '.');
	// Remove whitespace.
	mail = mail.replace(/\s+/g, '');
	return mail;
}

/**
 * Remove obfuscation from a phone number.
 * Output is ideally equal to what the user originally entered.
 * - '[/]' and similar replaced with '/'
 * - '[\]' and similar replaced with '\'
 * - '[-]' and similar replaced with '-'
 * - '/' removed
 * - '-' removed
 * - '\' removed
 * 
 * @param {string} phone
 * @return {string}
 */
function cleanPhone(phone) {
	// Replace letiations of [/] with '/'.
	phone = phone.replace(/[\[\(\{]?[\/\\][\}\)\]]/g, '/');
	// Replace letiations of [-] with '-'.
	phone = phone.replace(/[\[\(\{]?[-+][\}\)\]]/g, '-');
	// Remove /\-
	phone = phone.replace(/[\/\\-]/g, '');
	// Collapse multiple whitespace to single space.
	phone = phone.replace(/\s+/g, ' ');
	return phone;
}


/**
 * Make a obfuscated phone number machine readable.
 * 
 * @param {string} phone
 * @return {string} Only digits and optionally a leading '+'.
 */
function machinePhone(phone) {
	let leadingPlus = false;
	if (phone.charAt(0) === '+') {
		leadingPlus = true;
	}
	phone = phone.replace(/[^\d]/g, '');
	if (leadingPlus) {
		phone = '+' + phone;
	}
	return phone;
}
