'use strict';

// MAIN EXECUTION POINT
$(deobfuscate);

/** Class names for spans in HTML. */
const mailClasses = {
	mainClass: 'obfuscation-email',
	localClass: 'local',
	domainClass: 'domain',
	displayClass: 'display',
	urlParams: ['subject', 'body']
};

/** Class names for spans in HTML. */
const phoneClasses = {
	mainClass: 'obfuscation-phone',
	phone: 'phone',
	displayClass: 'display'
};

/**
 * Deobfuscate all emails and phone numbers.
 * 
 * @return {void}
 */
function deobfuscate() {
	let spans = $('span');
	let mailSpans = spans.filter('.' + mailClasses.mainClass);
	let phoneSpans = spans.filter('.' + phoneClasses.mainClass);

	mailSpans.each(function (_, span) {
		// Get values.
		let local = getText(span, mailClasses.localClass);
		let domain = getText(span, mailClasses.domainClass);
		let display = getText(span, mailClasses.displayClass);
		// Prepare parameter values.
		let params = [];
		for (const element of mailClasses.urlParams) {
			let paramSpanValue = getText(span, element);
			if (paramSpanValue !== '') {
				params.push(element + '=' + encodeURIComponent(paramSpanValue));
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

	phoneSpans.each(function (_, span) {
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
}

/**
 * Given a span with mainClass as the scope, return the text in the sub-span with searchClass.
 * 
 * @param {Document | HTMLElement} scope
 * @param {string} searchClass
 * @return {string} Text in inner span.
 */
function getText(scope, searchClass) {
	return $(scope).find('.' + searchClass).first().text();
}

/**
 * Remove obfuscation from a domain address.
 * @example 'example [dot] com' -> 'example.com'
 * 
 * @param {string} domain
 * @return {string} Clean domain.
 */
function cleanDomain(domain) {
	// Replace all instances of '[dot]' with '.'.
	domain = domain.replace('[dot]', '.');
	// Remove all whitespace.
	domain = domain.replace(/\s+/g, '');
	return domain;
}

/**
 * Remove obfuscation from a phone number.
 * Output is ideally equal to what the user originally entered.
 * It is not the case, if the user entered two consecutive special chars,
 * which is prohibited by the form.
 * 
 * @param {string} phone
 * @return {string} Clean phone.
 */
function cleanPhone(phone) {
	phone = phone.replaceAll('--', '');
	phone = phone.replaceAll('//', '');
	phone = phone.replaceAll('\\\\', '');
	phone = phone.replaceAll('..', '');
	// Collapse multiple whitespace to a single space.
	phone = phone.replace(/\s+/g, '\xA0');
	phone = phone.trim();
	return phone;
}

/**
 * Make an obfuscated phone number machine readable.
 * Keep only digits and optionally a leading '+'.
 * 
 * @param {string} phone
 * @return {string} Machine readable phone number.
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
