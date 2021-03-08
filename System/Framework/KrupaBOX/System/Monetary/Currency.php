<?php

namespace Monetary
{
    class Currency
    {
        private static $data = [
            [country => "Abkhazia", currency => "Russian ruble", symbol => "RUB", isoCode => "RUB", fractional => "Kopek"],
            [country => "Afghanistan", currency => "Afghan afghani", symbol => "؋", isoCode => "AFN", fractional => "Pul"],
            [country => "Akrotiri and Dhekelia", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Albania", currency => "Albanian lek", symbol => "L", isoCode => "ALL", fractional => "Qindarkë"],
            [country => "Alderney", currency => "Alderney pound", symbol => "£", isoCode => "(none)", fractional => "Penny"],
            [country => "Alderney", currency => "British pound", symbol => "£", isoCode => "GBP", fractional => "Penny"],
            [country => "Alderney", currency => "Guernsey pound", symbol => "£", isoCode => "GGP[F]", fractional => "Penny"],
            [country => "Algeria", currency => "Algerian dinar", symbol => "د.ج", isoCode => "DZD", fractional => "Santeem"],
            [country => "Andorra", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Angola", currency => "Angolan kwanza", symbol => "Kz", isoCode => "AOA", fractional => "Cêntimo"],
            [country => "Anguilla", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Antigua and Barbuda", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Argentina", currency => "Argentine peso", symbol => "$", isoCode => "ARS", fractional => "Centavo"],
            [country => "Armenia", currency => "Armenian dram", symbol => "Armenian dram sign.svg", isoCode => "AMD", fractional => "Luma"],
            [country => "Aruba", currency => "Aruban florin", symbol => "ƒ", isoCode => "AWG", fractional => "Cent"],
            [country => "United Kingdom Ascension Island", currency => "Ascension pound", symbol => "£", isoCode => "(none)", fractional => "Penny"],
            [country => "United Kingdom Ascension Island", currency => "Saint Helena pound", symbol => "£", isoCode => "SHP", fractional => "Penny"],
            [country => "Australia", currency => "Australian dollar", symbol => "$", isoCode => "AUD", fractional => "Cent"],
            [country => "Austria", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Azerbaijan", currency => "Azerbaijani manat", symbol => "Azeri manat symbol.svg", isoCode => "AZN", fractional => "Qəpik"],
            [country => "Bahamas", currency => "The", symbol => "Bahamian dollar", isoCode => "$", fractional => "BSD", "Cent"],
            [country => "Bahrain", currency => "Bahraini dinar", symbol => ".د.ب", isoCode => "BHD", fractional => "Fils"],
            [country => "Bangladesh", currency => "Bangladeshi taka", symbol => "৳", isoCode => "BDT", fractional => "Paisa"],
            [country => "Barbados", currency => "Barbadian dollar", symbol => "$", isoCode => "BBD", fractional => "Cent"],
            [country => "Belarus", currency => "Belarusian ruble", symbol => "Br", isoCode => "BYR", fractional => "Kapyeyka"],
            [country => "Belgium", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Belize", currency => "Belize dollar", symbol => "$", isoCode => "BZD", fractional => "Cent"],
            [country => "Benin", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Bermuda", currency => "Bermudian dollar", symbol => "$", isoCode => "BMD", fractional => "Cent"],
            [country => "Bhutan", currency => "Bhutanese ngultrum", symbol => "Nu.", isoCode => "BTN", fractional => "Chetrum"],
            [country => "Bhutan", currency => "Indian rupee", symbol => "₹", isoCode => "INR", fractional => "Paisa"],
            [country => "Bolivia", currency => "Bolivian boliviano", symbol => "Bs.", isoCode => "BOB", fractional => "Centavo"],
            [country => "Bonaire", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Bosnia and Herzegovina", currency => "Bosnia and Herzegovina convertible mark", symbol => "KM or КМ[G]", isoCode => "BAM", fractional => "Fening"],
            [country => "Botswana", currency => "Botswana pula", symbol => "P", isoCode => "BWP", fractional => "Thebe"],
            [country => "Brazil", currency => "Brazilian real", symbol => "R$", isoCode => "BRL", fractional => "Centavo"],
            [country => "British Indian Ocean Territory", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "British Virgin Islands", currency => "British Virgin Islands dollar", symbol => "$", isoCode => "(none)", fractional => "Cent"],
            [country => "British Virgin Islands", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Brunei", currency => "Brunei dollar", symbol => "$", isoCode => "BND", fractional => "Sen"],
            [country => "Brunei", currency => "Singapore dollar", symbol => "$", isoCode => "SGD", fractional => "Cent"],
            [country => "Bulgaria", currency => "Bulgarian lev", symbol => "лв", isoCode => "BGN", fractional => "Stotinka"],
            [country => "Burkina Faso", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Burundi", currency => "Burundian franc", symbol => "Fr", isoCode => "BIF", fractional => "Centime"],
            [country => "Cambodia", currency => "Cambodian riel", symbol => "៛", isoCode => "KHR", fractional => "Sen"],
            [country => "Cambodia", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Cameroon", currency => "Central African CFA franc", symbol => "Fr", isoCode => "XAF", fractional => "Centime"],
            [country => "Canada", currency => "Canadian dollar", symbol => "$", isoCode => "CAD", fractional => "Cent"],
            [country => "Cape Verde", currency => "Cape Verdean escudo", symbol => "Esc or $", isoCode => "CVE", fractional => "Centavo"],
            [country => "Cayman Islands", currency => "Cayman Islands dollar", symbol => "$", isoCode => "KYD", fractional => "Cent"],
            [country => "Central African Republic", currency => "Central African CFA franc", symbol => "Fr", isoCode => "XAF", fractional => "Centime"],
            [country => "Chad", currency => "Central African CFA franc", symbol => "Fr", isoCode => "XAF", fractional => "Centime"],
            [country => "Chile", currency => "Chilean peso", symbol => "$", isoCode => "CLP", fractional => "Centavo"],
            [country => "China", currency => "Chinese yuan", symbol => "¥ or 元", isoCode => "CNY", fractional => "Fen[H]"],
            [country => "Cocos (Keeling) Islands", currency => "Australian dollar", symbol => "$", isoCode => "AUD", fractional => "Cent"],
            [country => "Colombia", currency => "Colombian peso", symbol => "$", isoCode => "COP", fractional => "Centavo"],
            [country => "Comoros", currency => "Comorian franc", symbol => "Fr", isoCode => "KMF", fractional => "Centime"],
            [country => "Congo, currency => Democratic Republic of the", symbol => "Congolese franc", isoCode => "Fr", fractional => "CDF", "Centime"],
            [country => "Congo, currency => Republic of the", symbol => "Central African CFA franc", isoCode => "Fr", fractional => "XAF", "Centime"],
            [country => "Cook Islands", currency => "New Zealand dollar", symbol => "$", isoCode => "NZD", fractional => "Cent"],
            [country => "Cook Islands", currency => "Cook Islands dollar", symbol => "$", isoCode => "(none)", fractional => "Cent"],
            [country => "Costa Rica", currency => "Costa Rican colón", symbol => "₡", isoCode => "CRC", fractional => "Céntimo"],
            [country => "Croatia", currency => "Croatian kuna", symbol => "kn", isoCode => "HRK", fractional => "Lipa"],
            [country => "Cuba", currency => "Cuban convertible peso", symbol => "$", isoCode => "CUC", fractional => "Centavo"],
            [country => "Cuba", currency => "Cuban peso", symbol => "$", isoCode => "CUP", fractional => "Centavo"],
            [country => "Curaçao", currency => "Netherlands Antillean guilder", symbol => "ƒ", isoCode => "ANG", fractional => "Cent"],
            [country => "Cyprus", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Czech Republic", currency => "Czech koruna", symbol => "Kč", isoCode => "CZK", fractional => "Haléř"],
            [country => "Côte d'Ivoire", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Denmark", currency => "Danish krone", symbol => "kr", isoCode => "DKK", fractional => "Øre"],
            [country => "Djibouti", currency => "Djiboutian franc", symbol => "Fr", isoCode => "DJF", fractional => "Centime"],
            [country => "Dominica", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Dominican Republic", currency => "Dominican peso", symbol => "$", isoCode => "DOP", fractional => "Centavo"],
            [country => "East Timor", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Ecuador", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Egypt", currency => "Egyptian pound", symbol => "£ or ج.م", isoCode => "EGP", fractional => "Piastre"],
            [country => "El Salvador", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Equatorial Guinea", currency => "Central African CFA franc", symbol => "Fr", isoCode => "XAF", fractional => "Centime"],
            [country => "Eritrea", currency => "Eritrean nakfa", symbol => "Nfk", isoCode => "ERN", fractional => "Cent"],
            [country => "Estonia", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Ethiopia", currency => "Ethiopian birr", symbol => "Br", isoCode => "ETB", fractional => "Santim"],
            [country => "Falkland Islands", currency => "Falkland Islands pound", symbol => "£", isoCode => "FKP", fractional => "Penny"],
            [country => "Faroe Islands", currency => "Danish krone", symbol => "kr", isoCode => "DKK", fractional => "Øre"],
            [country => "Fiji", currency => "Fijian dollar", symbol => "$", isoCode => "FJD", fractional => "Cent"],
            [country => "Finland", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "France", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "French Polynesia", currency => "CFP franc", symbol => "Fr", isoCode => "XPF", fractional => "Centime"],
            [country => "Gabon", currency => "Central African CFA franc", symbol => "Fr", isoCode => "XAF", fractional => "Centime"],
            [country => "Gambia, currency => The", symbol => "Gambian dalasi", isoCode => "D", fractional => "GMD", "Butut"],
            [country => "Georgia", currency => "Georgian lari", symbol => "ლ", isoCode => "GEL", fractional => "Tetri"],
            [country => "Germany", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Ghana", currency => "Ghana cedi", symbol => "₵", isoCode => "GHS", fractional => "Pesewa"],
            [country => "Gibraltar", currency => "Gibraltar pound", symbol => "£", isoCode => "GIP", fractional => "Penny"],
            [country => "Greece", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Grenada", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Guatemala", currency => "Guatemalan quetzal", symbol => "Q", isoCode => "GTQ", fractional => "Centavo"],
            [country => "Guernsey", currency => "British pound", symbol => "£", isoCode => "GBP", fractional => "Penny"],
            [country => "Guinea", currency => "Guinean franc", symbol => "Fr", isoCode => "GNF", fractional => "Centime"],
            [country => "Guinea-Bissau", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Guyana", currency => "Guyanese dollar", symbol => "$", isoCode => "GYD", fractional => "Cent"],
            [country => "Haiti", currency => "Haitian gourde", symbol => "G", isoCode => "HTG", fractional => "Centime"],
            [country => "Honduras", currency => "Honduran lempira", symbol => "L", isoCode => "HNL", fractional => "Centavo"],
            [country => "Hong Kong", currency => "Hong Kong dollar", symbol => "$", isoCode => "HKD", fractional => "Cent"],
            [country => "Hungary", currency => "Hungarian forint", symbol => "Ft", isoCode => "HUF", fractional => "Fillér"],
            [country => "Iceland", currency => "Icelandic króna", symbol => "kr", isoCode => "ISK", fractional => "Eyrir"],
            [country => "India", currency => "Indian rupee", symbol => "₹", isoCode => "INR", fractional => "Paisa"],
            [country => "Indonesia", currency => "Indonesian rupiah", symbol => "Rp", isoCode => "IDR", fractional => "Sen"],
            [country => "Iran", currency => "Iranian rial", symbol => "﷼", isoCode => "IRR", fractional => "Dinar"],
            [country => "Iraq", currency => "Iraqi dinar", symbol => "ع.د", isoCode => "IQD", fractional => "Fils"],
            [country => "Ireland", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Isle of Man", currency => "British pound", symbol => "£", isoCode => "GBP", fractional => "Penny"],
            [country => "Isle of Man", currency => "Manx pound", symbol => "£", isoCode => "IMP[F]", fractional => "Penny"],
            [country => "Israel", currency => "Israeli new shekel", symbol => "₪", isoCode => "ILS", fractional => "Agora"],
            [country => "Italy", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Jamaica", currency => "Jamaican dollar", symbol => "$", isoCode => "JMD", fractional => "Cent"],
            [country => "Japan", currency => "Japanese yen", symbol => "¥", isoCode => "JPY", fractional => "Sen[C]"],
            [country => "Jersey", currency => "British pound", symbol => "£", isoCode => "GBP", fractional => "Penny"],
            [country => "Jersey", currency => "Jersey pound", symbol => "£", isoCode => "JEP[F]", fractional => "Penny"],
            [country => "Jordan", currency => "Jordanian dinar", symbol => "د.ا", isoCode => "JOD", fractional => "Piastre[J]"],
            [country => "Kazakhstan", currency => "Kazakhstani tenge", symbol => "Kazakhstani tenge symbol.svg", isoCode => "KZT", fractional => "Tïın"],
            [country => "Kenya", currency => "Kenyan shilling", symbol => "Sh", isoCode => "KES", fractional => "Cent"],
            [country => "Kiribati", currency => "Australian dollar", symbol => "$", isoCode => "AUD", fractional => "Cent"],
            [country => "Korea, currency => North", symbol => "North Korean won", isoCode => "₩", fractional => "KPW", "Chon"],
            [country => "Korea, currency => South", symbol => "South Korean won", isoCode => "₩", fractional => "KRW", "Jeon"],
            [country => "Kosovo", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Kuwait", currency => "Kuwaiti dinar", symbol => "د.ك", isoCode => "KWD", fractional => "Fils"],
            [country => "Kyrgyzstan", currency => "Kyrgyzstani som", symbol => "лв[K]", isoCode => "KGS", fractional => "Tyiyn"],
            [country => "Laos", currency => "Lao kip", symbol => "₭", isoCode => "LAK", fractional => "Att"],
            [country => "Latvia", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Lebanon", currency => "Lebanese pound", symbol => "ل.ل", isoCode => "LBP", fractional => "Piastre"],
            [country => "Lesotho", currency => "Lesotho loti", symbol => "L", isoCode => "LSL", fractional => "Sente"],
            [country => "Lesotho", currency => "South African rand", symbol => "R", isoCode => "ZAR", fractional => "Cent"],
            [country => "Liberia", currency => "Liberian dollar", symbol => "$", isoCode => "LRD", fractional => "Cent"],
            [country => "Libya", currency => "Libyan dinar", symbol => "ل.د", isoCode => "LYD", fractional => "Dirham"],
            [country => "Liechtenstein", currency => "Swiss franc", symbol => "Fr", isoCode => "CHF", fractional => "Rappen"],
            [country => "Lithuania", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Luxembourg", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Macau", currency => "Macanese pataca", symbol => "P", isoCode => "MOP", fractional => "Avo"],
            [country => "Macedonia, currency => Republic of", symbol => "Macedonian denar", isoCode => "ден", fractional => "MKD", "Deni"],
            [country => "Madagascar", currency => "Malagasy ariary", symbol => "Ar", isoCode => "MGA", fractional => "Iraimbilanja"],
            [country => "Malawi", currency => "Malawian kwacha", symbol => "MK", isoCode => "MWK", fractional => "Tambala"],
            [country => "Malaysia", currency => "Malaysian ringgit", symbol => "RM", isoCode => "MYR", fractional => "Sen"],
            [country => "Maldives", currency => "Maldivian rufiyaa", symbol => ".ރ", isoCode => "MVR", fractional => "Laari"],
            [country => "Mali", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Malta", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Marshall Islands", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Mauritania", currency => "Mauritanian ouguiya", symbol => "UM", isoCode => "MRO", fractional => "Khoums"],
            [country => "Mauritius", currency => "Mauritian rupee", symbol => "₨", isoCode => "MUR", fractional => "Cent"],
            [country => "Mexico", currency => "Mexican peso", symbol => "$", isoCode => "MXN", fractional => "Centavo"],
            [country => "Micronesia", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Moldova", currency => "Moldovan leu", symbol => "L", isoCode => "MDL", fractional => "Ban"],
            [country => "Monaco", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Mongolia", currency => "Mongolian tögrög", symbol => "₮", isoCode => "MNT", fractional => "Möngö"],
            [country => "Montenegro", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Montserrat", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Morocco", currency => "Moroccan dirham", symbol => "د.م.", isoCode => "MAD", fractional => "Centime"],
            [country => "Mozambique", currency => "Mozambican metical", symbol => "MT", isoCode => "MZN", fractional => "Centavo"],
            [country => "Myanmar", currency => "Burmese kyat", symbol => "Ks", isoCode => "MMK", fractional => "Pya"],
            [country => "Nagorno-Karabakh Republic", currency => "Armenian dram", symbol => "Armenian dram sign.svg", isoCode => "AMD", fractional => "Luma"],
            [country => "Namibia", currency => "Namibian dollar", symbol => "$", isoCode => "NAD", fractional => "Cent"],
            [country => "Namibia", currency => "South African rand", symbol => "R", isoCode => "ZAR", fractional => "Cent"],
            [country => "Nauru", currency => "Australian dollar", symbol => "$", isoCode => "AUD", fractional => "Cent"],
            [country => "Nepal", currency => "Nepalese rupee", symbol => "₨", isoCode => "NPR", fractional => "Paisa"],
            [country => "Netherlands[L]", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "New Caledonia", currency => "CFP franc", symbol => "Fr", isoCode => "XPF", fractional => "Centime"],
            [country => "New Zealand", currency => "New Zealand dollar", symbol => "$", isoCode => "NZD", fractional => "Cent"],
            [country => "Nicaragua", currency => "Nicaraguan córdoba", symbol => "C$", isoCode => "NIO", fractional => "Centavo"],
            [country => "Niger", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Nigeria", currency => "Nigerian naira", symbol => "₦", isoCode => "NGN", fractional => "Kobo"],
            [country => "Niue", currency => "New Zealand dollar", symbol => "$", isoCode => "NZD", fractional => "Cent"],
            [country => "Northern Cyprus", currency => "Turkish lira", symbol => "Turkish lira symbol black.svg", isoCode => "TRY", fractional => "Kuruş"],
            [country => "Norway", currency => "Norwegian krone", symbol => "kr", isoCode => "NOK", fractional => "Øre"],
            [country => "Oman", currency => "Omani rial", symbol => "ر.ع.", isoCode => "OMR", fractional => "Baisa"],
            [country => "Pakistan", currency => "Pakistani rupee", symbol => "₨", isoCode => "PKR", fractional => "Paisa"],
            [country => "Palau", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Palestine", currency => "Israeli new shekel", symbol => "₪", isoCode => "ILS", fractional => "Agora"],
            [country => "Palestine", currency => "Jordanian dinar", symbol => "د.ا", isoCode => "JOD", fractional => "Piastre[J]"],
            [country => "Panama", currency => "Panamanian balboa", symbol => "B/.", isoCode => "PAB", fractional => "Centésimo"],
            [country => "Panama", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Papua New Guinea", currency => "Papua New Guinean kina", symbol => "K", isoCode => "PGK", fractional => "Toea"],
            [country => "Paraguay", currency => "Paraguayan guaraní", symbol => "₲", isoCode => "PYG", fractional => "Céntimo"],
            [country => "Peru", currency => "Peruvian nuevo sol", symbol => "S/.", isoCode => "PEN", fractional => "Céntimo"],
            [country => "Philippines", currency => "Philippine peso", symbol => "₱", isoCode => "PHP", fractional => "Centavo"],
            [country => "Pitcairn Islands", currency => "New Zealand dollar", symbol => "$", isoCode => "NZD", fractional => "Cent"],
            [country => "Poland", currency => "Polish złoty", symbol => "zł", isoCode => "PLN", fractional => "Grosz"],
            [country => "Portugal", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Qatar", currency => "Qatari riyal", symbol => "ر.ق", isoCode => "QAR", fractional => "Dirham"],
            [country => "Romania", currency => "Romanian leu", symbol => "lei", isoCode => "RON", fractional => "Ban"],
            [country => "Russia", currency => "Russian ruble", symbol => "RUB", isoCode => "RUB", fractional => "Kopek"],
            [country => "Rwanda", currency => "Rwandan franc", symbol => "Fr", isoCode => "RWF", fractional => "Centime"],
            [country => "Saba", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Sahrawi Republic[M]", currency => "Algerian dinar", symbol => "د.ج", isoCode => "DZD", fractional => "Santeem"],
            [country => "Sahrawi Republic[M]", currency => "Mauritanian ouguiya", symbol => "UM", isoCode => "MRO", fractional => "Khoums"],
            [country => "Sahrawi Republic[M]", currency => "Moroccan dirham", symbol => "د. م.", isoCode => "MAD", fractional => "Centime"],
            [country => "Saint Helena", currency => "Saint Helena pound", symbol => "£", isoCode => "SHP", fractional => "Penny"],
            [country => "Saint Kitts and Nevis", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Saint Lucia", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Saint Vincent and the Grenadines", currency => "East Caribbean dollar", symbol => "$", isoCode => "XCD", fractional => "Cent"],
            [country => "Samoa", currency => "Samoan tālā", symbol => "T", isoCode => "WST", fractional => "Sene"],
            [country => "San Marino", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Saudi Arabia", currency => "Saudi riyal", symbol => "ر.س", isoCode => "SAR", fractional => "Halala"],
            [country => "Senegal", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Serbia", currency => "Serbian dinar", symbol => "дин. or din.", isoCode => "RSD", fractional => "Para"],
            [country => "Seychelles", currency => "Seychellois rupee", symbol => "₨", isoCode => "SCR", fractional => "Cent"],
            [country => "Sierra Leone", currency => "Sierra Leonean leone", symbol => "Le", isoCode => "SLL", fractional => "Cent"],
            [country => "Singapore", currency => "Brunei dollar", symbol => "$", isoCode => "BND", fractional => "Sen"],
            [country => "Singapore", currency => "Singapore dollar", symbol => "$", isoCode => "SGD", fractional => "Cent"],
            [country => "Sint Eustatius", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Sint Maarten", currency => "Netherlands Antillean guilder", symbol => "ƒ", isoCode => "ANG", fractional => "Cent"],
            [country => "Slovakia", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Slovenia", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Solomon Islands", currency => "Solomon Islands dollar", symbol => "$", isoCode => "SBD", fractional => "Cent"],
            [country => "Somalia", currency => "Somali shilling", symbol => "Sh", isoCode => "SOS", fractional => "Cent"],
            [country => "South Africa", currency => "South African rand", symbol => "R", isoCode => "ZAR", fractional => "Cent"],
            [country => "South Georgia and the South Sandwich Islands", currency => "British pound", symbol => "£", isoCode => "GBP", fractional => "Penny"],
            [country => "South Ossetia", currency => "Russian ruble", symbol => "RUB", isoCode => "RUB", fractional => "Kopek"],
            [country => "South Sudan", currency => "South Sudanese pound", symbol => "£", isoCode => "SSP", fractional => "Piastre"],
            [country => "Spain", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Sri Lanka", currency => "Sri Lankan rupee", symbol => "Rs or රු", isoCode => "LKR", fractional => "Cent"],
            [country => "Sudan", currency => "Sudanese pound", symbol => "ج.س.", isoCode => "SDG", fractional => "Piastre"],
            [country => "Suriname", currency => "Surinamese dollar", symbol => "$", isoCode => "SRD", fractional => "Cent"],
            [country => "Swaziland", currency => "Swazi lilangeni", symbol => "L", isoCode => "SZL", fractional => "Cent"],
            [country => "Sweden", currency => "Swedish krona", symbol => "kr", isoCode => "SEK", fractional => "Öre"],
            [country => " Switzerland", currency => "Swiss franc", symbol => "Fr", isoCode => "CHF", fractional => "Rappen[N]"],
            [country => "Syria", currency => "Syrian pound", symbol => "£ or ل.س", isoCode => "SYP", fractional => "Piastre"],
            [country => "São Tomé and Príncipe", currency => "São Tomé and Príncipe dobra", symbol => "Db", isoCode => "STD", fractional => "Cêntimo"],
            [country => "Taiwan", currency => "New Taiwan dollar", symbol => "$", isoCode => "TWD", fractional => "Cent"],
            [country => "Tajikistan", currency => "Tajikistani somoni", symbol => "ЅМ", isoCode => "TJS", fractional => "Diram"],
            [country => "Tanzania", currency => "Tanzanian shilling", symbol => "Sh", isoCode => "TZS", fractional => "Cent"],
            [country => "Thailand", currency => "Thai baht", symbol => "฿", isoCode => "THB", fractional => "Satang"],
            [country => "Togo", currency => "West African CFA franc", symbol => "Fr", isoCode => "XOF", fractional => "Centime"],
            [country => "Tonga", currency => "Tongan paʻanga[O]", symbol => "T$", isoCode => "TOP", fractional => "Seniti"],
            [country => "Transnistria", currency => "Transnistrian ruble", symbol => "р.", isoCode => "PRB[F]", fractional => "Kopek"],
            [country => "Trinidad and Tobago", currency => "Trinidad and Tobago dollar", symbol => "$", isoCode => "TTD", fractional => "Cent"],
            [country => "Tristan da Cunha", currency => "Saint Helena pound", symbol => "£", isoCode => "SHP", fractional => "Penny"],
            [country => "Tunisia", currency => "Tunisian dinar", symbol => "د.ت", isoCode => "TND", fractional => "Millime"],
            [country => "Turkey", currency => "Turkish lira", symbol => "Turkish lira symbol black.svg", isoCode => "TRY", fractional => "Kuruş"],
            [country => "Turkmenistan", currency => "Turkmenistan manat", symbol => "m", isoCode => "TMT", fractional => "Tennesi"],
            [country => "Turks and Caicos Islands", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Tuvalu", currency => "Australian dollar", symbol => "$", isoCode => "AUD", fractional => "Cent"],
            [country => "Uganda", currency => "Ugandan shilling", symbol => "Sh", isoCode => "UGX", fractional => "Cent"],
            [country => "Ukraine", currency => "Ukrainian hryvnia", symbol => "₴", isoCode => "UAH", fractional => "Kopiyka"],
            [country => "Ukraine", currency => "Russian ruble[P]", symbol => "RUB", isoCode => "RUB", fractional => "Kopek"],
            [country => "United Arab Emirates", currency => "United Arab Emirates dirham", symbol => "د.إ", isoCode => "AED", fractional => "Fils"],
            [country => "United Kingdom", currency => "British pound", symbol => "£", isoCode => "GBP", fractional => "Penny"],
            [country => "United States", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"],
            [country => "Uruguay", currency => "Uruguayan peso", symbol => "$", isoCode => "UYU", fractional => "Centésimo"],
            [country => "Uzbekistan", currency => "Uzbekistani som", symbol => "Tenge symbol.svg", isoCode => "UZS", fractional => "Tiyin"],
            [country => "Vatican City", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Venezuela", currency => "Venezuelan bolívar", symbol => "Bs F", isoCode => "VEF", fractional => "Céntimo"],
            [country => "Wallis and Futuna", currency => "CFP franc", symbol => "Fr", isoCode => "XPF", fractional => "Centime"],
            [country => "Yemen", currency => "Yemeni rial", symbol => "﷼", isoCode => "YER", fractional => "Fils"],
            [country => "Zambia", currency => "Zambian kwacha", symbol => "ZK", isoCode => "ZMW", fractional => "Ngwee"],
            [country => "Zimbabwe", currency => "Botswana pula", symbol => "P", isoCode => "BWP", fractional => "Thebe"],
            [country => "Zimbabwe", currency => "British pound", symbol => "£", isoCode => "GBP", fractional => "Penny"],
            [country => "Zimbabwe", currency => "Euro", symbol => "€", isoCode => "EUR", fractional => "Cent"],
            [country => "Zimbabwe", currency => "Indian rupee", symbol => "₹", isoCode => "INR", fractional => "Paisa"],
            [country => "Zimbabwe", currency => "South African rand", symbol => "R", isoCode => "ZAR", fractional => "Cent"],
            [country => "Zimbabwe", currency => "United States dollar", symbol => "$", isoCode => "USD", fractional => "Cent"]
        ];

        public $country     = null;
        public $currency    = null;
        public $symbol      = null;
        public $isoCode     = null;
        public $fractional  = null;

        protected function __construct($country, $currency, $symbol, $isoCode, $fractional)
        {
            $this->country    = $country;
            $this->currency   = $currency;
            $this->symbol     = $symbol;
            $this->isoCode    = $isoCode;
            $this->fractional = $fractional;
        }

        public static function getByIsoCode($isoCode)
        {
            $isoCode = stringEx($isoCode)->toUpper();

            foreach (self::$data as $currency)
                if ($currency[isoCode] == $isoCode)
                    return new Currency(
                        $currency[country],
                        $currency[currency],
                        $currency[symbol],
                        $currency[isoCode],
                        $currency[fractional]
                    );

            return null;
        }

        public static function getAllByIsoCode($isoCode)
        {
            $isoCode = stringEx($isoCode)->toUpper();
            $currencies = Arr();

            foreach (self::$data as $currency)
                if ($currency[isoCode] == $isoCode)
                    $currencies->add(new Currency(
                        $currency[country],
                        $currency[currency],
                        $currency[symbol],
                        $currency[isoCode],
                        $currency[fractional]
                    ));
        }

        public static function getByCurrencyName($currencyName)
        {
            $currencyName = stringEx($currencyName)->toLower();

            foreach (self::$data as $key => $currency)
            {
                if (stringEx($currency[currency])->toLower() == $currencyName)
                    return new Currency(
                        $currency[country],
                        $currency[currency],
                        $currency[symbol],
                        $currency[isoCode],
                        $currency[fractional]
                    );
            }

            return null;
        }

        public static function getAllByCurrencyName($currencyName)
        {
            $currencyName = stringEx($currencyName)->toLower();
            $currencies = Arr();

            foreach (self::$data as $currency)
                if (stringEx($currency[currency])->toLower() == $currencyName)
                    $currencies->add(new Currency(
                        $currency[country],
                        $currency[currency],
                        $currency[symbol],
                        $currency[isoCode],
                        $currency[fractional]
                    ));
        }

        public static function getByCountryName($countryName)
        {
            $countryName = stringEx($countryName)->toLower();

            foreach (self::$data as $currency)
                if (stringEx($currency[country])->toLower() == $countryName)
                    return new Currency(
                        $currency[country],
                        $currency[currency],
                        $currency[symbol],
                        $currency[isoCode],
                        $currency[fractional]
                    );

            return null;
        }

        public static function getAllByCountryName($countryName)
        {
            $countryName = stringEx($countryName)->toLower();
            $currencies = Arr();

            foreach (self::$data as $currency)
                if (stringEx($currency[country])->toLower() == $countryName)
                    $currencies->add(new Currency(
                        $currency[country],
                        $currency[currency],
                        $currency[symbol],
                        $currency[isoCode],
                        $currency[fractional]
                    ));
        }
    }
}