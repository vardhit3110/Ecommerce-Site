$(document).ready(function () {
    const stateData = {
        'India': ['Gujarat', 'Maharashtra', 'Rajasthan', 'Karnataka', 'Tamil Nadu', 'Delhi', 'Punjab',
            'Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar',
            'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu',
            'Goa', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand',
            'Kerala', 'Ladakh', 'Lakshadweep', 'Madhya Pradesh', 'Manipur', 'Meghalaya',
            'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Sikkim', 'Telangana',
            'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'],
    };

    $('#address_country').change(function () {
        const country = $(this).val();
        const stateSelect = $('#address_state');
        stateSelect.val('');
        $('#address_zip').val('');
        $('#deliverTo').text('Not specified');
        $('#zipError').text('');

        if (country) {
            stateSelect.prop('disabled', false);
            stateSelect.find('option:not(:first)').remove();

            if (stateData[country]) {
                stateData[country].forEach(state => {
                    stateSelect.append(`<option value="${state}">${state}</option>`);
                });
            }
        } else {
            stateSelect.prop('disabled', true);
        }
    });

    $('#address_zip').on('blur', function () {
        const zipCode = $(this).val().trim();
        const country = $('#address_country').val();
        const state = $('#address_state').val();

        $('#zipError').text('');
        $('#saveMessage').text('');

        if (zipCode) {

            if (!country) {
                $('#zipError').text('Please select a country first');
                return;
            }

            if (!state) {
                $('#zipError').text('Please select a state first');
                return;
            }

            $('#zipLoading').show();

            let isValidFormat = true;
            if (country === 'India' && !/^\d{6}$/.test(zipCode)) {
                $('#zipError').text('Please enter a valid 6-digit Indian PIN code');
                isValidFormat = false;
            } else if (country === 'USA' && !/^\d{5}(-\d{4})?$/.test(zipCode)) {
                $('#zipError').text('Please enter a valid US ZIP code');
                isValidFormat = false;
            } else if (country === 'Canada' && !/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/.test(zipCode)) {
                $('#zipError').text('Please enter a valid Canadian postal code');
                isValidFormat = false;
            } else if (country === 'UK' && !/^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/.test(zipCode)) {
                $('#zipError').text('Please enter a valid UK postcode');
                isValidFormat = false;
            }

            if (!isValidFormat) {
                $('#zipLoading').hide();
                return;
            }

            simulateGoogleSearch(zipCode, state, country)
                .then(cityInfo => {

                    $('#zipLoading').hide();

                    if (cityInfo) {

                        $('#deliverTo').text(`${cityInfo} - ${zipCode}`);
                        $('#zipError').text('');
                    } else {
                        $('#zipError').text('City not found for this zip code in the selected state');
                        $('#deliverTo').text('Not specified');
                    }
                })
                .catch(error => {
                    $('#zipLoading').hide();
                    $('#zipError').text('Error searching for city information. Please try again.');
                    console.error('Search Error:', error);
                });
        } else {
            $('#deliverTo').text('Not specified');
        }
    });

    $('#address_state').change(function () {
        const zipCode = $('#address_zip').val().trim();
        if (zipCode) {
            $('#address_zip').trigger('blur');
        }
    });

    function simulateGoogleSearch(zipCode, state, country) {
        return new Promise((resolve, reject) => {

            setTimeout(() => {
                const mockData = {
                    'Gujarat': {
                        '380001': 'Ahmedabad',
                        '395003': 'Surat',
                        '390001': 'Vadodara',
                        '360001': 'Rajkot',
                        '388001': 'Anand',
                        '364001': 'Bhavnagar',
                        '382010': 'Gandhinagar',
                        '370001': 'Bhuj',
                        '389001': 'Godhra',
                        '362001': 'Junagadh',
                        '396001': 'Valsad',
                        '396445': 'Vapi',
                        '394107': 'Bardoli',
                        '391440': 'Padra',
                        '361001': 'Jamnagar',
                        '362560': 'Veraval',
                        '384001': 'Palanpur',
                        '387001': 'Nadiad',
                        '370110': 'Anjar',
                        '370201': 'Mandvi',
                        '396321': 'Navsari',
                        '388120': 'Petlad',
                        '393001': 'Rajpipla',
                        '394601': 'Vyara',
                        '389151': 'Halol',
                        '389230': 'Kalol',
                        '388630': 'Borsad',
                        '388220': 'Khambhat',
                        '396580': 'Dharampur',
                        '391760': 'Savli',
                        '394510': 'Chorasi',
                        '384265': 'Deesa',
                        '388245': 'Sojitra',
                        '392001': 'Bharuch',
                        '393040': 'Zaghadia',
                        '396191': 'Bilimora',
                        '389120': 'Lunawada',
                        '383001': 'Himatnagar',
                        '382721': 'Kalol',
                        '384002': 'Mehsana',
                        '384355': 'Unjha',
                        '394110': 'Kamrej',
                        '382230': 'Sanand',
                        '361160': 'Kalavad',
                        '362225': 'Mangrol',
                        '388530': 'Umreth',
                        '391135': 'Karjan',
                        '385001': 'Patan',
                        '387620': 'Kapadvanj',
                        '396406': 'Chikhli',
                        '387540': 'Thasra',
                        '388710': 'Dakor',
                        '382735': 'Viramgam',
                        '362001': 'Keshod',
                        '384170': 'Kadi',
                        '361002': 'Khambhaliya',
                        '364270': 'Mahuva',
                        '396230': 'Amalsad',
                        '388580': 'Anklav',
                        '394160': 'Mandvi (Surat)',
                        '360490': 'Upleta',
                        '388180': 'Dhulia',
                        '394125': 'Palsana',
                        '362720': 'Talala',
                        '396050': 'Valsad INA',
                        '382220': 'Bavla',
                        '383310': 'Idar',
                        '360050': 'Gondal',
                        '361305': 'Salaya',
                        '361008': 'Okha',
                        '384210': 'Visnagar',
                        '385535': 'Radhanpur',
                        '383230': 'Modasa',
                        '388265': 'Tarapur',
                        '364290': 'Sihor',
                        '361330': 'Dwarka',
                        '362245': 'Kodinar',
                        '361170': 'Bhanvad',
                        '364710': 'Gariadhar',
                        '364515': 'Talaja',
                        '384315': 'Chanasma',
                        '385340': 'Siddhpur',
                        '387610': 'Balasinor',
                        '384001': 'Palanpur',
                        '382120': 'Dholka',
                        '382715': 'Detroj',
                        '385520': 'Tharad',
                        '383120': 'Bayad',
                        '360311': 'Jetpur',
                        '362730': 'Una',
                        '370615': 'Gandhidham',
                        '370240': 'Nakhatrana',
                        '370465': 'Rapar',
                        '370205': 'Mundra',
                        '370601': 'Samakhiali',
                        '395009': 'Adajan',
                        '382721': 'Kalol (Gandhinagar)'
                    },
                    'Maharashtra': {
                        '400001': 'Mumbai',
                        '411001': 'Pune',
                        '422001': 'Nashik',
                        '431001': 'Aurangabad'
                    },
                    'Rajasthan': {
                        '302001': 'Jaipur',
                        '324001': 'Kota',
                        '313001': 'Udaipur',
                        '334001': 'Bikaner'
                    }
                };

                if (mockData[state] && mockData[state][zipCode]) {
                    resolve(mockData[state][zipCode]);
                } else {
                    resolve(null);
                }
            }, 1500);
        });
    }
    $('#calculateShipping').click(function () {
        $('#saveMessage').text('');

        const country = $('#address_country').val();
        const state = $('#address_state').val();
        const zip = $('#address_zip').val().trim();
        const deliverTo = $('#deliverTo').text();

        // Validation
        let isValid = true;

        if (!country) {
            $('#countryError').text('Please select a country');
            isValid = false;
        } else {
            $('#countryError').text('');
        }

        if (!state) {
            $('#stateError').text('Please select a state');
            isValid = false;
        } else {
            $('#stateError').text('');
        }

        if (!zip) {
            $('#zipError').text('Please enter a ZIP code');
            isValid = false;
        } else if (deliverTo === 'Not specified') {
            $('#zipError').text('Please enter a valid ZIP code for the selected state');
            isValid = false;
        } else {
            $('#zipError').text('');
        }

        if (!isValid) return;
        const city = deliverTo.split(' - ')[0];

        $.ajax({
            url: '/save-shipping',
            method: 'POST',
            data: {
                country: country,
                state: state,
                zip: zip,
                city: city
            },
            beforeSend: function () {
                $('#calculateShipping').prop('disabled', true).text('Saving...');
            },
            success: function (response) {
                // Show success message
                $('#saveMessage').removeClass('error').addClass('success').text('Shipping information saved successfully!');

                // Reset button
                $('#calculateShipping').prop('disabled', false).text('Add Location');
            },
            error: function (xhr, status, error) {
                // Show error message
                $('#saveMessage').removeClass('success').addClass('error').text('Error saving shipping information. Please try again.');

                // Reset button
                $('#calculateShipping').prop('disabled', false).text('Add Location');
            }
        });
    });
});
