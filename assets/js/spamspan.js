'use strict';

/*
	---------------------------------------------------------------------------
	Version: 1.1.0
	Release date: 2006-05-13
	Last update: 2020-09-09

	Original code by SpamSpan (www.spamspan.com) (c) 2006.
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
	Configuration.
	---------------------------------------------------------------------------
*/

let mainClass = 'spamspan-replace';
let localClass = 'local';
let domainClass = 'domain';
let anchorClass = 'anchor';
let urlParams = ['subject', 'body'];

/*
	---------------------------------------------------------------------------
	Do not edit past this point unless you know what you are doing.
	---------------------------------------------------------------------------
*/

$(document).ready(function () {
	let allRelevantSpans = $('span').filter('.' + mainClass);
	allRelevantSpans.each(function (index, span) {
		// Get data.
		let user = getText(span, localClass);
		let domain = getText(span, domainClass);
		let anchorText = getText(span, anchorClass);
		// Prepare parameter data.
		let params = [];
		for (let j = 0; j < urlParams.length; j++) {
			let paramSpanValue = getText(span, urlParams[j]);
			if (paramSpanValue !== '') {
				params.push(urlParams[j] + '=' +
					encodeURIComponent(paramSpanValue));
			}
		}
		// Create new anchor tag.
		let email = cleanText(user) + '@' + cleanText(domain);
		let anchorTagText = anchorText === '' ? email : anchorText;
		let href = 'mailto:' + email;
		if (params.length > 0) {
			href += '?' + params.join('&');
		}
		let anchorTag = $('<a></a>').addClass(mainClass).attr('href', href).text(anchorTagText);
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
 * Remove whitespace and [dot] obfuscation from a text.
 * 
 * @param {string} string
 * @return {string}
 */
function cleanText(string) {
	// Replace letiations of [dot] with '.'.
	string = string.replace(/[\[\(\{]?[dD][oO0][tT][\}\)\]]?/g, '.');
	// Remove whitespace.
	string = string.replace(/\s+/g, '');
	return string;
}
