/**
 * Customizer theme info script
 *
 * @package Hestia
 */

( function( api ) {

	// Extends our custom "hestia-theme-info" section.
	api.sectionConstructor['hestia-theme-info'] = api.Section.extend(
		{

				// No events for this type of section.
			attachEvents: function () {},

				// Always make the section active.
			isContextuallyActive: function () {
				return true;
			}
		}
	);

	// Extends our custom "hestia-theme-info-sectionsections" section.
	api.sectionConstructor['hestia-theme-info-section'] = api.Section.extend(
		{

				// No events for this type of section.
			attachEvents: function () {},

				// Always make the section active.
			isContextuallyActive: function () {
				return true;
			}
		}
	);

} )( wp.customize );
