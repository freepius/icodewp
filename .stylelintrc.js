'use strict';

module.exports = {
	extends: '@wordpress/stylelint-config/scss',
	rules: {
		// @wordpress/stylelint-config SCSS overrides.
		'max-line-length': [
			120,
			{
				ignore: 'non-comments'
			},
		],
		'selector-class-pattern': null,
	},
};
