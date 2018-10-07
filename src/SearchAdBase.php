<?php

namespace Drupal\adsense;

/**
 * Class SearchAdBase.
 */
abstract class SearchAdBase extends AdsenseAdBase {

  /**
   * Supply available encodings for the search configuration forms.
   *
   * @return array
   *   encoding options with the key used by Google and its description.
   */
  static public function adsenseEncodings() {
    return [
      'windows-1256' => t('Arabic (Windows-1256)'),
      'cp852'        => t('Central European (CP852)'),
      'windows-1250' => t('Central European (Windows-1250)'),
      'ISO-8859-2'   => t('Central European Latin-2 (ISO-8859-2)'),
      'GB18030'      => t('Chinese Simplified (GB18030)'),
      'GB2312'       => t('Chinese Simplified (GB2312)'),
      'big5'         => t('Chinese Traditional (Big5)'),
      'ISO-8859-5'   => t('Cyrillic (ISO-8859-5)'),
      'KOI8-R'       => t('Cyrillic (KOI8-R)'),
      'windows-1251' => t('Cyrillic (Windows-1251)'),
      'cp-866'       => t('Cyrillic/Russian (CP-866)'),
      'ISO-8859-7'   => t('Greek (ISO-8859-7)'),
      'ISO-8859-8-I' => t('Hebrew (ISO-8859-8-I)'),
      'windows-1255' => t('Hebrew (Windows-1255)'),
      'EUC-JP'       => t('Japanese (EUC-JP)'),
      'ISO-2022-JP'  => t('Japanese (ISO-2022-JP)'),
      'Shift_JIS'    => t('Japanese (Shift_JIS)'),
      'EUC-KR'       => t('Korean (EUC-KR)'),
      'ISO-8859-10'  => t('Nordic Latin-6 (ISO-8859-10)'),
      'ISO-8859-3'   => t('South European Latin-3 (ISO-8859-3)'),
      'windows-874'  => t('Thai (Windows-874)'),
      'ISO-8859-9'   => t('Turkish Latin-5 (ISO-8859-9)'),
      'windows-1254' => t('Turkish (Windows-1254)'),
      'UTF-8'        => t('Unicode (UTF-8)'),
      'windows-1258' => t('Vietnamese (Windows-1258)'),
      'windows-1252' => t('Western (Windows-1252)'),
      'ISO-8859-1'   => t('West European Latin-1 (ISO-8859-1)'),
      'ISO-8859-15'  => t('West European Latin-9 (ISO-8859-15)'),
    ];
  }

  /**
   * Supply available countries for the search configuration forms.
   *
   * @return array
   *   array of countries with the key used by Google and its description.
   */
  static public function adsenseCountries() {
    return [
      // @codingStandardsIgnoreStart
      'www.google.com.au' => t('Australia'),
      'www.google.at'     => t('Austria'),
      'www.google.be'     => t('Belgium'),
      'www.google.com.br' => t('Brazil'),
      'www.google.ca'     => t('Canada'),
      'www.google.cn'     => t('China'),
      'www.google.dk'     => t('Denmark'),
      'www.google.fi'     => t('Finland'),
      'www.google.fr'     => t('France'),
      'www.google.de'     => t('Germany'),
      'www.google.com.hk' => t('Hong Kong'),
      'www.google.it'     => t('Italy'),
      'www.google.co.jp'  => t('Japan'),
      'www.google.nl'     => t('Netherlands'),
      'www.google.no'     => t('Norway'),
      'www.google.pt'     => t('Portugal'),
      'www.google.com.sg' => t('Singapore'),
      'www.google.co.kr'  => t('South Korea'),
      'www.google.es'     => t('Spain'),
      'www.google.se'     => t('Sweden'),
      'www.google.ch'     => t('Switzerland'),
      'www.google.com.tw' => t('Taiwan'),
      'www.google.co.uk'  => t('United Kingdom'),
      'www.google.com'    => t('United States'),
      'www.google.com.af' => t('Afghanistan'),
      'www.google.al'     => t('Albania'),
      'www.google.dz'     => t('Algeria'),
      'www.google.as'     => t('American Samoa'),
      'www.google.ad'     => t('Andorra'),
      'www.google.co.ao'  => t('Angola'),
      'www.google.com.ai' => t('Anguilla'),
    // 'www.google.com'    => t('Antarctica'),
      'www.google.com.ag' => t('Antigua and Barbuda'),
      'www.google.com.ar' => t('Argentina'),
      'www.google.am'     => t('Armenia'),
    // 'www.google.com'    => t('Aruba'),
      'www.google.az'     => t('Azerbaijan'),
      'www.google.bs'     => t('Bahamas'),
      'www.google.com.bh' => t('Bahrain'),
      'www.google.com.bd' => t('Bangladesh'),
    // 'www.google.com'    => t('Barbados'),
      'www.google.by'     => t('Belarus'),
      'www.google.com.bz' => t('Belize'),
      'www.google.bj'     => t('Benin'),
    // 'www.google.com'    => t('Bermuda'),
      'www.google.bt'     => t('Bhutan'),
      'www.google.com.bo' => t('Bolivia'),
      'www.google.ba'     => t('Bosnia and Herzegovina'),
      'www.google.co.bw'  => t('Botswana'),
    // 'www.google.com'    => t('Bouvet Island'),
    // 'www.google.com'    => t('British Indian Ocean Territory'),
      'www.google.com.bn' => t('Brunei'),
      'www.google.bg'     => t('Bulgaria'),
      'www.google.bf'     => t('Burkina Faso'),
      'www.google.bi'     => t('Burundi'),
      'www.google.com.kh' => t('Cambodia'),
      'www.google.cm'     => t('Cameroon'),
      'www.google.cv'     => t('Cape Verde'),
    // 'www.google.com'    => t('Cayman Islands'),
      'www.google.cf'     => t('Central African Republic'),
      'www.google.td'     => t('Chad'),
      'www.google.cl'     => t('Chile'),
    // 'www.google.com'    => t('Christmas Island'),
      'www.google.cc'     => t('Cocos (Keeling) Islands'),
      'www.google.com.co' => t('Colombia'),
    // 'www.google.com'    => t('Comoros'),
      'www.google.cg'     => t('Congo (Republic)'),
      'www.google.cd'     => t('Congo (DRC)'),
      'www.google.co.ck'  => t('Cook Islands'),
      'www.google.co.cr'  => t('Costa Rica'),
      'www.google.ci'     => t("Cote d'Ivoire"),
      'www.google.hr'     => t('Croatia'),
      'www.google.com.cu' => t('Cuba'),
      'www.google.com.cy' => t('Cyprus'),
      'www.google.cz'     => t('Czech Republic'),
      'www.google.dj'     => t('Djibouti'),
      'www.google.dm'     => t('Dominica'),
      'www.google.com.do' => t('Dominican Republic'),
      'www.google.tl'     => t('Timor-Leste'),
      'www.google.com.ec' => t('Ecuador'),
      'www.google.com.eg' => t('Egypt'),
      'www.google.com.sv' => t('El Salvador'),
    // 'www.google.com'    => t('Equatorial Guinea'),
    // 'www.google.com'    => t('Eritrea'),
      'www.google.ee'     => t('Estonia'),
      'www.google.com.et' => t('Ethiopia'),
    // 'www.google.com'    => t('Falkland Islands (Islas Malvinas)'),
    // 'www.google.com'    => t('Faroe Islands'),
      'www.google.com.fj' => t('Fiji'),
      'www.google.gf'     => t('French Guiana'),
    // 'www.google.com'    => t('French Polynesia'),
    // 'www.google.com'    => t('French Southern Territories'),
      'www.google.ga'     => t('Gabon'),
      'www.google.gm'     => t('Gambia'),
      'www.google.ge'     => t('Georgia'),
      'www.google.com.gh' => t('Ghana'),
      'www.google.com.gi' => t('Gibraltar'),
      'www.google.gr'     => t('Greece'),
      'www.google.gl'     => t('Greenland'),
    // 'www.google.com'    => t('Grenada'),
      'www.google.gp'     => t('Guadeloupe'),
    // 'www.google.com'    => t('Guam'),
      'www.google.com.gt' => t('Guatemala'),
    // 'www.google.com'    => t('Guinea'),
    // 'www.google.com'    => t('Guinea-Bissau'),
      'www.google.gy'     => t('Guyana'),
      'www.google.ht'     => t('Haiti'),
    // 'www.google.com'    => t('Heard and McDonald Islands'),
      'www.google.hn'     => t('Honduras'),
      'www.google.hu'     => t('Hungary'),
      'www.google.is'     => t('Iceland'),
      'www.google.co.in'  => t('India'),
      'www.google.co.id'  => t('Indonesia'),
    // 'www.google.ir'     => t('Iran'),
      'www.google.iq'     => t('Iraq'),
      'www.google.ie'     => t('Ireland'),
      'www.google.co.il'  => t('Israel'),
      'www.google.com.jm' => t('Jamaica'),
      'www.google.jo'     => t('Jordan'),
      'www.google.kz'     => t('Kazakhstan'),
      'www.google.co.ke'  => t('Kenya'),
      'www.google.ki'     => t('Kiribati'),
      'www.google.com.kw' => t('Kuwait'),
      'www.google.kg'     => t('Kyrgyzstan'),
      'www.google.la'     => t('Laos'),
      'www.google.lv'     => t('Latvia'),
      'www.google.com.lb' => t('Lebanon'),
      'www.google.co.ls'  => t('Lesotho'),
    // 'www.google.com'    => t('Liberia'),
      'www.google.com.ly' => t('Libya'),
      'www.google.li'     => t('Liechtenstein'),
      'www.google.lt'     => t('Lithuania'),
      'www.google.lu'     => t('Luxembourg'),
    // 'www.google.com'    => t('Macau'),
      'www.google.mk'     => t('Macedonia (FYROM)'),
      'www.google.mg'     => t('Madagascar'),
      'www.google.mw'     => t('Malawi'),
      'www.google.com.my' => t('Malaysia'),
      'www.google.mv'     => t('Maldives'),
      'www.google.ml'     => t('Mali'),
      'www.google.com.mt' => t('Malta'),
    // 'www.google.com'    => t('Marshall Islands'),
    // 'www.google.com'    => t('Martinique'),
    // 'www.google.com'    => t('Mauritania'),
      'www.google.mu'     => t('Mauritius'),
    // 'www.google.com'    => t('Mayotte'),
      'www.google.com.mx' => t('Mexico'),
      'www.google.fm'     => t('Micronesia'),
      'www.google.md'     => t('Moldova'),
    // 'www.google.com'    => t('Monaco'),
      'www.google.mn'     => t('Mongolia'),
      'www.google.me'     => t('Montenegro'),
      'www.google.ms'     => t('Montserrat'),
      'www.google.co.ma'  => t('Morocco'),
      'www.google.co.mz'  => t('Mozambique'),
      'www.google.com.mm' => t('Myanmar'),
      'www.google.com.na' => t('Namibia'),
      'www.google.nr'     => t('Nauru'),
      'www.google.com.np' => t('Nepal'),
    // 'www.google.com'    => t('Netherlands Antilles'),
    // 'www.google.com'    => t('New Caledonia'),
      'www.google.co.nz'  => t('New Zealand'),
      'www.google.com.ni' => t('Nicaragua'),
      'www.google.ne'     => t('Niger'),
      'www.google.com.ng' => t('Nigeria'),
      'www.google.nu'     => t('Niue'),
      'www.google.com.nf' => t('Norfolk Island'),
    // 'www.google.com'    => t('Northern Mariana Islands'),
    // 'www.google.com'    => t('North Korea'),
      'www.google.com.om' => t('Oman'),
      'www.google.com.pk' => t('Pakistan'),
    // 'www.google.com'    => t('Palau'),
      'www.google.ps'     => t('Palestine'),
      'www.google.com.pa' => t('Panama'),
      'www.google.com.pg' => t('Papua New Guinea'),
      'www.google.com.py' => t('Paraguay'),
      'www.google.com.pe' => t('Peru'),
      'www.google.com.ph' => t('Philippines'),
      'www.google.pn'     => t('Pitcairn Islands'),
      'www.google.pl'     => t('Poland'),
      'www.google.com.pr' => t('Puerto Rico'),
      'www.google.com.qa' => t('Qatar'),
    // 'www.google.com'    => t('Reunion'),
      'www.google.ro'     => t('Romania'),
      'www.google.ru'     => t('Russia'),
      'www.google.rw'     => t('Rwanda'),
    // 'www.google.com'    => t('Saint Kitts and Nevis'),
      'www.google.com.lc' => t('Saint Lucia'),
      'www.google.com.vc' => t('Saint Vincent and the Grenadines'),
      'www.google.ws'     => t('Samoa'),
      'www.google.sm'     => t('San Marino'),
      'www.google.st'     => t('Sao Tome and Principe'),
      'www.google.com.sa' => t('Saudi Arabia'),
      'www.google.sn'     => t('Senegal'),
      'www.google.rs'     => t('Serbia'),
      'www.google.sc'     => t('Seychelles'),
      'www.google.com.sl' => t('Sierra Leone'),
      'www.google.sk'     => t('Slovakia'),
      'www.google.si'     => t('Slovenia'),
      'www.google.com.sb' => t('Solomon Islands'),
      'www.google.so'     => t('Somalia'),
      'www.google.co.za'  => t('South Africa'),
    // 'www.google.com'    => t('South Georgia and the South Sandwich Islands'),
      'www.google.lk'     => t('Sri Lanka'),
      'www.google.sh'     => t('Saint Helena'),
    // 'www.google.com'    => t('Saint Pierre and Miquelon'),
    // 'www.google.com'    => t('Sudan'),
    // 'www.google.com'    => t('Suriname'),
    // 'www.google.com'    => t('Svalbard and Jan Mayen'),
    // 'www.google.com'    => t('Swaziland'),
    // 'www.google.com'    => t('Syria'),
      'www.google.com.tj' => t('Tajikistan'),
      'www.google.co.tz'  => t('Tanzania'),
      'www.google.co.th'  => t('Thailand'),
      'www.google.tg'     => t('Togo'),
      'www.google.tk'     => t('Tokelau'),
      'www.google.to'     => t('Tonga'),
      'www.google.tt'     => t('Trinidad and Tobago'),
      'www.google.tn'     => t('Tunisia'),
      'www.google.com.tr' => t('Turkey'),
      'www.google.tm'     => t('Turkmenistan'),
    // 'www.google.com'    => t('Turks and Caicos Islands'),
    // 'www.google.com'    => t('Tuvalu'),
      'www.google.co.ug'  => t('Uganda'),
      'www.google.com.ua' => t('Ukraine'),
      'www.google.ae'     => t('United Arab Emirates'),
    // 'www.google.com'    => t('U.S. Minor Outlying Islands'),
      'www.google.com.uy' => t('Uruguay'),
      'www.google.co.uz'  => t('Uzbekistan'),
      'www.google.vu'     => t('Vanuatu'),
    // 'www.google.com'    => t('Vatican City'),
      'www.google.co.ve'  => t('Venezuela'),
      'www.google.com.vn' => t('Vietnam'),
      'www.google.vg'     => t('British Virgin Islands'),
      'www.google.co.vi'  => t('U.S. Virgin Islands'),
    // 'www.google.com'    => t('Wallis and Futuna'),
    // 'www.google.com'    => t('Western Sahara'),
    // 'www.google.com'    => t('Yemen'),
      'www.google.co.zm'  => t('Zambia'),
      'www.google.co.zw'  => t('Zimbabwe'),
      // @codingStandardsIgnoreEnd
    ];
  }

  /**
   * {@inheritdoc}
   */
  static public function adsenseAdFormats($key = NULL) {
    $ads = [
      'Search Box' => ['desc' => t('Search Box')],
    ];

    if (!empty($key)) {
      return (array_key_exists($key, $ads)) ? $ads[$key] : NULL;
    }
    else {
      return $ads;
    }
  }

}
