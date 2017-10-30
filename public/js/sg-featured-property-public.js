/* global google googleMapInit jQuery */
// (function ($) {
//   'use strict'

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
  /**
  -----------------------------------------------------------------
    Author: Gary Darling
    Email: garydarling@gmail.com
    Created: 2017-09-06
    Description:  javascript for Featured Property CPT
  -----------------------------------------------------------------
  */

  /**
   * @function
   * @name   googleMapInit
   * @param {string} address      a street address parseable by Google maps
   * @param {string} buildingName the name of the condo building, if exists
   * @param {string} numUnits     unused, empty string (future)
   * @param {string} infoAddress  a formatted address that looks good in a Google maps info box
   * @param {string} postType     the slug of the custom post type
   * @param {string} mapDiv       the id of the div element holding the map
   * @param {object} mapOptions   an object containg our map options; lat/long, zoom, styles
   * @return {object} a complete  Google map
   */
  function googleMapInit (address, buildingName, numUnits, infoAddress, postType, mapDiv, mapOptions) {
    var map = new google.maps.Map(document.getElementById(mapDiv), mapOptions)
    var geocoder = new google.maps.Geocoder()
    geocodeAddress(geocoder, map, address, buildingName, numUnits, infoAddress, postType)
  }

  function geocodeAddress (geocoder, resultsMap, address, buildingName, numUnits, infoAddress, postType) {
    geocoder.geocode({'address': address}, function (results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        resultsMap.setCenter(results[0].geometry.location)
        var marker = new google.maps.Marker({
          map: resultsMap,
          position: results[0].geometry.location
        })
        var buildingText
        var addressText
        // var unitsText
        if (typeof buildingName !== 'undefined') {
          buildingText = '<div class="iw-title">' + buildingName + '</div>'
        }
        if (typeof infoAddress !== 'undefined') {
          addressText = '<p>' + infoAddress + '</p>'
        }
        google.maps.event.addListener(marker, 'click', function () {
          infowindow.open(resultsMap, marker)
        })
        google.maps.event.addListener(resultsMap, 'click', function () {
          infowindow.close()
        })

        var contentString = '<div id="iw-container">' +
        buildingText +
        '<div class="iw-content">' +
        addressText +
        '</div>' + // end #iw-content
        '</div>' // end #iw-container

        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 300
        })
        google.maps.event.addListener(infowindow, 'domready', function () {
          var iwOuter = jQuery('.gm-style-iw')

          /* Since this div is in a position prior to .gm-div style-iw.
           * We use jQuery and create a iwBackground variable,
           * and take advantage of the existing reference .gm-style-iw for the previous div with .prev().
          */
          var iwBackground = iwOuter.prev()

          // Removes background shadow DIV
          iwBackground.children(':nth-child(2)').css({'display': 'none'})

          // Removes white background DIV
          iwBackground.children(':nth-child(4)').css({'display': 'none'})

          // Moves the infowindow 115px to the right.
          iwOuter.parent().parent().css({left: '88px'})

          // Moves the shadow of the arrow 76px to the left margin.
          iwBackground.children(':nth-child(1)').attr('style', function (i, s) { return s + 'left: 76px !important;' })

          // Moves the arrow 76px to the left margin.
          iwBackground.children(':nth-child(3)').attr('style', function (i, s) { return s + 'left: 76px !important;' })

          // Changes the desired tail shadow color.
          iwBackground.children(':nth-child(3)').find('div').children().css({ 'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index': '1' })

          // Reference to the div that groups the close button elements.
          var iwCloseBtn = iwOuter.next()

          // Apply the desired effect to the close button
          iwCloseBtn.css({opacity: '1', right: '38px', top: '3px', width: '27px', height: '27px', border: '7px solid rgb(276,76,76)', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'})

          // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
          iwCloseBtn.mouseout(function () {
            jQuery(this).css({opacity: '1'})
          })
        })
      } else {
        console.log('Geocode was not successful for the following reason: ' + status)
      }
    })
  }
// })( jQuery );
