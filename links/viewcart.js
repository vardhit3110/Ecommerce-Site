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
                        '400601': 'Thane',
                        '411001': 'Pune',
                        '440001': 'Nagpur',
                        '422001': 'Nashik',
                        '431001': 'Aurangabad',
                        '415612': 'Satara',
                        '416416': 'Sangli',
                        '416001': 'Kolhapur',
                        '425001': 'Jalgaon',
                        '444601': 'Akola',
                        '444001': 'Amravati',
                        '413512': 'Solapur',
                        '431203': 'Nanded',
                        '431515': 'Latur',
                        '422003': 'Malegaon',
                        '413133': 'Beed',
                        '415001': 'Ratnagiri',
                        '403601': 'Sindhudurg',
                        '442401': 'Wardha',
                        '441904': 'Gadchiroli',
                        '445001': 'Yavatmal',
                        '442101': 'Chandrapur',
                        '431705': 'Parbhani',
                        '431801': 'Hingoli',
                        '413001': 'Osmanabad'
                    },
                    'Rajasthan': {
                        '302001': 'Jaipur',
                        '324001': 'Kota',
                        '313001': 'Udaipur',
                        '334001': 'Bikaner',
                        '305001': 'Ajmer',
                        '341001': 'Jodhpur',
                        '326001': 'Bhilwara',
                        '312001': 'Alwar',
                        '306001': 'Bharatpur',
                        '333001': 'Sikar',
                        '307001': 'Tonk',
                        '335001': 'Jaisalmer',
                        '344001': 'Barmer',
                        '325001': 'Chittorgarh',
                        '312601': 'Jaipur Rural',
                        '332001': 'Nagaur',
                        '306401': 'Dholpur',
                        '307601': 'Karauli',
                        '325201': 'Pratapgarh'
                    },
                    'Karnataka': {
                        '560001': 'Bengaluru',
                        '580001': 'Hubli',
                        '580020': 'Dharwad',
                        '590001': 'Belagavi',
                        '577001': 'Mysuru',
                        '573201': 'Mangalore',
                        '577101': 'Mandya',
                        '585101': 'Kalaburagi',
                        '583101': 'Ballari',
                        '572101': 'Davangere',
                        '577201': 'Chamarajanagar',
                        '571101': 'Tumakuru',
                        '574101': 'Shimoga',
                        '591101': 'Raichur',
                        '562101': 'Kolar',
                        '581101': 'Gadag',
                        '573101': 'Hassan',
                        '572201': 'Chitradurga',
                        '583102': 'Koppal'
                    },
                    'Tamil Nadu': {
                        '600001': 'Chennai',
                        '625001': 'Madurai',
                        '641001': 'Coimbatore',
                        '630001': 'Tiruchirappalli',
                        '605001': 'Kanchipuram',
                        '607001': 'Vellore',
                        '613001': 'Thanjavur',
                        '606001': 'Cuddalore',
                        '627001': 'Thoothukudi',
                        '636001': 'Salem',
                        '623001': 'Ramanathapuram',
                        '636006': 'Namakkal',
                        '635001': 'Erode',
                        '628001': 'Nagercoil',
                        '622001': 'Pudukkottai',
                        '607002': 'Arcot',
                        '635109': 'Tiruppur',
                        '609001': 'Tiruvannamalai',
                        '611001': 'Kumbakonam'
                    },
                    'Delhi': {
                        '110001': 'Connaught Place',
                        '110002': 'Daryaganj',
                        '110003': 'Sansad Marg',
                        '110004': 'Ajmeri Gate',
                        '110005': 'New Delhi',
                        '110006': 'Old Delhi',
                        '110007': 'Parliament Street',
                        '110008': 'Chandni Chowk',
                        '110009': 'Karol Bagh',
                        '110010': 'Jangpura',
                        '110011': 'Lodhi Road',
                        '110012': 'Chanakyapuri',
                        '110013': 'R.K. Puram',
                        '110014': 'Vasant Vihar',
                        '110015': 'Sarojini Nagar',
                        '110016': 'Rajouri Garden',
                        '110017': 'Dwarka',
                        '110018': 'Patel Nagar',
                        '110019': 'Saket',
                        '110020': 'Hauz Khas'
                    },
                    'Punjab': {
                        '160001': 'Chandigarh',
                        '140001': 'Amritsar',
                        '143001': 'Ludhiana',
                        '141001': 'Jalandhar',
                        '144001': 'Patiala',
                        '146001': 'Bathinda',
                        '145001': 'Mohali',
                        '142001': 'Hoshiarpur',
                        '148001': 'Firozpur',
                        '144101': 'Moga',
                        '145001': 'Sangrur',
                        '147001': 'Faridkot',
                        '141421': 'Phagwara',
                        '144401': 'Barnala',
                        '143601': 'Kapurthala'
                    },
                    'Andhra Pradesh': {
                        '520001': 'Vijayawada',
                        '530001': 'Visakhapatnam',
                        '500001': 'Hyderabad (Telangana, pehle Andhra Pradesh ka hissa)',
                        '515001': 'Tirupati',
                        '522001': 'Guntur',
                        '533001': 'Kakinada',
                        '523001': 'Nellore',
                        '516001': 'Kadapa',
                        '521001': 'Rajahmundry',
                        '532001': 'Srikakulam',
                        '534001': 'Vizianagaram',
                        '524001': 'Ongole',
                        '517001': 'Anantapur',
                        '518001': 'Kurnool',
                        '515131': 'Chittoor',
                        '521401': 'Eluru'
                    },
                    'Arunachal Pradesh': {
                        '791001': 'Itanagar',
                        '791111': 'Naharlagun',
                        '792001': 'Pasighat',
                        '792002': 'Roing',
                        '792103': 'Ziro',
                        '792104': 'Bomdila',
                        '792106': 'Seppa',
                        '792107': 'Tawang',
                        '792108': 'Tezu',
                        '792109': 'Daporijo',
                        '792110': 'Bomdila',
                        '792112': 'Aalo',
                        '792113': 'Hayuliang',
                        '792114': 'Yingkiong',
                        '792115': 'Paka'
                    },
                    'Assam': {
                        '781001': 'Guwahati',
                        '785001': 'Tezpur',
                        '784001': 'Silchar',
                        '782001': 'Dibrugarh',
                        '786001': 'Jorhat',
                        '783001': 'Nagaon',
                        '788001': 'Bongaigaon',
                        '785699': 'Mangaldoi',
                        '786125': 'Sivasagar',
                        '783392': 'Goalpara',
                        '786122': 'Golaghat',
                        '788120': 'Barpeta',
                        '784110': 'Haflong',
                        '782445': 'Tinsukia',
                        '786150': 'Dhemaji'
                    },
                    'Bihar': {
                        '800001': 'Patna',
                        '821001': 'Gaya',
                        '824001': 'Bhagalpur',
                        '826001': 'Muzaffarpur',
                        '845001': 'Darbhanga',
                        '802301': 'Ara (Bhojpur)',
                        '843101': 'Purnia',
                        '801503': 'Munger',
                        '841101': 'Sitamarhi',
                        '852001': 'Saharsa',
                        '824101': 'Saharsa',
                        '825101': 'Samastipur',
                        '847001': 'Madhubani',
                        '803101': 'Buxar',
                        '841301': 'Madhubani',
                        '835101': 'Dhanbad (Jharkhand me ab alag hai)',
                        '842001': 'Begusarai'
                    },
                    'Chandigarh': {
                        '160001': 'Sector 1',
                        '160002': 'Sector 2',
                        '160003': 'Sector 3',
                        '160004': 'Sector 4',
                        '160005': 'Sector 5',
                        '160006': 'Sector 6',
                        '160007': 'Sector 7',
                        '160008': 'Sector 8',
                        '160009': 'Sector 9',
                        '160010': 'Sector 10',
                        '160011': 'Sector 11',
                        '160012': 'Sector 12',
                        '160013': 'Sector 13',
                        '160014': 'Sector 14',
                        '160015': 'Sector 15',
                        '160016': 'Sector 16',
                        '160017': 'Sector 17',
                        '160018': 'Sector 18',
                        '160019': 'Sector 19',
                        '160020': 'Sector 20'
                    },
                    'Chhattisgarh': {
                        '492001': 'Raipur',
                        '495001': 'Bilaspur',
                        '491001': 'Durg',
                        '496001': 'Bhilai',
                        '493001': 'Korba',
                        '495006': 'Raigarh',
                        '495004': 'Mahasamund',
                        '493445': 'Jagdalpur',
                        '494001': 'Ambikapur',
                        '495009': 'Kawardha',
                        '493889': 'Raipur Rural',
                        '493661': 'Kanker',
                        '494110': 'Sarangarh',
                        '495114': 'Balod',
                        '493773': 'Bemetara'
                    },
                    'Goa': {
                        '403001': 'Panaji',
                        '403002': 'Panaji',
                        '403203': 'Vasco da Gama',
                        '403004': 'Ponda',
                        '403101': 'Margao',
                        '403102': 'Margao',
                        '403107': 'Mormugao',
                        '403108': 'Dabolim',
                        '403401': 'Mapusa',
                        '403402': 'Bardez',
                        '403403': 'Bicholim',
                        '403501': 'Canacona',
                        '403602': 'Curchorem',
                        '403605': 'Quepem',
                        '403606': 'Sanguem',
                        '403607': 'Mollem',
                        '403608': 'Valpoi',
                        '403609': 'Pernem',
                        '403701': 'Calangute',
                        '403702': 'Anjuna',
                        '403703': 'Candolim',
                        '403704': 'Assagao',
                        '403705': 'Siolim',
                        '403706': 'Mapusa Rural'
                    },
                    'Haryana': {
                        '122001': 'Gurugram',
                        '121002': 'Faridabad',
                        '124001': 'Rohtak',
                        '132001': 'Karnal',
                        '133001': 'Ambala Cantt',
                        '125001': 'Hisar',
                        '127021': 'Bhiwani',
                        '131001': 'Sonepat',
                        '136118': 'Kurukshetra',
                        '135001': 'Yamuna Nagar'
                    },
                    'Himachal Pradesh': {
                        '171001': 'Shimla',
                        '175001': 'Mandi',
                        '176001': 'Kangra',
                        '173212': 'Solan',
                        '174001': 'Bilaspur (HP)',
                        '174303': 'Una',
                        '175101': 'Kullu',
                        '176310': 'Chamba',
                        '172107': 'Kinnaur',
                        '173001': 'Sirmaur'
                    },
                    'Jammu and Kashmir': {
                        '180001': 'Jammu',
                        '190001': 'Srinagar',
                        '181101': 'Udhampur',
                        '184101': 'Kathua',
                        '193201': 'Anantnag',
                        '193501': 'Baramulla',
                        '182101': 'Rajauri',
                        '185101': 'Poonch',
                        '192001': 'Kupwara',
                        '190005': 'Pulwama'
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

                $('#saveMessage').removeClass('error').addClass('success').text('Shipping information saved successfully!');

                $('#calculateShipping').prop('disabled', false).text('Add Location');
            },
            error: function (xhr, status, error) {

                $('#saveMessage').removeClass('success').addClass('error').text('Error saving shipping information. Please try again.');

                $('#calculateShipping').prop('disabled', false).text('Add Location');
            }
        });
    });
});
