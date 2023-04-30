SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `countries`
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code_3` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of countries
-- ----------------------------
INSERT INTO `countries` VALUES ('1', 'ax', 'Aaland Islands', '', 'ALA', '1');
INSERT INTO `countries` VALUES ('2', 'af', 'Afghanistan', '', 'AFG', '1');
INSERT INTO `countries` VALUES ('3', 'al', 'Albania', 'Shqipëria', 'ALB', '1');
INSERT INTO `countries` VALUES ('4', 'dz', 'Algeria', 'ﺮﺌﺎﺰﺠﻠﺍ', 'DZA', '1');
INSERT INTO `countries` VALUES ('5', 'as', 'American Samoa', '', 'ASM', '1');
INSERT INTO `countries` VALUES ('6', 'ad', 'Andorra', '', 'AND', '1');
INSERT INTO `countries` VALUES ('7', 'ao', 'Angola', '', 'AGO', '1');
INSERT INTO `countries` VALUES ('8', 'ai', 'Anguilla', '', 'AIA', '1');
INSERT INTO `countries` VALUES ('9', 'aq', 'Antarctica', '', 'ATA', '1');
INSERT INTO `countries` VALUES ('10', 'ag', 'Antigua and Barbuda', '', 'ATG', '1');
INSERT INTO `countries` VALUES ('11', 'ar', 'Argentina', 'Argentina', 'ARG', '1');
INSERT INTO `countries` VALUES ('12', 'am', 'Armenia', '', 'ARM', '1');
INSERT INTO `countries` VALUES ('13', 'aw', 'Aruba', '', 'ABW', '1');
INSERT INTO `countries` VALUES ('14', 'ac', 'Ascension Island (British)', '', 'ASC', '1');
INSERT INTO `countries` VALUES ('15', 'au', 'Australia', 'Australia', 'AUS', '1');
INSERT INTO `countries` VALUES ('16', 'at', 'Austria', 'Österreich', 'AUT', '1');
INSERT INTO `countries` VALUES ('17', 'az', 'Azerbaijan', '', 'AZE', '1');
INSERT INTO `countries` VALUES ('18', 'bs', 'Bahamas', '', 'BHS', '1');
INSERT INTO `countries` VALUES ('19', 'bh', 'Bahrain', 'ﻦﻴﺮﺤﺐﻠﺍ', 'BHR', '1');
INSERT INTO `countries` VALUES ('20', 'bd', 'Bangladesh', '', 'BGD', '1');
INSERT INTO `countries` VALUES ('21', 'bb', 'Barbados', '', 'BRB', '1');
INSERT INTO `countries` VALUES ('22', 'by', 'Belarus', 'Беларусь', 'BLR', '1');
INSERT INTO `countries` VALUES ('23', 'be', 'Belgium', 'België', 'BEL', '1');
INSERT INTO `countries` VALUES ('24', 'bz', 'Belize', '', 'BLZ', '1');
INSERT INTO `countries` VALUES ('25', 'bj', 'Benin', '', 'BEN', '1');
INSERT INTO `countries` VALUES ('26', 'bm', 'Bermuda', '', 'BMU', '1');
INSERT INTO `countries` VALUES ('27', 'bt', 'Bhutan', '', 'BTN', '1');
INSERT INTO `countries` VALUES ('28', 'bo', 'Bolivia', 'Bolivia', 'BOL', '1');
INSERT INTO `countries` VALUES ('29', 'bq', 'Bonaire, Sint Eustatius and Saba', '', 'BES', '1');
INSERT INTO `countries` VALUES ('30', 'ba', 'Bosnia and Herzegovina', '', 'BIH', '1');
INSERT INTO `countries` VALUES ('31', 'bw', 'Botswana', '', 'BWA', '1');
INSERT INTO `countries` VALUES ('32', 'bv', 'Bouvet Island', '', 'BVT', '1');
INSERT INTO `countries` VALUES ('33', 'br', 'Brazil', 'Brasil', 'BRA', '1');
INSERT INTO `countries` VALUES ('34', 'io', 'British Indian Ocean Territory', '', 'IOT', '1');
INSERT INTO `countries` VALUES ('35', 'bn', 'Brunei Darussalam', '', 'BRN', '1');
INSERT INTO `countries` VALUES ('36', 'bg', 'Bulgaria', 'България', 'BGR', '1');
INSERT INTO `countries` VALUES ('37', 'bf', 'Burkina Faso', '', 'BFA', '1');
INSERT INTO `countries` VALUES ('38', 'bi', 'Burundi', '', 'BDI', '1');
INSERT INTO `countries` VALUES ('39', 'kh', 'Cambodia', '', 'KHM', '1');
INSERT INTO `countries` VALUES ('40', 'cm', 'Cameroon', '', 'CMR', '1');
INSERT INTO `countries` VALUES ('41', 'ca', 'Canada', 'Canada', 'CAN', '1');
INSERT INTO `countries` VALUES ('42', 'ic', 'Canary Islands', '', 'ICA', '1');
INSERT INTO `countries` VALUES ('43', 'cv', 'Cape Verde', '', 'CPV', '1');
INSERT INTO `countries` VALUES ('44', 'ky', 'Cayman Islands', '', 'CYM', '1');
INSERT INTO `countries` VALUES ('45', 'cf', 'Central African Republic', '', 'CAF', '1');
INSERT INTO `countries` VALUES ('46', 'td', 'Chad', '', 'TCD', '1');
INSERT INTO `countries` VALUES ('47', 'cl', 'Chile', 'Chile', 'CHL', '1');
INSERT INTO `countries` VALUES ('48', 'cn', 'China', '中国(中华人民共和国)', 'CHN', '1');
INSERT INTO `countries` VALUES ('49', 'cx', 'Christmas Island', '', 'CXR', '1');
INSERT INTO `countries` VALUES ('50', 'cc', 'Cocos (Keeling) Islands', '', 'CCK', '1');
INSERT INTO `countries` VALUES ('51', 'co', 'Colombia', 'Colombia', 'COL', '1');
INSERT INTO `countries` VALUES ('52', 'km', 'Comoros', '', 'COM', '1');
INSERT INTO `countries` VALUES ('53', 'cg', 'Congo', '', 'COG', '1');
INSERT INTO `countries` VALUES ('54', 'ck', 'Cook Islands', '', 'COK', '1');
INSERT INTO `countries` VALUES ('55', 'cr', 'Costa Rica', 'Costa Rica', 'CRI', '1');
INSERT INTO `countries` VALUES ('56', 'ci', 'Cote D\'Ivoire', '', 'CIV', '1');
INSERT INTO `countries` VALUES ('57', 'hr', 'Croatia', 'Hrvatska', 'HRV', '1');
INSERT INTO `countries` VALUES ('58', 'cu', 'Cuba', '', 'CUB', '1');
INSERT INTO `countries` VALUES ('59', 'cw', 'Curacao', '', 'CUW', '1');
INSERT INTO `countries` VALUES ('60', 'cy', 'Cyprus', '', 'CYP', '1');
INSERT INTO `countries` VALUES ('61', 'cz', 'Czech Republic', 'Česká republika', 'CZE', '1');
INSERT INTO `countries` VALUES ('62', 'cd', 'Democratic Republic of Congo', '', 'COD', '1');
INSERT INTO `countries` VALUES ('63', 'dk', 'Denmark', 'Danmark', 'DNK', '1');
INSERT INTO `countries` VALUES ('64', 'dj', 'Djibouti', '', 'DJI', '1');
INSERT INTO `countries` VALUES ('65', 'dm', 'Dominica', '', 'DMA', '1');
INSERT INTO `countries` VALUES ('66', 'do', 'Dominican Republic', 'República Dominicana', 'DOM', '1');
INSERT INTO `countries` VALUES ('67', 'tl', 'East Timor', '', 'TLS', '1');
INSERT INTO `countries` VALUES ('68', 'ec', 'Ecuador', 'Ecuador', 'ECU', '1');
INSERT INTO `countries` VALUES ('69', 'eg', 'Egypt', 'ﺮﺼﻣ', 'EGY', '1');
INSERT INTO `countries` VALUES ('70', 'sv', 'El Salvador', 'El Salvador', 'SLV', '1');
INSERT INTO `countries` VALUES ('71', 'gq', 'Equatorial Guinea', '', 'GNQ', '1');
INSERT INTO `countries` VALUES ('72', 'er', 'Eritrea', '', 'ERI', '1');
INSERT INTO `countries` VALUES ('73', 'ee', 'Estonia', 'Eesti', 'EST', '1');
INSERT INTO `countries` VALUES ('74', 'et', 'Ethiopia', '', 'ETH', '1');
INSERT INTO `countries` VALUES ('75', 'fk', 'Falkland Islands (Malvinas)', '', 'FLK', '1');
INSERT INTO `countries` VALUES ('76', 'fo', 'Faroe Islands', '', 'FRO', '1');
INSERT INTO `countries` VALUES ('77', 'fj', 'Fiji', '', 'FJI', '1');
INSERT INTO `countries` VALUES ('78', 'fi', 'Finland', 'Suomi', 'FIN', '1');
INSERT INTO `countries` VALUES ('79', 'fr', 'France, Metropolitan', '', 'FRA', '1');
INSERT INTO `countries` VALUES ('80', 'gf', 'French Guiana', '', 'GUF', '1');
INSERT INTO `countries` VALUES ('81', 'pf', 'French Polynesia', '', 'PYF', '1');
INSERT INTO `countries` VALUES ('82', 'tf', 'French Southern Territories', '', 'ATF', '1');
INSERT INTO `countries` VALUES ('83', 'mk', 'FYROM', '', 'MKD', '1');
INSERT INTO `countries` VALUES ('84', 'ga', 'Gabon', '', 'GAB', '1');
INSERT INTO `countries` VALUES ('85', 'gm', 'Gambia', '', 'GMB', '1');
INSERT INTO `countries` VALUES ('86', 'ge', 'Georgia', '', 'GEO', '1');
INSERT INTO `countries` VALUES ('87', 'de', 'Germany', 'Deutschland', 'DEU', '1');
INSERT INTO `countries` VALUES ('88', 'gh', 'Ghana', '', 'GHA', '1');
INSERT INTO `countries` VALUES ('89', 'gi', 'Gibraltar', '', 'GIB', '1');
INSERT INTO `countries` VALUES ('90', 'gr', 'Greece', 'Ελλάδα', 'GRC', '1');
INSERT INTO `countries` VALUES ('91', 'gl', 'Greenland', '', 'GRL', '1');
INSERT INTO `countries` VALUES ('92', 'gd', 'Grenada', '', 'GRD', '1');
INSERT INTO `countries` VALUES ('93', 'gp', 'Guadeloupe', '', 'GLP', '1');
INSERT INTO `countries` VALUES ('94', 'gu', 'Guam', '', 'GUM', '1');
INSERT INTO `countries` VALUES ('95', 'gt', 'Guatemala', 'Guatemala', 'GTM', '1');
INSERT INTO `countries` VALUES ('96', 'gg', 'Guernsey', '', 'GGY', '1');
INSERT INTO `countries` VALUES ('97', 'gn', 'Guinea', '', 'GIN', '1');
INSERT INTO `countries` VALUES ('98', 'gw', 'Guinea-Bissau', '', 'GNB', '1');
INSERT INTO `countries` VALUES ('99', 'gy', 'Guyana', '', 'GUY', '1');
INSERT INTO `countries` VALUES ('100', 'ht', 'Haiti', '', 'HTI', '1');
INSERT INTO `countries` VALUES ('101', 'hm', 'Heard and Mc Donald Islands', '', 'HMD', '1');
INSERT INTO `countries` VALUES ('102', 'hn', 'Honduras', 'Honduras', 'HND', '1');
INSERT INTO `countries` VALUES ('103', 'hk', 'Hong Kong', '香港', 'HKG', '1');
INSERT INTO `countries` VALUES ('104', 'hu', 'Hungary', 'Magyarország', 'HUN', '1');
INSERT INTO `countries` VALUES ('105', 'is', 'Iceland', 'Ísland', 'ISL', '1');
INSERT INTO `countries` VALUES ('106', 'in', 'India', '', 'IND', '1');
INSERT INTO `countries` VALUES ('107', 'id', 'Indonesia', 'Indonesia', 'IDN', '1');
INSERT INTO `countries` VALUES ('108', 'ir', 'Iran (Islamic Republic of)', '', 'IRN', '1');
INSERT INTO `countries` VALUES ('109', 'iq', 'Iraq', '', 'IRQ', '1');
INSERT INTO `countries` VALUES ('110', 'ie', 'Ireland', 'Ireland', 'IRL', '1');
INSERT INTO `countries` VALUES ('111', 'im', 'Isle of Man', '', 'IMN', '1');
INSERT INTO `countries` VALUES ('112', 'il', 'Israel', 'לארשי', 'ISR', '1');
INSERT INTO `countries` VALUES ('113', 'it', 'Italy', 'Italia', 'ITA', '1');
INSERT INTO `countries` VALUES ('114', 'jm', 'Jamaica', '', 'JAM', '1');
INSERT INTO `countries` VALUES ('115', 'jp', 'Japan', '日本', 'JPN', '1');
INSERT INTO `countries` VALUES ('116', 'je', 'Jersey', '', 'JEY', '1');
INSERT INTO `countries` VALUES ('117', 'jo', 'Jordan', 'ﻦﺪﺮﺄﻠﺍ', 'JOR', '1');
INSERT INTO `countries` VALUES ('118', 'kz', 'Kazakhstan', '', 'KAZ', '1');
INSERT INTO `countries` VALUES ('119', 'ke', 'Kenya', '', 'KEN', '1');
INSERT INTO `countries` VALUES ('120', 'ki', 'Kiribati', '', 'KIR', '1');
INSERT INTO `countries` VALUES ('121', 'xk', 'Kosovo, Republic of', '', 'UNK', '1');
INSERT INTO `countries` VALUES ('122', 'kw', 'Kuwait', 'ﺖﻴﻮﻜﻠﺍ', 'KWT', '1');
INSERT INTO `countries` VALUES ('123', 'kg', 'Kyrgyzstan', '', 'KGZ', '1');
INSERT INTO `countries` VALUES ('124', 'la', 'Lao People\'s Democratic Republic', '', 'LAO', '1');
INSERT INTO `countries` VALUES ('125', 'lv', 'Latvia', 'Latvija', 'LVA', '1');
INSERT INTO `countries` VALUES ('126', 'lb', 'Lebanon', 'ﻦﺎﻨﺐﻟ', 'LBN', '1');
INSERT INTO `countries` VALUES ('127', 'ls', 'Lesotho', '', 'LSO', '1');
INSERT INTO `countries` VALUES ('128', 'lr', 'Liberia', '', 'LBR', '1');
INSERT INTO `countries` VALUES ('129', 'ly', 'Libyan Arab Jamahiriya', '', 'LBY', '1');
INSERT INTO `countries` VALUES ('130', 'li', 'Liechtenstein', 'Liechtenstein', 'LIE', '1');
INSERT INTO `countries` VALUES ('131', 'lt', 'Lithuania', 'Lietuva', 'LTU', '1');
INSERT INTO `countries` VALUES ('132', 'lu', 'Luxembourg', 'Luxembourg', 'LUX', '1');
INSERT INTO `countries` VALUES ('133', 'mo', 'Macau', '', 'MAC', '1');
INSERT INTO `countries` VALUES ('134', 'mg', 'Madagascar', '', 'MDG', '1');
INSERT INTO `countries` VALUES ('135', 'mw', 'Malawi', '', 'MWI', '1');
INSERT INTO `countries` VALUES ('136', 'my', 'Malaysia', '', 'MYS', '1');
INSERT INTO `countries` VALUES ('137', 'mv', 'Maldives', '', 'MDV', '1');
INSERT INTO `countries` VALUES ('138', 'ml', 'Mali', '', 'MLI', '1');
INSERT INTO `countries` VALUES ('139', 'mt', 'Malta', '', 'MLT', '1');
INSERT INTO `countries` VALUES ('140', 'mh', 'Marshall Islands', '', 'MHL', '1');
INSERT INTO `countries` VALUES ('141', 'mq', 'Martinique', '', 'MTQ', '1');
INSERT INTO `countries` VALUES ('142', 'mr', 'Mauritania', '', 'MRT', '1');
INSERT INTO `countries` VALUES ('143', 'mu', 'Mauritius', '', 'MUS', '1');
INSERT INTO `countries` VALUES ('144', 'yt', 'Mayotte', '', 'MYT', '1');
INSERT INTO `countries` VALUES ('145', 'mx', 'Mexico', 'México', 'MEX', '1');
INSERT INTO `countries` VALUES ('146', 'fm', 'Micronesia, Federated States of', '', 'FSM', '1');
INSERT INTO `countries` VALUES ('147', 'md', 'Moldova, Republic of', '', 'MDA', '1');
INSERT INTO `countries` VALUES ('148', 'mc', 'Monaco', '', 'MCO', '1');
INSERT INTO `countries` VALUES ('149', 'mn', 'Mongolia', '', 'MNG', '1');
INSERT INTO `countries` VALUES ('150', 'me', 'Montenegro', '', 'MNE', '1');
INSERT INTO `countries` VALUES ('151', 'ms', 'Montserrat', '', 'MSR', '1');
INSERT INTO `countries` VALUES ('152', 'ma', 'Morocco', 'ﺔﻴﺐﺮﻐﻤﻠﺍ ﺔﻜﻠﻤﻤﻠﺍ', 'MAR', '1');
INSERT INTO `countries` VALUES ('153', 'mz', 'Mozambique', '', 'MOZ', '1');
INSERT INTO `countries` VALUES ('154', 'mm', 'Myanmar', '', 'MMR', '1');
INSERT INTO `countries` VALUES ('155', 'na', 'Namibia', '', 'NAM', '1');
INSERT INTO `countries` VALUES ('156', 'nr', 'Nauru', '', 'NRU', '1');
INSERT INTO `countries` VALUES ('157', 'np', 'Nepal', '', 'NPL', '1');
INSERT INTO `countries` VALUES ('158', 'nl', 'Netherlands', 'Nederland', 'NLD', '1');
INSERT INTO `countries` VALUES ('159', 'an', 'Netherlands Antilles', '', 'ANT', '1');
INSERT INTO `countries` VALUES ('160', 'nc', 'New Caledonia', '', 'NCL', '1');
INSERT INTO `countries` VALUES ('161', 'nz', 'New Zealand', 'New Zealand', 'NZL', '1');
INSERT INTO `countries` VALUES ('162', 'ni', 'Nicaragua', 'Nicarágua', 'NIC', '1');
INSERT INTO `countries` VALUES ('163', 'ne', 'Niger', '', 'NER', '1');
INSERT INTO `countries` VALUES ('164', 'ng', 'Nigeria', '', 'NGA', '1');
INSERT INTO `countries` VALUES ('165', 'nu', 'Niue', '', 'NIU', '1');
INSERT INTO `countries` VALUES ('166', 'nf', 'Norfolk Island', '', 'NFK', '1');
INSERT INTO `countries` VALUES ('167', 'kp', 'North Korea', '', 'PRK', '1');
INSERT INTO `countries` VALUES ('168', 'mp', 'Northern Mariana Islands', '', 'MNP', '1');
INSERT INTO `countries` VALUES ('169', 'no', 'Norway', 'Norge', 'NOR', '1');
INSERT INTO `countries` VALUES ('170', 'om', 'Oman', 'ﻦﺎﻤﻋ', 'OMN', '1');
INSERT INTO `countries` VALUES ('171', 'pk', 'Pakistan', '', 'PAK', '1');
INSERT INTO `countries` VALUES ('172', 'pw', 'Palau', '', 'PLW', '1');
INSERT INTO `countries` VALUES ('173', 'ps', 'Palestinian Territory, Occupied', '', 'PSE', '1');
INSERT INTO `countries` VALUES ('174', 'pa', 'Panama', 'Panamá', 'PAN', '1');
INSERT INTO `countries` VALUES ('175', 'pg', 'Papua New Guinea', '', 'PNG', '1');
INSERT INTO `countries` VALUES ('176', 'py', 'Paraguay', 'Paraguay', 'PRY', '1');
INSERT INTO `countries` VALUES ('177', 'pe', 'Peru', 'Perú', 'PER', '1');
INSERT INTO `countries` VALUES ('178', 'ph', 'Philippines', '', 'PHL', '1');
INSERT INTO `countries` VALUES ('179', 'pn', 'Pitcairn', '', 'PCN', '1');
INSERT INTO `countries` VALUES ('180', 'pl', 'Poland', 'Polska', 'POL', '1');
INSERT INTO `countries` VALUES ('181', 'pt', 'Portugal', 'Portugal', 'PRT', '1');
INSERT INTO `countries` VALUES ('182', 'pr', 'Puerto Rico', '', 'PRI', '1');
INSERT INTO `countries` VALUES ('183', 'qa', 'Qatar', 'ﺮﻄﻗ', 'QAT', '1');
INSERT INTO `countries` VALUES ('184', 're', 'Reunion', '', 'REU', '1');
INSERT INTO `countries` VALUES ('185', 'ro', 'Romania', 'România', 'ROM', '1');
INSERT INTO `countries` VALUES ('186', 'ru', 'Russian Federation', 'Россия', 'RUS', '1');
INSERT INTO `countries` VALUES ('187', 'rw', 'Rwanda', '', 'RWA', '1');
INSERT INTO `countries` VALUES ('188', 'kn', 'Saint Kitts and Nevis', '', 'KNA', '1');
INSERT INTO `countries` VALUES ('189', 'lc', 'Saint Lucia', '', 'LCA', '1');
INSERT INTO `countries` VALUES ('190', 'vc', 'Saint Vincent and the Grenadines', '', 'VCT', '1');
INSERT INTO `countries` VALUES ('191', 'ws', 'Samoa', '', 'WSM', '1');
INSERT INTO `countries` VALUES ('192', 'sm', 'San Marino', '', 'SMR', '1');
INSERT INTO `countries` VALUES ('193', 'st', 'Sao Tome and Principe', '', 'STP', '1');
INSERT INTO `countries` VALUES ('194', 'sa', 'Saudi Arabia', 'ﺔﻴﺪﻮﻌﺴﻠﺍ ﺔﻴﺐﺮﻌﻠﺍ ﺔﻜﻠﻤﻤﻠﺍ', 'SAU', '1');
INSERT INTO `countries` VALUES ('195', 'sn', 'Senegal', '', 'SEN', '1');
INSERT INTO `countries` VALUES ('196', 'rs', 'Serbia', 'Srbija', 'SRB', '1');
INSERT INTO `countries` VALUES ('197', 'sc', 'Seychelles', '', 'SYC', '1');
INSERT INTO `countries` VALUES ('198', 'sl', 'Sierra Leone', '', 'SLE', '1');
INSERT INTO `countries` VALUES ('199', 'sg', 'Singapore', '新加坡', 'SGP', '1');
INSERT INTO `countries` VALUES ('200', 'sk', 'Slovak Republic', 'Slovenská republika', 'SVK', '1');
INSERT INTO `countries` VALUES ('201', 'si', 'Slovenia', 'Slovenija', 'SVN', '1');
INSERT INTO `countries` VALUES ('202', 'sb', 'Solomon Islands', '', 'SLB', '1');
INSERT INTO `countries` VALUES ('203', 'so', 'Somalia', '', 'SOM', '1');
INSERT INTO `countries` VALUES ('204', 'za', 'South Africa', 'South Africa', 'ZAF', '1');
INSERT INTO `countries` VALUES ('205', 'gs', 'South Georgia &amp; South Sandwich Islands', '', 'SGS', '1');
INSERT INTO `countries` VALUES ('206', 'kr', 'South Korea', '대한민국', 'KOR', '1');
INSERT INTO `countries` VALUES ('207', 'ss', 'South Sudan', '', 'SSD', '1');
INSERT INTO `countries` VALUES ('208', 'es', 'Spain', 'Espainia', 'ESP', '1');
INSERT INTO `countries` VALUES ('209', 'lk', 'Sri Lanka', '', 'LKA', '1');
INSERT INTO `countries` VALUES ('210', 'bl', 'St. Barthelemy', '', 'BLM', '1');
INSERT INTO `countries` VALUES ('211', 'sh', 'St. Helena', '', 'SHN', '1');
INSERT INTO `countries` VALUES ('212', 'mf', 'St. Martin (French part)', '', 'MAF', '1');
INSERT INTO `countries` VALUES ('213', 'pm', 'St. Pierre and Miquelon', '', 'SPM', '1');
INSERT INTO `countries` VALUES ('214', 'sd', 'Sudan', '', 'SDN', '1');
INSERT INTO `countries` VALUES ('215', 'sr', 'Suriname', '', 'SUR', '1');
INSERT INTO `countries` VALUES ('216', 'sj', 'Svalbard and Jan Mayen Islands', '', 'SJM', '1');
INSERT INTO `countries` VALUES ('217', 'sz', 'Swaziland', '', 'SWZ', '1');
INSERT INTO `countries` VALUES ('218', 'se', 'Sweden', 'Sverige', 'SWE', '1');
INSERT INTO `countries` VALUES ('219', 'ch', 'Switzerland', 'Suisse', 'CHE', '1');
INSERT INTO `countries` VALUES ('220', 'sy', 'Syrian Arab Republic', 'ﺎﻴﺮﻮﺳ', 'SYR', '1');
INSERT INTO `countries` VALUES ('221', 'tw', 'Taiwan', '台灣(中華民國)', 'TWN', '1');
INSERT INTO `countries` VALUES ('222', 'tj', 'Tajikistan', '', 'TJK', '1');
INSERT INTO `countries` VALUES ('223', 'tz', 'Tanzania, United Republic of', '', 'TZA', '1');
INSERT INTO `countries` VALUES ('224', 'th', 'Thailand', 'ไทย', 'THA', '1');
INSERT INTO `countries` VALUES ('225', 'tg', 'Togo', '', 'TGO', '1');
INSERT INTO `countries` VALUES ('226', 'tk', 'Tokelau', '', 'TKL', '1');
INSERT INTO `countries` VALUES ('227', 'to', 'Tonga', '', 'TON', '1');
INSERT INTO `countries` VALUES ('228', 'tt', 'Trinidad and Tobago', '', 'TTO', '1');
INSERT INTO `countries` VALUES ('229', 'ta', 'Tristan da Cunha', '', 'SHN', '1');
INSERT INTO `countries` VALUES ('230', 'tn', 'Tunisia', 'ﺲﻨﻮﺗ', 'TUN', '1');
INSERT INTO `countries` VALUES ('231', 'tr', 'Turkey', 'Türkiye', 'TUR', '1');
INSERT INTO `countries` VALUES ('232', 'tm', 'Turkmenistan', '', 'TKM', '1');
INSERT INTO `countries` VALUES ('233', 'tc', 'Turks and Caicos Islands', '', 'TCA', '1');
INSERT INTO `countries` VALUES ('234', 'tv', 'Tuvalu', '', 'TUV', '1');
INSERT INTO `countries` VALUES ('235', 'ug', 'Uganda', '', 'UGA', '1');
INSERT INTO `countries` VALUES ('236', 'ua', 'Ukraine', 'Україна', 'UKR', '1');
INSERT INTO `countries` VALUES ('237', 'ae', 'United Arab Emirates', 'ﺔﺪﺤﺘﻤﻠﺍ ﺔﻴﺐﺮﻌﻠﺍ ﺖﺎﺮﺎﻤﺈﻠﺍ', 'ARE', '1');
INSERT INTO `countries` VALUES ('238', 'gb', 'United Kingdom', 'United Kingdom', 'GBR', '1');
INSERT INTO `countries` VALUES ('239', 'us', 'United States', 'United States', 'USA', '1');
INSERT INTO `countries` VALUES ('240', 'um', 'United States Minor Outlying Islands', '', 'UMI', '1');
INSERT INTO `countries` VALUES ('241', 'uy', 'Uruguay', 'Uruguay', 'URY', '1');
INSERT INTO `countries` VALUES ('242', 'uz', 'Uzbekistan', '', 'UZB', '1');
INSERT INTO `countries` VALUES ('243', 'vu', 'Vanuatu', '', 'VUT', '1');
INSERT INTO `countries` VALUES ('244', 'va', 'Vatican City State (Holy See)', '', 'VAT', '1');
INSERT INTO `countries` VALUES ('245', 've', 'Venezuela', 'Venezuela', 'VEN', '1');
INSERT INTO `countries` VALUES ('246', 'vn', 'Viet Nam', 'Việt Nam', 'VNM', '1');
INSERT INTO `countries` VALUES ('247', 'vg', 'Virgin Islands (British)', '', 'VGB', '1');
INSERT INTO `countries` VALUES ('248', 'vi', 'Virgin Islands (U.S.)', '', 'VIR', '1');
INSERT INTO `countries` VALUES ('249', 'wf', 'Wallis and Futuna Islands', '', 'WLF', '1');
INSERT INTO `countries` VALUES ('250', 'eh', 'Western Sahara', '', 'ESH', '1');
INSERT INTO `countries` VALUES ('251', 'ye', 'Yemen', 'ﻦﻤﻴﻠﺍ', 'YEM', '1');
INSERT INTO `countries` VALUES ('252', 'zm', 'Zambia', '', 'ZMB', '1');
INSERT INTO `countries` VALUES ('253', 'zw', 'Zimbabwe', '', 'ZWE', '1');