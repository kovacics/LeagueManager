<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable
 */
class Country
{

    public const ALPHA_2 = "alpha2";
    public const ALPHA_3 = "alpha3";
    public const NAME = "name";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"common"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"common"})
     */
    private string $alpha2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"common"})
     */
    private string $alpha3;


    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function setAlpha2(?string $alpha2): self
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAlpha3(): string
    {
        return $this->alpha3;
    }

    /**
     * @param string $alpha3
     */
    public function setAlpha3(string $alpha3): void
    {
        $this->alpha3 = $alpha3;
    }

    public const countries = [

        "AF" => [
            self::NAME => "Afghanistan",
            self::ALPHA_2 => "AF",
            self::ALPHA_3 => "AFG"
        ],
        "AX" => [
            self::NAME => "Åland Islands",
            self::ALPHA_2 => "AX",
            self::ALPHA_3 => "ALA"
        ],
        "AL" => [
            self::NAME => "Albania",
            self::ALPHA_2 => "AL",
            self::ALPHA_3 => "ALB"
        ],
        "DZ" => [
            self::NAME => "Algeria",
            self::ALPHA_2 => "DZ",
            self::ALPHA_3 => "DZA"
        ],
        "AS" => [
            self::NAME => "American Samoa",
            self::ALPHA_2 => "AS",
            self::ALPHA_3 => "ASM"
        ],
        "AD" => [
            self::NAME => "Andorra",
            self::ALPHA_2 => "AD",
            self::ALPHA_3 => "AND"
        ],
        "AO" => [
            self::NAME => "Angola",
            self::ALPHA_2 => "AO",
            self::ALPHA_3 => "AGO"
        ],
        "AI" => [
            self::NAME => "Anguilla",
            self::ALPHA_2 => "AI",
            self::ALPHA_3 => "AIA"
        ],
        "AQ" => [
            self::NAME => "Antarctica",
            self::ALPHA_2 => "AQ",
            self::ALPHA_3 => "ATA"
        ],
        "AG" => [
            self::NAME => "Antigua and Barbuda",
            self::ALPHA_2 => "AG",
            self::ALPHA_3 => "ATG"
        ],
        "AR" => [
            self::NAME => "Argentina",
            self::ALPHA_2 => "AR",
            self::ALPHA_3 => "ARG"
        ],
        "AM" => [
            self::NAME => "Armenia",
            self::ALPHA_2 => "AM",
            self::ALPHA_3 => "ARM"
        ],
        "AW" => [
            self::NAME => "Aruba",
            self::ALPHA_2 => "AW",
            self::ALPHA_3 => "ABW"
        ],
        "AU" => [
            self::NAME => "Australia",
            self::ALPHA_2 => "AU",
            self::ALPHA_3 => "AUS"
        ],
        "AT" => [
            self::NAME => "Austria",
            self::ALPHA_2 => "AT",
            self::ALPHA_3 => "AUT"
        ],
        "AZ" => [
            self::NAME => "Azerbaijan",
            self::ALPHA_2 => "AZ",
            self::ALPHA_3 => "AZE"
        ],
        "BS" => [
            self::NAME => "Bahamas (the)",
            self::ALPHA_2 => "BS",
            self::ALPHA_3 => "BHS"
        ],
        "BH" => [
            self::NAME => "Bahrain",
            self::ALPHA_2 => "BH",
            self::ALPHA_3 => "BHR"
        ],
        "BD" => [
            self::NAME => "Bangladesh",
            self::ALPHA_2 => "BD",
            self::ALPHA_3 => "BGD"
        ],
        "BB" => [
            self::NAME => "Barbados",
            self::ALPHA_2 => "BB",
            self::ALPHA_3 => "BRB"
        ],
        "BY" => [
            self::NAME => "Belarus",
            self::ALPHA_2 => "BY",
            self::ALPHA_3 => "BLR"
        ],
        "BE" => [
            self::NAME => "Belgium",
            self::ALPHA_2 => "BE",
            self::ALPHA_3 => "BEL"
        ],
        "BZ" => [
            self::NAME => "Belize",
            self::ALPHA_2 => "BZ",
            self::ALPHA_3 => "BLZ"
        ],
        "BJ" => [
            self::NAME => "Benin",
            self::ALPHA_2 => "BJ",
            self::ALPHA_3 => "BEN"
        ],
        "BM" => [
            self::NAME => "Bermuda",
            self::ALPHA_2 => "BM",
            self::ALPHA_3 => "BMU"
        ],
        "BT" => [
            self::NAME => "Bhutan",
            self::ALPHA_2 => "BT",
            self::ALPHA_3 => "BTN"
        ],
        "BO" => [
            self::NAME => "Bolivia (Plurinational State of)",
            self::ALPHA_2 => "BO",
            self::ALPHA_3 => "BOL"
        ],
        "BQ" => [
            self::NAME => "Bonaire, Sint Eustatius and Saba",
            self::ALPHA_2 => "BQ",
            self::ALPHA_3 => "BES"
        ],
        "BA" => [
            self::NAME => "Bosnia and Herzegovina",
            self::ALPHA_2 => "BA",
            self::ALPHA_3 => "BIH"
        ],
        "BW" => [
            self::NAME => "Botswana",
            self::ALPHA_2 => "BW",
            self::ALPHA_3 => "BWA"
        ],
        "BV" => [
            self::NAME => "Bouvet Island",
            self::ALPHA_2 => "BV",
            self::ALPHA_3 => "BVT"
        ],
        "BR" => [
            self::NAME => "Brazil",
            self::ALPHA_2 => "BR",
            self::ALPHA_3 => "BRA"
        ],
        "IO" => [
            self::NAME => "British Indian Ocean Territory (the)",
            self::ALPHA_2 => "IO",
            self::ALPHA_3 => "IOT"
        ],
        "BN" => [
            self::NAME => "Brunei Darussalam",
            self::ALPHA_2 => "BN",
            self::ALPHA_3 => "BRN"
        ],
        "BG" => [
            self::NAME => "Bulgaria",
            self::ALPHA_2 => "BG",
            self::ALPHA_3 => "BGR"
        ],
        "BF" => [
            self::NAME => "Burkina Faso",
            self::ALPHA_2 => "BF",
            self::ALPHA_3 => "BFA"
        ],
        "BI" => [
            self::NAME => "Burundi",
            self::ALPHA_2 => "BI",
            self::ALPHA_3 => "BDI"
        ],
        "CV" => [
            self::NAME => "Cabo Verde",
            self::ALPHA_2 => "CV",
            self::ALPHA_3 => "CPV"
        ],
        "KH" => [
            self::NAME => "Cambodia",
            self::ALPHA_2 => "KH",
            self::ALPHA_3 => "KHM"
        ],
        "CM" => [
            self::NAME => "Cameroon",
            self::ALPHA_2 => "CM",
            self::ALPHA_3 => "CMR"
        ],
        "CA" => [
            self::NAME => "Canada",
            self::ALPHA_2 => "CA",
            self::ALPHA_3 => "CAN"
        ],
        "KY" => [
            self::NAME => "Cayman Islands (the)",
            self::ALPHA_2 => "KY",
            self::ALPHA_3 => "CYM"
        ],
        "CF" => [
            self::NAME => "Central African Republic (the)",
            self::ALPHA_2 => "CF",
            self::ALPHA_3 => "CAF"
        ],
        "TD" => [
            self::NAME => "Chad",
            self::ALPHA_2 => "TD",
            self::ALPHA_3 => "TCD"
        ],
        "CL" => [
            self::NAME => "Chile",
            self::ALPHA_2 => "CL",
            self::ALPHA_3 => "CHL"
        ],
        "CN" => [
            self::NAME => "China",
            self::ALPHA_2 => "CN",
            self::ALPHA_3 => "CHN"
        ],
        "CX" => [
            self::NAME => "Christmas Island",
            self::ALPHA_2 => "CX",
            self::ALPHA_3 => "CXR"
        ],
        "CC" => [
            self::NAME => "Cocos (Keeling) Islands (the)",
            self::ALPHA_2 => "CC",
            self::ALPHA_3 => "CCK"
        ],
        "CO" => [
            self::NAME => "Colombia",
            self::ALPHA_2 => "CO",
            self::ALPHA_3 => "COL"
        ],
        "KM" => [
            self::NAME => "Comoros (the)",
            self::ALPHA_2 => "KM",
            self::ALPHA_3 => "COM"
        ],
        "CD" => [
            self::NAME => "Congo (the Democratic Republic of the)",
            self::ALPHA_2 => "CD",
            self::ALPHA_3 => "COD"
        ],
        "CG" => [
            self::NAME => "Congo (the)",
            self::ALPHA_2 => "CG",
            self::ALPHA_3 => "COG"
        ],
        "CK" => [
            self::NAME => "Cook Islands (the)",
            self::ALPHA_2 => "CK",
            self::ALPHA_3 => "COK"
        ],
        "CR" => [
            self::NAME => "Costa Rica",
            self::ALPHA_2 => "CR",
            self::ALPHA_3 => "CRI"
        ],
        "CI" => [
            self::NAME => "Côte d'Ivoire",
            self::ALPHA_2 => "CI",
            self::ALPHA_3 => "CIV"
        ],
        "HR" => [
            self::NAME => "Croatia",
            self::ALPHA_2 => "HR",
            self::ALPHA_3 => "HRV"
        ],
        "CU" => [
            self::NAME => "Cuba",
            self::ALPHA_2 => "CU",
            self::ALPHA_3 => "CUB"
        ],
        "CW" => [
            self::NAME => "Curaçao",
            self::ALPHA_2 => "CW",
            self::ALPHA_3 => "CUW"
        ],
        "CY" => [
            self::NAME => "Cyprus",
            self::ALPHA_2 => "CY",
            self::ALPHA_3 => "CYP"
        ],
        "CZ" => [
            self::NAME => "Czechia",
            self::ALPHA_2 => "CZ",
            self::ALPHA_3 => "CZE"
        ],
        "DK" => [
            self::NAME => "Denmark",
            self::ALPHA_2 => "DK",
            self::ALPHA_3 => "DNK"
        ],
        "DJ" => [
            self::NAME => "Djibouti",
            self::ALPHA_2 => "DJ",
            self::ALPHA_3 => "DJI"
        ],
        "DM" => [
            self::NAME => "Dominica",
            self::ALPHA_2 => "DM",
            self::ALPHA_3 => "DMA"
        ],
        "DO" => [
            self::NAME => "Dominican Republic (the)",
            self::ALPHA_2 => "DO",
            self::ALPHA_3 => "DOM"
        ],
        "EC" => [
            self::NAME => "Ecuador",
            self::ALPHA_2 => "EC",
            self::ALPHA_3 => "ECU"
        ],
        "EG" => [
            self::NAME => "Egypt",
            self::ALPHA_2 => "EG",
            self::ALPHA_3 => "EGY"
        ],
        "SV" => [
            self::NAME => "El Salvador",
            self::ALPHA_2 => "SV",
            self::ALPHA_3 => "SLV"
        ],
        "GQ" => [
            self::NAME => "Equatorial Guinea",
            self::ALPHA_2 => "GQ",
            self::ALPHA_3 => "GNQ"
        ],
        "ER" => [
            self::NAME => "Eritrea",
            self::ALPHA_2 => "ER",
            self::ALPHA_3 => "ERI"
        ],
        "EE" => [
            self::NAME => "Estonia",
            self::ALPHA_2 => "EE",
            self::ALPHA_3 => "EST"
        ],
        "SZ" => [
            self::NAME => "Eswatini",
            self::ALPHA_2 => "SZ",
            self::ALPHA_3 => "SWZ"
        ],
        "ET" => [
            self::NAME => "Ethiopia",
            self::ALPHA_2 => "ET",
            self::ALPHA_3 => "ETH"
        ],
        "FK" => [
            self::NAME => "Falkland Islands (the) [Malvinas]",
            self::ALPHA_2 => "FK",
            self::ALPHA_3 => "FLK"
        ],
        "FO" => [
            self::NAME => "Faroe Islands (the)",
            self::ALPHA_2 => "FO",
            self::ALPHA_3 => "FRO"
        ],
        "FJ" => [
            self::NAME => "Fiji",
            self::ALPHA_2 => "FJ",
            self::ALPHA_3 => "FJI"
        ],
        "FI" => [
            self::NAME => "Finland",
            self::ALPHA_2 => "FI",
            self::ALPHA_3 => "FIN"
        ],
        "FR" => [
            self::NAME => "France",
            self::ALPHA_2 => "FR",
            self::ALPHA_3 => "FRA"
        ],
        "GF" => [
            self::NAME => "French Guiana",
            self::ALPHA_2 => "GF",
            self::ALPHA_3 => "GUF"
        ],
        "PF" => [
            self::NAME => "French Polynesia",
            self::ALPHA_2 => "PF",
            self::ALPHA_3 => "PYF"
        ],
        "TF" => [
            self::NAME => "French Southern Territories (the)",
            self::ALPHA_2 => "TF",
            self::ALPHA_3 => "ATF"
        ],
        "GA" => [
            self::NAME => "Gabon",
            self::ALPHA_2 => "GA",
            self::ALPHA_3 => "GAB"
        ],
        "GM" => [
            self::NAME => "Gambia (the)",
            self::ALPHA_2 => "GM",
            self::ALPHA_3 => "GMB"
        ],
        "GE" => [
            self::NAME => "Georgia",
            self::ALPHA_2 => "GE",
            self::ALPHA_3 => "GEO"
        ],
        "DE" => [
            self::NAME => "Germany",
            self::ALPHA_2 => "DE",
            self::ALPHA_3 => "DEU"
        ],
        "GH" => [
            self::NAME => "Ghana",
            self::ALPHA_2 => "GH",
            self::ALPHA_3 => "GHA"
        ],
        "GI" => [
            self::NAME => "Gibraltar",
            self::ALPHA_2 => "GI",
            self::ALPHA_3 => "GIB"
        ],
        "GR" => [
            self::NAME => "Greece",
            self::ALPHA_2 => "GR",
            self::ALPHA_3 => "GRC"
        ],
        "GL" => [
            self::NAME => "Greenland",
            self::ALPHA_2 => "GL",
            self::ALPHA_3 => "GRL"
        ],
        "GD" => [
            self::NAME => "Grenada",
            self::ALPHA_2 => "GD",
            self::ALPHA_3 => "GRD"
        ],
        "GP" => [
            self::NAME => "Guadeloupe",
            self::ALPHA_2 => "GP",
            self::ALPHA_3 => "GLP"
        ],
        "GU" => [
            self::NAME => "Guam",
            self::ALPHA_2 => "GU",
            self::ALPHA_3 => "GUM"
        ],
        "GT" => [
            self::NAME => "Guatemala",
            self::ALPHA_2 => "GT",
            self::ALPHA_3 => "GTM"
        ],
        "GG" => [
            self::NAME => "Guernsey",
            self::ALPHA_2 => "GG",
            self::ALPHA_3 => "GGY"
        ],
        "GN" => [
            self::NAME => "Guinea",
            self::ALPHA_2 => "GN",
            self::ALPHA_3 => "GIN"
        ],
        "GW" => [
            self::NAME => "Guinea-Bissau",
            self::ALPHA_2 => "GW",
            self::ALPHA_3 => "GNB"
        ],
        "GY" => [
            self::NAME => "Guyana",
            self::ALPHA_2 => "GY",
            self::ALPHA_3 => "GUY"
        ],
        "HT" => [
            self::NAME => "Haiti",
            self::ALPHA_2 => "HT",
            self::ALPHA_3 => "HTI"
        ],
        "HM" => [
            self::NAME => "Heard Island and McDonald Islands",
            self::ALPHA_2 => "HM",
            self::ALPHA_3 => "HMD"
        ],
        "VA" => [
            self::NAME => "Holy See (the)",
            self::ALPHA_2 => "VA",
            self::ALPHA_3 => "VAT"
        ],
        "HN" => [
            self::NAME => "Honduras",
            self::ALPHA_2 => "HN",
            self::ALPHA_3 => "HND"
        ],
        "HK" => [
            self::NAME => "Hong Kong",
            self::ALPHA_2 => "HK",
            self::ALPHA_3 => "HKG"
        ],
        "HU" => [
            self::NAME => "Hungary",
            self::ALPHA_2 => "HU",
            self::ALPHA_3 => "HUN"
        ],
        "IS" => [
            self::NAME => "Iceland",
            self::ALPHA_2 => "IS",
            self::ALPHA_3 => "ISL"
        ],
        "IN" => [
            self::NAME => "India",
            self::ALPHA_2 => "IN",
            self::ALPHA_3 => "IND"
        ],
        "ID" => [
            self::NAME => "Indonesia",
            self::ALPHA_2 => "ID",
            self::ALPHA_3 => "IDN"
        ],
        "IR" => [
            self::NAME => "Iran (Islamic Republic of)",
            self::ALPHA_2 => "IR",
            self::ALPHA_3 => "IRN"
        ],
        "IQ" => [
            self::NAME => "Iraq",
            self::ALPHA_2 => "IQ",
            self::ALPHA_3 => "IRQ"
        ],
        "IE" => [
            self::NAME => "Ireland",
            self::ALPHA_2 => "IE",
            self::ALPHA_3 => "IRL"
        ],
        "IM" => [
            self::NAME => "Isle of Man",
            self::ALPHA_2 => "IM",
            self::ALPHA_3 => "IMN"
        ],
        "IL" => [
            self::NAME => "Israel",
            self::ALPHA_2 => "IL",
            self::ALPHA_3 => "ISR"
        ],
        "IT" => [
            self::NAME => "Italy",
            self::ALPHA_2 => "IT",
            self::ALPHA_3 => "ITA"
        ],
        "JM" => [
            self::NAME => "Jamaica",
            self::ALPHA_2 => "JM",
            self::ALPHA_3 => "JAM"
        ],
        "JP" => [
            self::NAME => "Japan",
            self::ALPHA_2 => "JP",
            self::ALPHA_3 => "JPN"
        ],
        "JE" => [
            self::NAME => "Jersey",
            self::ALPHA_2 => "JE",
            self::ALPHA_3 => "JEY"
        ],
        "JO" => [
            self::NAME => "Jordan",
            self::ALPHA_2 => "JO",
            self::ALPHA_3 => "JOR"
        ],
        "KZ" => [
            self::NAME => "Kazakhstan",
            self::ALPHA_2 => "KZ",
            self::ALPHA_3 => "KAZ"
        ],
        "KE" => [
            self::NAME => "Kenya",
            self::ALPHA_2 => "KE",
            self::ALPHA_3 => "KEN"
        ],
        "KI" => [
            self::NAME => "Kiribati",
            self::ALPHA_2 => "KI",
            self::ALPHA_3 => "KIR"
        ],
        "KP" => [
            self::NAME => "Korea (the Democratic People's Republic of)",
            self::ALPHA_2 => "KP",
            self::ALPHA_3 => "PRK"
        ],
        "KR" => [
            self::NAME => "Korea (the Republic of)",
            self::ALPHA_2 => "KR",
            self::ALPHA_3 => "KOR"
        ],
        "KW" => [
            self::NAME => "Kuwait",
            self::ALPHA_2 => "KW",
            self::ALPHA_3 => "KWT"
        ],
        "KG" => [
            self::NAME => "Kyrgyzstan",
            self::ALPHA_2 => "KG",
            self::ALPHA_3 => "KGZ"
        ],
        "LA" => [
            self::NAME => "Lao People's Democratic Republic (the)",
            self::ALPHA_2 => "LA",
            self::ALPHA_3 => "LAO"
        ],
        "LV" => [
            self::NAME => "Latvia",
            self::ALPHA_2 => "LV",
            self::ALPHA_3 => "LVA"
        ],
        "LB" => [
            self::NAME => "Lebanon",
            self::ALPHA_2 => "LB",
            self::ALPHA_3 => "LBN"
        ],
        "LS" => [
            self::NAME => "Lesotho",
            self::ALPHA_2 => "LS",
            self::ALPHA_3 => "LSO"
        ],
        "LR" => [
            self::NAME => "Liberia",
            self::ALPHA_2 => "LR",
            self::ALPHA_3 => "LBR"
        ],
        "LY" => [
            self::NAME => "Libya",
            self::ALPHA_2 => "LY",
            self::ALPHA_3 => "LBY"
        ],
        "LI" => [
            self::NAME => "Liechtenstein",
            self::ALPHA_2 => "LI",
            self::ALPHA_3 => "LIE"
        ],
        "LT" => [
            self::NAME => "Lithuania",
            self::ALPHA_2 => "LT",
            self::ALPHA_3 => "LTU"
        ],
        "LU" => [
            self::NAME => "Luxembourg",
            self::ALPHA_2 => "LU",
            self::ALPHA_3 => "LUX"
        ],
        "MO" => [
            self::NAME => "Macao",
            self::ALPHA_2 => "MO",
            self::ALPHA_3 => "MAC"
        ],
        "MK" => [
            self::NAME => "Republic of North Macedonia",
            self::ALPHA_2 => "MK",
            self::ALPHA_3 => "MKD"
        ],
        "MG" => [
            self::NAME => "Madagascar",
            self::ALPHA_2 => "MG",
            self::ALPHA_3 => "MDG"
        ],
        "MW" => [
            self::NAME => "Malawi",
            self::ALPHA_2 => "MW",
            self::ALPHA_3 => "MWI"
        ],
        "MY" => [
            self::NAME => "Malaysia",
            self::ALPHA_2 => "MY",
            self::ALPHA_3 => "MYS"
        ],
        "MV" => [
            self::NAME => "Maldives",
            self::ALPHA_2 => "MV",
            self::ALPHA_3 => "MDV"
        ],
        "ML" => [
            self::NAME => "Mali",
            self::ALPHA_2 => "ML",
            self::ALPHA_3 => "MLI"
        ],
        "MT" => [
            self::NAME => "Malta",
            self::ALPHA_2 => "MT",
            self::ALPHA_3 => "MLT"
        ],
        "MH" => [
            self::NAME => "Marshall Islands (the)",
            self::ALPHA_2 => "MH",
            self::ALPHA_3 => "MHL"
        ],
        "MQ" => [
            self::NAME => "Martinique",
            self::ALPHA_2 => "MQ",
            self::ALPHA_3 => "MTQ"
        ],
        "MR" => [
            self::NAME => "Mauritania",
            self::ALPHA_2 => "MR",
            self::ALPHA_3 => "MRT"
        ],
        "MU" => [
            self::NAME => "Mauritius",
            self::ALPHA_2 => "MU",
            self::ALPHA_3 => "MUS"
        ],
        "YT" => [
            self::NAME => "Mayotte",
            self::ALPHA_2 => "YT",
            self::ALPHA_3 => "MYT"
        ],
        "MX" => [
            self::NAME => "Mexico",
            self::ALPHA_2 => "MX",
            self::ALPHA_3 => "MEX"
        ],
        "FM" => [
            self::NAME => "Micronesia (Federated States of)",
            self::ALPHA_2 => "FM",
            self::ALPHA_3 => "FSM"
        ],
        "MD" => [
            self::NAME => "Moldova (the Republic of)",
            self::ALPHA_2 => "MD",
            self::ALPHA_3 => "MDA"
        ],
        "MC" => [
            self::NAME => "Monaco",
            self::ALPHA_2 => "MC",
            self::ALPHA_3 => "MCO"
        ],
        "MN" => [
            self::NAME => "Mongolia",
            self::ALPHA_2 => "MN",
            self::ALPHA_3 => "MNG"
        ],
        "ME" => [
            self::NAME => "Montenegro",
            self::ALPHA_2 => "ME",
            self::ALPHA_3 => "MNE"
        ],
        "MS" => [
            self::NAME => "Montserrat",
            self::ALPHA_2 => "MS",
            self::ALPHA_3 => "MSR"
        ],
        "MA" => [
            self::NAME => "Morocco",
            self::ALPHA_2 => "MA",
            self::ALPHA_3 => "MAR"
        ],
        "MZ" => [
            self::NAME => "Mozambique",
            self::ALPHA_2 => "MZ",
            self::ALPHA_3 => "MOZ"
        ],
        "MM" => [
            self::NAME => "Myanmar",
            self::ALPHA_2 => "MM",
            self::ALPHA_3 => "MMR"
        ],
        "NA" => [
            self::NAME => "Namibia",
            self::ALPHA_2 => "NA",
            self::ALPHA_3 => "NAM"
        ],
        "NR" => [
            self::NAME => "Nauru",
            self::ALPHA_2 => "NR",
            self::ALPHA_3 => "NRU"
        ],
        "NP" => [
            self::NAME => "Nepal",
            self::ALPHA_2 => "NP",
            self::ALPHA_3 => "NPL"
        ],
        "NL" => [
            self::NAME => "Netherlands (the)",
            self::ALPHA_2 => "NL",
            self::ALPHA_3 => "NLD"
        ],
        "NC" => [
            self::NAME => "New Caledonia",
            self::ALPHA_2 => "NC",
            self::ALPHA_3 => "NCL"
        ],
        "NZ" => [
            self::NAME => "New Zealand",
            self::ALPHA_2 => "NZ",
            self::ALPHA_3 => "NZL"
        ],
        "NI" => [
            self::NAME => "Nicaragua",
            self::ALPHA_2 => "NI",
            self::ALPHA_3 => "NIC"
        ],
        "NE" => [
            self::NAME => "Niger (the)",
            self::ALPHA_2 => "NE",
            self::ALPHA_3 => "NER"
        ],
        "NG" => [
            self::NAME => "Nigeria",
            self::ALPHA_2 => "NG",
            self::ALPHA_3 => "NGA"
        ],
        "NU" => [
            self::NAME => "Niue",
            self::ALPHA_2 => "NU",
            self::ALPHA_3 => "NIU"
        ],
        "NF" => [
            self::NAME => "Norfolk Island",
            self::ALPHA_2 => "NF",
            self::ALPHA_3 => "NFK"
        ],
        "MP" => [
            self::NAME => "Northern Mariana Islands (the)",
            self::ALPHA_2 => "MP",
            self::ALPHA_3 => "MNP"
        ],
        "NO" => [
            self::NAME => "Norway",
            self::ALPHA_2 => "NO",
            self::ALPHA_3 => "NOR"
        ],
        "OM" => [
            self::NAME => "Oman",
            self::ALPHA_2 => "OM",
            self::ALPHA_3 => "OMN"
        ],
        "PK" => [
            self::NAME => "Pakistan",
            self::ALPHA_2 => "PK",
            self::ALPHA_3 => "PAK"
        ],
        "PW" => [
            self::NAME => "Palau",
            self::ALPHA_2 => "PW",
            self::ALPHA_3 => "PLW"
        ],
        "PS" => [
            self::NAME => "Palestine, State of",
            self::ALPHA_2 => "PS",
            self::ALPHA_3 => "PSE"
        ],
        "PA" => [
            self::NAME => "Panama",
            self::ALPHA_2 => "PA",
            self::ALPHA_3 => "PAN"
        ],
        "PG" => [
            self::NAME => "Papua New Guinea",
            self::ALPHA_2 => "PG",
            self::ALPHA_3 => "PNG"
        ],
        "PY" => [
            self::NAME => "Paraguay",
            self::ALPHA_2 => "PY",
            self::ALPHA_3 => "PRY"
        ],
        "PE" => [
            self::NAME => "Peru",
            self::ALPHA_2 => "PE",
            self::ALPHA_3 => "PER"
        ],
        "PH" => [
            self::NAME => "Philippines (the)",
            self::ALPHA_2 => "PH",
            self::ALPHA_3 => "PHL"
        ],
        "PN" => [
            self::NAME => "Pitcairn",
            self::ALPHA_2 => "PN",
            self::ALPHA_3 => "PCN"
        ],
        "PL" => [
            self::NAME => "Poland",
            self::ALPHA_2 => "PL",
            self::ALPHA_3 => "POL"
        ],
        "PT" => [
            self::NAME => "Portugal",
            self::ALPHA_2 => "PT",
            self::ALPHA_3 => "PRT"
        ],
        "PR" => [
            self::NAME => "Puerto Rico",
            self::ALPHA_2 => "PR",
            self::ALPHA_3 => "PRI"
        ],
        "QA" => [
            self::NAME => "Qatar",
            self::ALPHA_2 => "QA",
            self::ALPHA_3 => "QAT"
        ],
        "RE" => [
            self::NAME => "Réunion",
            self::ALPHA_2 => "RE",
            self::ALPHA_3 => "REU"
        ],
        "RO" => [
            self::NAME => "Romania",
            self::ALPHA_2 => "RO",
            self::ALPHA_3 => "ROU"
        ],
        "RU" => [
            self::NAME => "Russian Federation (the)",
            self::ALPHA_2 => "RU",
            self::ALPHA_3 => "RUS"
        ],
        "RW" => [
            self::NAME => "Rwanda",
            self::ALPHA_2 => "RW",
            self::ALPHA_3 => "RWA"
        ],
        "BL" => [
            self::NAME => "Saint Barthélemy",
            self::ALPHA_2 => "BL",
            self::ALPHA_3 => "BLM"
        ],
        "SH" => [
            self::NAME => "Saint Helena, Ascension and Tristan da Cunha",
            self::ALPHA_2 => "SH",
            self::ALPHA_3 => "SHN"
        ],
        "KN" => [
            self::NAME => "Saint Kitts and Nevis",
            self::ALPHA_2 => "KN",
            self::ALPHA_3 => "KNA"
        ],
        "LC" => [
            self::NAME => "Saint Lucia",
            self::ALPHA_2 => "LC",
            self::ALPHA_3 => "LCA"
        ],
        "MF" => [
            self::NAME => "Saint Martin (French part)",
            self::ALPHA_2 => "MF",
            self::ALPHA_3 => "MAF"
        ],
        "PM" => [
            self::NAME => "Saint Pierre and Miquelon",
            self::ALPHA_2 => "PM",
            self::ALPHA_3 => "SPM"
        ],
        "VC" => [
            self::NAME => "Saint Vincent and the Grenadines",
            self::ALPHA_2 => "VC",
            self::ALPHA_3 => "VCT"
        ],
        "WS" => [
            self::NAME => "Samoa",
            self::ALPHA_2 => "WS",
            self::ALPHA_3 => "WSM"
        ],
        "SM" => [
            self::NAME => "San Marino",
            self::ALPHA_2 => "SM",
            self::ALPHA_3 => "SMR"
        ],
        "ST" => [
            self::NAME => "Sao Tome and Principe",
            self::ALPHA_2 => "ST",
            self::ALPHA_3 => "STP"
        ],
        "SA" => [
            self::NAME => "Saudi Arabia",
            self::ALPHA_2 => "SA",
            self::ALPHA_3 => "SAU"
        ],
        "SN" => [
            self::NAME => "Senegal",
            self::ALPHA_2 => "SN",
            self::ALPHA_3 => "SEN"
        ],
        "RS" => [
            self::NAME => "Serbia",
            self::ALPHA_2 => "RS",
            self::ALPHA_3 => "SRB"
        ],
        "SC" => [
            self::NAME => "Seychelles",
            self::ALPHA_2 => "SC",
            self::ALPHA_3 => "SYC"
        ],
        "SL" => [
            self::NAME => "Sierra Leone",
            self::ALPHA_2 => "SL",
            self::ALPHA_3 => "SLE"
        ],
        "SG" => [
            self::NAME => "Singapore",
            self::ALPHA_2 => "SG",
            self::ALPHA_3 => "SGP"
        ],
        "SX" => [
            self::NAME => "Sint Maarten (Dutch part)",
            self::ALPHA_2 => "SX",
            self::ALPHA_3 => "SXM"
        ],
        "SK" => [
            self::NAME => "Slovakia",
            self::ALPHA_2 => "SK",
            self::ALPHA_3 => "SVK"
        ],
        "SI" => [
            self::NAME => "Slovenia",
            self::ALPHA_2 => "SI",
            self::ALPHA_3 => "SVN"
        ],
        "SB" => [
            self::NAME => "Solomon Islands",
            self::ALPHA_2 => "SB",
            self::ALPHA_3 => "SLB"
        ],
        "SO" => [
            self::NAME => "Somalia",
            self::ALPHA_2 => "SO",
            self::ALPHA_3 => "SOM"
        ],
        "ZA" => [
            self::NAME => "South Africa",
            self::ALPHA_2 => "ZA",
            self::ALPHA_3 => "ZAF"
        ],
        "GS" => [
            self::NAME => "South Georgia and the South Sandwich Islands",
            self::ALPHA_2 => "GS",
            self::ALPHA_3 => "SGS"
        ],
        "SS" => [
            self::NAME => "South Sudan",
            self::ALPHA_2 => "SS",
            self::ALPHA_3 => "SSD"
        ],
        "ES" => [
            self::NAME => "Spain",
            self::ALPHA_2 => "ES",
            self::ALPHA_3 => "ESP"
        ],
        "LK" => [
            self::NAME => "Sri Lanka",
            self::ALPHA_2 => "LK",
            self::ALPHA_3 => "LKA"
        ],
        "SD" => [
            self::NAME => "Sudan (the)",
            self::ALPHA_2 => "SD",
            self::ALPHA_3 => "SDN"
        ],
        "SR" => [
            self::NAME => "Suriname",
            self::ALPHA_2 => "SR",
            self::ALPHA_3 => "SUR"
        ],
        "SJ" => [
            self::NAME => "Svalbard and Jan Mayen",
            self::ALPHA_2 => "SJ",
            self::ALPHA_3 => "SJM"
        ],
        "SE" => [
            self::NAME => "Sweden",
            self::ALPHA_2 => "SE",
            self::ALPHA_3 => "SWE"
        ],
        "CH" => [
            self::NAME => "Switzerland",
            self::ALPHA_2 => "CH",
            self::ALPHA_3 => "CHE"
        ],
        "SY" => [
            self::NAME => "Syrian Arab Republic",
            self::ALPHA_2 => "SY",
            self::ALPHA_3 => "SYR"
        ],
        "TW" => [
            self::NAME => "Taiwan (Province of China)",
            self::ALPHA_2 => "TW",
            self::ALPHA_3 => "TWN"
        ],
        "TJ" => [
            self::NAME => "Tajikistan",
            self::ALPHA_2 => "TJ",
            self::ALPHA_3 => "TJK"
        ],
        "TZ" => [
            self::NAME => "Tanzania, United Republic of",
            self::ALPHA_2 => "TZ",
            self::ALPHA_3 => "TZA"
        ],
        "TH" => [
            self::NAME => "Thailand",
            self::ALPHA_2 => "TH",
            self::ALPHA_3 => "THA"
        ],
        "TL" => [
            self::NAME => "Timor-Leste",
            self::ALPHA_2 => "TL",
            self::ALPHA_3 => "TLS"
        ],
        "TG" => [
            self::NAME => "Togo",
            self::ALPHA_2 => "TG",
            self::ALPHA_3 => "TGO"
        ],
        "TK" => [
            self::NAME => "Tokelau",
            self::ALPHA_2 => "TK",
            self::ALPHA_3 => "TKL"
        ],
        "TO" => [
            self::NAME => "Tonga",
            self::ALPHA_2 => "TO",
            self::ALPHA_3 => "TON"
        ],
        "TT" => [
            self::NAME => "Trinidad and Tobago",
            self::ALPHA_2 => "TT",
            self::ALPHA_3 => "TTO"
        ],
        "TN" => [
            self::NAME => "Tunisia",
            self::ALPHA_2 => "TN",
            self::ALPHA_3 => "TUN"
        ],
        "TR" => [
            self::NAME => "Turkey",
            self::ALPHA_2 => "TR",
            self::ALPHA_3 => "TUR"
        ],
        "TM" => [
            self::NAME => "Turkmenistan",
            self::ALPHA_2 => "TM",
            self::ALPHA_3 => "TKM"
        ],
        "TC" => [
            self::NAME => "Turks and Caicos Islands (the)",
            self::ALPHA_2 => "TC",
            self::ALPHA_3 => "TCA"
        ],
        "TV" => [
            self::NAME => "Tuvalu",
            self::ALPHA_2 => "TV",
            self::ALPHA_3 => "TUV"
        ],
        "UG" => [
            self::NAME => "Uganda",
            self::ALPHA_2 => "UG",
            self::ALPHA_3 => "UGA"
        ],
        "UA" => [
            self::NAME => "Ukraine",
            self::ALPHA_2 => "UA",
            self::ALPHA_3 => "UKR"
        ],
        "AE" => [
            self::NAME => "United Arab Emirates (the)",
            self::ALPHA_2 => "AE",
            self::ALPHA_3 => "ARE"
        ],
        "GB" => [
            self::NAME => "United Kingdom of Great Britain and Northern Ireland (the)",
            self::ALPHA_2 => "GB",
            self::ALPHA_3 => "GBR"
        ],
        "UM" => [
            self::NAME => "United States Minor Outlying Islands (the)",
            self::ALPHA_2 => "UM",
            self::ALPHA_3 => "UMI"
        ],
        "US" => [
            self::NAME => "United States of America (the)",
            self::ALPHA_2 => "US",
            self::ALPHA_3 => "USA"
        ],
        "UY" => [
            self::NAME => "Uruguay",
            self::ALPHA_2 => "UY",
            self::ALPHA_3 => "URY"
        ],
        "UZ" => [
            self::NAME => "Uzbekistan",
            self::ALPHA_2 => "UZ",
            self::ALPHA_3 => "UZB"
        ],
        "VU" => [
            self::NAME => "Vanuatu",
            self::ALPHA_2 => "VU",
            self::ALPHA_3 => "VUT"
        ],
        "VE" => [
            self::NAME => "Venezuela (Bolivarian Republic of)",
            self::ALPHA_2 => "VE",
            self::ALPHA_3 => "VEN"
        ],
        "VN" => [
            self::NAME => "Viet Nam",
            self::ALPHA_2 => "VN",
            self::ALPHA_3 => "VNM"
        ],
        "VG" => [
            self::NAME => "Virgin Islands (British)",
            self::ALPHA_2 => "VG",
            self::ALPHA_3 => "VGB"
        ],
        "VI" => [
            self::NAME => "Virgin Islands (U.S.)",
            self::ALPHA_2 => "VI",
            self::ALPHA_3 => "VIR"
        ],
        "WF" => [
            self::NAME => "Wallis and Futuna",
            self::ALPHA_2 => "WF",
            self::ALPHA_3 => "WLF"
        ],
        "EH" => [
            self::NAME => "Western Sahara",
            self::ALPHA_2 => "EH",
            self::ALPHA_3 => "ESH"
        ],
        "YE" => [
            self::NAME => "Yemen",
            self::ALPHA_2 => "YE",
            self::ALPHA_3 => "YEM"
        ],
        "ZM" => [
            self::NAME => "Zambia",
            self::ALPHA_2 => "ZM",
            self::ALPHA_3 => "ZMB"
        ],
        "ZW" => [
            self::NAME => "Zimbabwe",
            self::ALPHA_2 => "ZW",
            self::ALPHA_3 => "ZWE"
        ],


    ];
}
