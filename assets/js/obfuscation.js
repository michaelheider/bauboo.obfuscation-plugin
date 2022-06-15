'use strict';

const mailClasses = {
	mainClass: 'obfuscation-email',
	localClass: 'local',
	domainClass: 'domain',
	displayClass: 'display',
	urlParams: ['subject', 'body']
};

const phoneClasses = {
	mainClass: 'obfuscation-phone',
	phone: 'phone',
	displayClass: 'display'
};

$(document).ready(function () {
	let spans = $('span');
	let mailSpans = spans.filter('.' + mailClasses.mainClass);
	let phoneSpans = spans.filter('.' + phoneClasses.mainClass);

	mailSpans.each(function (index, span) {
		// Get values.
		let local = getText(span, mailClasses.localClass);
		let domain = getText(span, mailClasses.domainClass);
		let display = getText(span, mailClasses.displayClass);
		// Prepare parameter values.
		let params = [];
		for (let j = 0; j < mailClasses.urlParams.length; j++) {
			let paramSpanValue = getText(span, mailClasses.urlParams[j]);
			if (paramSpanValue !== '') {
				params.push(mailClasses.urlParams[j] + '=' +
					encodeURIComponent(paramSpanValue));
			}
		}
		// Create clean tag.
		let email = local + '@' + cleanDomain(domain);
		let displayText = display === '' ? email : display;
		let href = 'mailto:' + email;
		if (params.length > 0) {
			href += '?' + params.join('&');
		}
		let cleanTag = $('<a></a>').addClass(mailClasses.mainClass).attr('href', href).text(displayText);
		// Replace the obfuscated span with the clean tag.
		$(span).replaceWith(cleanTag);
	});

	phoneSpans.each(function (index, span) {
		// Get values.
		let obfuscatedPhone = getText(span, phoneClasses.phone);
		let display = getText(span, phoneClasses.displayClass);
		// Create clean tag.
		let humanPhone = cleanPhone(obfuscatedPhone); // hopefully close to what was entered by user
		let displayText = display === '' ? humanPhone : display;
		let href = 'tel:' + machinePhone(obfuscatedPhone); // only digits, optional leading '+'
		let cleanTag = $('<a></a>').addClass(phoneClasses.mainClass).attr('href', href).text(displayText);
		// Replace the obfuscated span with the clean tag.
		$(span).replaceWith(cleanTag);
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
 * Remove obfuscation from a domain address.
 * @example 'example [dot] com' -> 'example.com'
 * 
 * @param {string} domain
 * @return {string}
 */
function cleanDomain(domain) {
	// Replace all instances of '[dot]' with '.'.
	domain = domain.replace(/\[dot\]/g, '.');
	// Remove all whitespace.
	domain = domain.replace(/\s+/g, '');
	return domain;
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
 * Make an obfuscated phone number machine readable.
 * 
 * @param {string} phone
 * @return {string} Keep only digits and optionally a leading '+'.
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
