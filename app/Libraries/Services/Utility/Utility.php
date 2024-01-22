<?php
namespace Libraries\Services\Utility;

// use CodeIgniter\Config\Services;


class Utility {

    public function __construct() {
    }

    // public function prepare_breadcrumb($breadcrumb, $lang){
    //     If($lang == 'en') {
    //         return $breadcrumb;
    //     }

    //     // var_dump($breadcrumb);

    //     // die();
    //     return $breadcrumb;
    // }

    // public function flatten($arr) {
    //     array_walk($arr, function(&$value, $key) {
	// 		$value = "{$key}:{$value}";
	// 	});

    //     return implode(',', $arr);
    // }

    // public function get_directionality_marker($dir='ltr'){
    //     if($dir === 'rtl'){
    //         return '&#x200F;';
    //     }
    //     return '&#x200E;';
    // }

    /**
     *
     * Using sha1().
     * sha1 has a 40 character limit and always lowercase characters.
     *
     * @param int $length
     * @return string
     */
    // public function getRandomTokenString($length = 32) {
    //     $str1 = time() . rand();
    //     $string = sha1($str1);
    //     $randomString = substr($string, 0, $length);

    //     // Capitalize random characters
    //     $num = ceil($length / 4);
    //     $characters = str_split($randomString);
    //     $i = 0;
    //     do{
    //         $random_index = rand(0, count($characters) - 1);
    //         $unique_indices[] = ""; //UNIQUE INDICES
    //         while (in_array($random_index, $unique_indices)) {
    //             $random_index = rand(0, count($characters) - 1);
    //         }
    //         $unique_indices[] = $random_index;

    //         $random_letter = $characters[$random_index];
    //         if(ctype_alpha($random_letter)){//only letters 
    //             $characters[$random_index] = strtoupper($random_letter);
    //             $i++;
    //         }
    //     }while($i<$num);

    //     $token = implode('', $characters);

    //     return $token;
    // }

    // public function verify_recaptcha_v3($secret_key, $g_recaptcha_response){

    //     $recaptcha = new \ReCaptcha\ReCaptcha($secret_key);

    //     $res = $recaptcha	->setExpectedHostname($_SERVER['SERVER_NAME'])
	// 						// ->setExpectedAction('homepage')
	// 						->setScoreThreshold(0.5)
	// 						->verify($g_recaptcha_response, $_SERVER['REMOTE_ADDR']);
        
    //     return $res;
    // }

    // public function tidy_text($str, $separator=" ") {
    //     $strArray = explode(" ", $str);

    //     $tidy = '';

    //     foreach ($strArray as $token) {
    //         if(trim($token) == ''){
    //             continue;
    //         }
    //         $tidy = $tidy . $separator . trim($token);
    //     }

    //     return ltrim($tidy,$separator);
    // }

    public function print_version() {

        $str =  '<div class="version-container">' .
                    '<span class="digit">' .
                        '0' .
                    '</span>' . 

                    '<div class="dot-container"><div class="dot"></div></div>' .

                    '<span class="digit">' . 
                        '1' .
                    '</span>' . 

                    '<div class="dot-container"><div class="dot"></div></div>' . 

                    '<span class="digit">' .
                        '5' .
                    '</span>' .
                '</div>';
        
                return $str;

    }

    // public function gender_dropdown ($control_name, $direction="ltr", $required=false) {
    //     return  '<select name="' . $control_name . '" id="' . $control_name . '" tabindex="" class="form-control" style="direction: ' . $direction . '">'.
    //                 '<option value="">----------</option>' .
    //                 '<option value="M">' . lang('app.male') . '</option>' .
    //                 '<option value="F">' . lang('app.female') . '</option>' .
    //             '</select>';

    // }

    // public function marital_status_dropdown ($control_name, $direction="ltr", $required=false) {
    //     return  '<select name="' . $control_name . '" id="' . $control_name . '" tabindex="" class="form-control" style="direction: ' . $direction . '">'.
    //                 '<option value="">----------</option>' .
    //                 '<option value="1">' . lang('app.single') . '</option>' .
    //                 '<option value="2">' . lang('app.married') . '</option>' .
    //                 '<option value="3">' . lang('app.divorced') . '</option>' .
    //                 '<option value="4">' . lang('app.widowed') . '</option>' .
    //                 '<option value="5">' . lang('app.separated') . '</option>' .
    //                 '<option value="6">' . lang('app.engaged') . '</option>' .
    //             '</select>';

    // }

    // public function countries_dropdown ($control_name, $required=false) {
    //     $required = $required === true ? 'required' : '';
    //     return '<select name="' . $control_name . '" id="' . $control_name . '" tabindex="" class="form-control"' . $required . '>
    //             <option value="">----------</option>
    //             <option value="AE">United Arab Emirates</option>
    //             <option value="AF">Afghanistan</option>
    //             <option value="AX">Aland Islands</option>
    //             <option value="AL">Albania</option>
    //             <option value="DZ">Algeria</option>
    //             <option value="AS">American Samoa</option>
    //             <option value="AD">Andorra</option>
    //             <option value="AO">Angola</option>
    //             <option value="AI">Anguilla</option>
    //             <option value="AQ">Antarctica</option>
    //             <option value="AG">Antigua and Barbuda</option>
    //             <option value="AR">Argentina</option>
    //             <option value="AM">Armenia</option>
    //             <option value="AW">Aruba</option>
    //             <option value="AU">Australia</option>
    //             <option value="AT">Austria</option>
    //             <option value="AZ">Azerbaijan</option>
    //             <option value="BS">Bahamas</option>
    //             <option value="BH">Bahrain</option>
    //             <option value="BD">Bangladesh</option>
    //             <option value="BB">Barbados</option>
    //             <option value="BY">Belarus</option>
    //             <option value="BE">Belgium</option>
    //             <option value="BZ">Belize</option>
    //             <option value="BJ">Benin</option>
    //             <option value="BM">Bermuda</option>
    //             <option value="BT">Bhutan</option>
    //             <option value="BO">Bolivia</option>
    //             <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
    //             <option value="BA">Bosnia and Herzegovina</option>
    //             <option value="BW">Botswana</option>
    //             <option value="BV">Bouvet Island</option>
    //             <option value="BR">Brazil</option>
    //             <option value="IO">British Indian Ocean Territory</option>
    //             <option value="BN">Brunei Darussalam</option>
    //             <option value="BG">Bulgaria</option>
    //             <option value="BF">Burkina Faso</option>
    //             <option value="BI">Burundi</option>
    //             <option value="KH">Cambodia</option>
    //             <option value="CM">Cameroon</option>
    //             <option value="CA">Canada</option>
    //             <option value="CV">Cape Verde</option>
    //             <option value="KY">Cayman Islands</option>
    //             <option value="CF">Central African Republic</option>
    //             <option value="TD">Chad</option>
    //             <option value="CL">Chile</option>
    //             <option value="CN">China</option>
    //             <option value="CX">Christmas Island</option>
    //             <option value="CC">Cocos (Keeling) Islands</option>
    //             <option value="CO">Colombia</option>
    //             <option value="KM">Comoros</option>
    //             <option value="CG">Congo</option>
    //             <option value="CD">Congo, Democratic Republic of the Congo</option>
    //             <option value="CK">Cook Islands</option>
    //             <option value="CR">Costa Rica</option>
    //             <option value="CI">Cote D\'Ivoire</option>
    //             <option value="HR">Croatia</option>
    //             <option value="CU">Cuba</option>
    //             <option value="CW">Curacao</option>
    //             <option value="CY">Cyprus</option>
    //             <option value="CZ">Czech Republic</option>
    //             <option value="DK">Denmark</option>
    //             <option value="DJ">Djibouti</option>
    //             <option value="DM">Dominica</option>
    //             <option value="DO">Dominican Republic</option>
    //             <option value="EC">Ecuador</option>
    //             <option value="EG">Egypt</option>
    //             <option value="SV">El Salvador</option>
    //             <option value="GQ">Equatorial Guinea</option>
    //             <option value="ER">Eritrea</option>
    //             <option value="EE">Estonia</option>
    //             <option value="ET">Ethiopia</option>
    //             <option value="FK">Falkland Islands (Malvinas)</option>
    //             <option value="FO">Faroe Islands</option>
    //             <option value="FJ">Fiji</option>
    //             <option value="FI">Finland</option>
    //             <option value="FR">France</option>
    //             <option value="GF">French Guiana</option>
    //             <option value="PF">French Polynesia</option>
    //             <option value="TF">French Southern Territories</option>
    //             <option value="GA">Gabon</option>
    //             <option value="GM">Gambia</option>
    //             <option value="GE">Georgia</option>
    //             <option value="DE">Germany</option>
    //             <option value="GH">Ghana</option>
    //             <option value="GI">Gibraltar</option>
    //             <option value="GR">Greece</option>
    //             <option value="GL">Greenland</option>
    //             <option value="GD">Grenada</option>
    //             <option value="GP">Guadeloupe</option>
    //             <option value="GU">Guam</option>
    //             <option value="GT">Guatemala</option>
    //             <option value="GG">Guernsey</option>
    //             <option value="GN">Guinea</option>
    //             <option value="GW">Guinea-Bissau</option>
    //             <option value="GY">Guyana</option>
    //             <option value="HT">Haiti</option>
    //             <option value="HM">Heard Island and Mcdonald Islands</option>
    //             <option value="VA">Holy See (Vatican City State)</option>
    //             <option value="HN">Honduras</option>
    //             <option value="HK">Hong Kong</option>
    //             <option value="HU">Hungary</option>
    //             <option value="IS">Iceland</option>
    //             <option value="IN">India</option>
    //             <option value="ID">Indonesia</option>
    //             <option value="IR">Iran, Islamic Republic of</option>
    //             <option value="IQ">Iraq</option>
    //             <option value="IE">Ireland</option>
    //             <option value="IM">Isle of Man</option>
    //             <option value="IL">Israel</option>
    //             <option value="IT">Italy</option>
    //             <option value="JM">Jamaica</option>
    //             <option value="JP">Japan</option>
    //             <option value="JE">Jersey</option>
    //             <option value="JO">Jordan</option>
    //             <option value="KZ">Kazakhstan</option>
    //             <option value="KE">Kenya</option>
    //             <option value="KI">Kiribati</option>
    //             <option value="KP">Korea, Democratic People\'s Republic of</option>
    //             <option value="KR">Korea, Republic of</option>
    //             <option value="XK">Kosovo</option>
    //             <option value="KW">Kuwait</option>
    //             <option value="KG">Kyrgyzstan</option>
    //             <option value="LA">Lao People\'s Democratic Republic</option>
    //             <option value="LV">Latvia</option>
    //             <option value="LB">Lebanon</option>
    //             <option value="LS">Lesotho</option>
    //             <option value="LR">Liberia</option>
    //             <option value="LY">Libyan Arab Jamahiriya</option>
    //             <option value="LI">Liechtenstein</option>
    //             <option value="LT">Lithuania</option>
    //             <option value="LU">Luxembourg</option>
    //             <option value="MO">Macao</option>
    //             <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
    //             <option value="MG">Madagascar</option>
    //             <option value="MW">Malawi</option>
    //             <option value="MY">Malaysia</option>
    //             <option value="MV">Maldives</option>
    //             <option value="ML">Mali</option>
    //             <option value="MT">Malta</option>
    //             <option value="MH">Marshall Islands</option>
    //             <option value="MQ">Martinique</option>
    //             <option value="MR">Mauritania</option>
    //             <option value="MU">Mauritius</option>
    //             <option value="YT">Mayotte</option>
    //             <option value="MX">Mexico</option>
    //             <option value="FM">Micronesia, Federated States of</option>
    //             <option value="MD">Moldova, Republic of</option>
    //             <option value="MC">Monaco</option>
    //             <option value="MN">Mongolia</option>
    //             <option value="ME">Montenegro</option>
    //             <option value="MS">Montserrat</option>
    //             <option value="MA">Morocco</option>
    //             <option value="MZ">Mozambique</option>
    //             <option value="MM">Myanmar</option>
    //             <option value="NA">Namibia</option>
    //             <option value="NR">Nauru</option>
    //             <option value="NP">Nepal</option>
    //             <option value="NL">Netherlands</option>
    //             <option value="AN">Netherlands Antilles</option>
    //             <option value="NC">New Caledonia</option>
    //             <option value="NZ">New Zealand</option>
    //             <option value="NI">Nicaragua</option>
    //             <option value="NE">Niger</option>
    //             <option value="NG">Nigeria</option>
    //             <option value="NU">Niue</option>
    //             <option value="NF">Norfolk Island</option>
    //             <option value="MP">Northern Mariana Islands</option>
    //             <option value="NO">Norway</option>
    //             <option value="OM">Oman</option>
    //             <option value="PK">Pakistan</option>
    //             <option value="PW">Palau</option>
    //             <option value="PS">Palestine</option>
    //             <option value="PA">Panama</option>
    //             <option value="PG">Papua New Guinea</option>
    //             <option value="PY">Paraguay</option>
    //             <option value="PE">Peru</option>
    //             <option value="PH">Philippines</option>
    //             <option value="PN">Pitcairn</option>
    //             <option value="PL">Poland</option>
    //             <option value="PT">Portugal</option>
    //             <option value="PR">Puerto Rico</option>
    //             <option value="QA">Qatar</option>
    //             <option value="RE">Reunion</option>
    //             <option value="RO">Romania</option>
    //             <option value="RU">Russian Federation</option>
    //             <option value="RW">Rwanda</option>
    //             <option value="BL">Saint Barthelemy</option>
    //             <option value="SH">Saint Helena</option>
    //             <option value="KN">Saint Kitts and Nevis</option>
    //             <option value="LC">Saint Lucia</option>
    //             <option value="MF">Saint Martin</option>
    //             <option value="PM">Saint Pierre and Miquelon</option>
    //             <option value="VC">Saint Vincent and the Grenadines</option>
    //             <option value="WS">Samoa</option>
    //             <option value="SM">San Marino</option>
    //             <option value="ST">Sao Tome and Principe</option>
    //             <option value="SA">Saudi Arabia</option>
    //             <option value="SN">Senegal</option>
    //             <option value="RS">Serbia</option>
    //             <option value="CS">Serbia and Montenegro</option>
    //             <option value="SC">Seychelles</option>
    //             <option value="SL">Sierra Leone</option>
    //             <option value="SG">Singapore</option>
    //             <option value="SX">Sint Maarten</option>
    //             <option value="SK">Slovakia</option>
    //             <option value="SI">Slovenia</option>
    //             <option value="SB">Solomon Islands</option>
    //             <option value="SO">Somalia</option>
    //             <option value="ZA">South Africa</option>
    //             <option value="GS">South Georgia and the South Sandwich Islands</option>
    //             <option value="SS">South Sudan</option>
    //             <option value="ES">Spain</option>
    //             <option value="LK">Sri Lanka</option>
    //             <option value="SD">Sudan</option>
    //             <option value="SR">Suriname</option>
    //             <option value="SJ">Svalbard and Jan Mayen</option>
    //             <option value="SZ">Swaziland</option>
    //             <option value="SE">Sweden</option>
    //             <option value="CH">Switzerland</option>
    //             <option value="SY">Syrian Arab Republic</option>
    //             <option value="TW">Taiwan, Province of China</option>
    //             <option value="TJ">Tajikistan</option>
    //             <option value="TZ">Tanzania, United Republic of</option>
    //             <option value="TH">Thailand</option>
    //             <option value="TL">Timor-Leste</option>
    //             <option value="TG">Togo</option>
    //             <option value="TK">Tokelau</option>
    //             <option value="TO">Tonga</option>
    //             <option value="TT">Trinidad and Tobago</option>
    //             <option value="TN">Tunisia</option>
    //             <option value="TR">Turkey</option>
    //             <option value="TM">Turkmenistan</option>
    //             <option value="TC">Turks and Caicos Islands</option>
    //             <option value="TV">Tuvalu</option>
    //             <option value="UG">Uganda</option>
    //             <option value="UA">Ukraine</option>
    //             <option value="GB">United Kingdom</option>
    //             <option value="US">United States</option>
    //             <option value="UM">United States Minor Outlying Islands</option>
    //             <option value="UY">Uruguay</option>
    //             <option value="UZ">Uzbekistan</option>
    //             <option value="VU">Vanuatu</option>
    //             <option value="VE">Venezuela</option>
    //             <option value="VN">Viet Nam</option>
    //             <option value="VG">Virgin Islands, British</option>
    //             <option value="VI">Virgin Islands, U.s.</option>
    //             <option value="WF">Wallis and Futuna</option>
    //             <option value="EH">Western Sahara</option>
    //             <option value="YE">Yemen</option>
    //             <option value="ZM">Zambia</option>
    //             <option value="ZW">Zimbabwe</option>
    //         </select>';
    // }

    // public function countries_dropdown_arabic ($control_name, $required=false) {
    //     $required = $required === true ? 'required' : '';
    //     return '<select name="' . $control_name . '" id="' . $control_name . '" tabindex="" class="form-control"' . $required . ' style="direction: rtl">
    //             <option value="">----------</option>
    //             <option value="AE">الإمارات العربية المتحدة</option>
    //             <option value="AF">أفغانستان</option>
    //             <option value="AX">جزر آلاند</option>
    //             <option value="AL">ألبانيا</option>
    //             <option value="DZ">الجزائر</option>
    //             <option value="AS">ساموا الأمريكية</option>
    //             <option value="AD">أندورا</option>
    //             <option value="AO">أنغولا</option>
    //             <option value="AI">أنغيلا</option>
    //             <option value="AQ">أنتاركتيكا</option>
    //             <option value="AG">أنتيغوا وبربودا</option>
    //             <option value="AR">الأرجنتين</option>
    //             <option value="AM">أرمينيا</option>
    //             <option value="AW">أروبا</option>
    //             <option value="AU">أستراليا</option>
    //             <option value="AT">النمسا</option>
    //             <option value="AZ">أذربيجان</option>
    //             <option value="BS">جزر البهاما</option>
    //             <option value="BH">البحرين</option>
    //             <option value="BD">بنغلاديش</option>
    //             <option value="BB">بربادوس</option>
    //             <option value="BY">بيلاروسيا</option>
    //             <option value="BE">بلجيكا</option>
    //             <option value="BZ">بليز</option>
    //             <option value="BJ">بنين</option>
    //             <option value="BM">برمودا</option>
    //             <option value="BT">بوتان</option>
    //             <option value="BO">بوليفيا</option>
    //             <option value="BQ">بونير وسانت يوستاتيوس وسابا</option>
    //             <option value="BA">البوسنة والهرسك</option>
    //             <option value="BW">بوتسوانا</option>
    //             <option value="BV">جزيرة بوفيت</option>
    //             <option value="BR">البرازيل</option>
    //             <option value="IO">إقليم المحيط البريطاني الهندي</option>
    //             <option value="BN">بروناي دار السلام</option>
    //             <option value="BG">بلغاريا</option>
    //             <option value="BF">بوركينا فاسو</option>
    //             <option value="BI">بوروندي</option>
    //             <option value="KH">كمبوديا</option>
    //             <option value="CM">الكاميرون</option>
    //             <option value="CA">كندا</option>
    //             <option value="CV">الرأس الأخضر</option>
    //             <option value="KY">جزر كايمان</option>
    //             <option value="CF">جمهورية افريقيا الوسطى</option>
    //             <option value="TD">تشاد</option>
    //             <option value="CL">تشيلي</option>
    //             <option value="CN">الصين</option>
    //             <option value="CX">جزيرة الكريسماس</option>
    //             <option value="CC">جزر كوكوس (كيلينغ)</option>
    //             <option value="CO">كولومبيا</option>
    //             <option value="KM">جزر القمر</option>
    //             <option value="CG">الكونغو</option>
    //             <option value="CD">الكونغو ، جمهورية الكونغو الديمقراطية</option>
    //             <option value="CK">جزر كوك</option>
    //             <option value="CR">كوستا ريكا</option>
    //             <option value="CI">ساحل العاج</option>
    //             <option value="HR">كرواتيا</option>
    //             <option value="CU">كوبا</option>
    //             <option value="CW">كوراكاو</option>
    //             <option value="CY">قبرص</option>
    //             <option value="CZ">الجمهورية التشيكية</option>
    //             <option value="DK">الدنمارك</option>
    //             <option value="DJ">جيبوتي</option>
    //             <option value="DM">دومينيكا</option>
    //             <option value="DO">جمهورية الدومنيكان</option>
    //             <option value="EC">الاكوادور</option>
    //             <option value="EG">مصر</option>
    //             <option value="SV">السلفادور</option>
    //             <option value="GQ">غينيا الإستوائية</option>
    //             <option value="ER">إريتريا</option>
    //             <option value="EE">إستونيا</option>
    //             <option value="ET">أثيوبيا</option>
    //             <option value="FK">جزر فوكلاند (مالفيناس)</option>
    //             <option value="FO">جزر فاروس</option>
    //             <option value="FJ">فيجي</option>
    //             <option value="FI">فنلندا</option>
    //             <option value="FR">فرنسا</option>
    //             <option value="GF">غيانا الفرنسية</option>
    //             <option value="PF">بولينيزيا الفرنسية</option>
    //             <option value="TF">المناطق الجنوبية لفرنسا</option>
    //             <option value="GA">الجابون</option>
    //             <option value="GM">غامبيا</option>
    //             <option value="GE">جورجيا</option>
    //             <option value="DE">ألمانيا</option>
    //             <option value="GH">غانا</option>
    //             <option value="GI">جبل طارق</option>
    //             <option value="GR">اليونان</option>
    //             <option value="GL">الأرض الخضراء</option>
    //             <option value="GD">غرينادا</option>
    //             <option value="GP">جوادلوب</option>
    //             <option value="GU">غوام</option>
    //             <option value="GT">غواتيمالا</option>
    //             <option value="GG">غيرنسي</option>
    //             <option value="GN">غينيا</option>
    //             <option value="GW">غينيا بيساو</option>
    //             <option value="GY">غيانا</option>
    //             <option value="HT">هايتي</option>
    //             <option value="HM">قلب الجزيرة وجزر ماكدونالز</option>
    //             <option value="VA">الكرسي الرسولي (دولة الفاتيكان)</option>
    //             <option value="HN">هندوراس</option>
    //             <option value="HK">هونج كونج</option>
    //             <option value="HU">هنغاريا</option>
    //             <option value="IS">أيسلندا</option>
    //             <option value="IN">الهند</option>
    //             <option value="ID">إندونيسيا</option>
    //             <option value="IR">جمهورية إيران الإسلامية</option>
    //             <option value="IQ">العراق</option>
    //             <option value="IE">أيرلندا</option>
    //             <option value="IM">جزيرة آيل أوف مان</option>
    //             <option value="IL">إسرائيل</option>
    //             <option value="IT">إيطاليا</option>
    //             <option value="JM">جامايكا</option>
    //             <option value="JP">اليابان</option>
    //             <option value="JE">جيرسي</option>
    //             <option value="JO">المملكة الاردنية الهاشمية</option>
    //             <option value="KZ">كازاخستان</option>
    //             <option value="KE">كينيا</option>
    //             <option value="KI">كيريباتي</option>
    //             <option value="KP">كوريا، الجمهورية الشعبية الديمقراطية</option>
    //             <option value="KR">جمهورية كوريا</option>
    //             <option value="XK">كوسوفو</option>
    //             <option value="KW">الكويت</option>
    //             <option value="KG">قيرغيزستان</option>
    //             <option value="LA">جمهورية لاو الديمقراطية الشعبية</option>
    //             <option value="LV">لاتفيا</option>
    //             <option value="LB">لبنان</option>
    //             <option value="LS">ليسوتو</option>
    //             <option value="LR">ليبيريا</option>
    //             <option value="LY">الجماهيرية العربية الليبية</option>
    //             <option value="LI">ليختنشتاين</option>
    //             <option value="LT">ليتوانيا</option>
    //             <option value="LU">لوكسمبورغ</option>
    //             <option value="MO">ماكاو</option>
    //             <option value="MK">مقدونيا ، جمهورية يوغوسلافيا السابقة</option>
    //             <option value="MG">مدغشقر</option>
    //             <option value="MW">ملاوي</option>
    //             <option value="MY">ماليزيا</option>
    //             <option value="MV">جزر المالديف</option>
    //             <option value="ML">مالي</option>
    //             <option value="MT">مالطا</option>
    //             <option value="MH">جزر مارشال</option>
    //             <option value="MQ">مارتينيك</option>
    //             <option value="MR">موريتانيا</option>
    //             <option value="MU">موريشيوس</option>
    //             <option value="YT">مايوت</option>
    //             <option value="MX">المكسيك</option>
    //             <option value="FM">ولايات ميكرونيزيا الموحدة</option>
    //             <option value="MD">جمهورية مولدوفا</option>
    //             <option value="MC">موناكو</option>
    //             <option value="MN">منغوليا</option>
    //             <option value="ME">الجبل الأسود</option>
    //             <option value="MS">مونتسيرات</option>
    //             <option value="MA">المغرب</option>
    //             <option value="MZ">موزمبيق</option>
    //             <option value="MM">ميانمار</option>
    //             <option value="NA">ناميبيا</option>
    //             <option value="NR">ناورو</option>
    //             <option value="NP">نيبال</option>
    //             <option value="NL">هولندا</option>
    //             <option value="AN">جزر الأنتيل الهولندية</option>
    //             <option value="NC">كاليدونيا الجديدة</option>
    //             <option value="NZ">نيوزيلاندا</option>
    //             <option value="NI">نيكاراغوا</option>
    //             <option value="NE">النيجر</option>
    //             <option value="NG">نيجيريا</option>
    //             <option value="NU">نيوي</option>
    //             <option value="NF">جزيرة نورفولك</option>
    //             <option value="MP">جزر مريانا الشمالية</option>
    //             <option value="NO">النرويج</option>
    //             <option value="OM">سلطنة عمان</option>
    //             <option value="PK">باكستان</option>
    //             <option value="PW">بالاو</option>
    //             <option value="PS">الأراضي الفلسطينية المحتلة</option>
    //             <option value="PA">بنما</option>
    //             <option value="PG">بابوا غينيا الجديدة</option>
    //             <option value="PY">باراغواي</option>
    //             <option value="PE">بيرو</option>
    //             <option value="PH">فيلبيني</option>
    //             <option value="PN">بيتكيرن</option>
    //             <option value="PL">بولندا</option>
    //             <option value="PT">البرتغال</option>
    //             <option value="PR">بورتوريكو</option>
    //             <option value="QA">دولة قطر</option>
    //             <option value="RE">جمع شمل</option>
    //             <option value="RO">رومانيا</option>
    //             <option value="RU">الاتحاد الروسي</option>
    //             <option value="RW">رواندا</option>
    //             <option value="BL">سانت بارتيليمي</option>
    //             <option value="SH">سانت هيلانة</option>
    //             <option value="KN">سانت كيتس ونيفيس</option>
    //             <option value="LC">القديسة لوسيا</option>
    //             <option value="MF">القديس مارتن</option>
    //             <option value="PM">سانت بيير وميكلون</option>
    //             <option value="VC">سانت فنسنت وجزر غرينادين</option>
    //             <option value="WS">ساموا</option>
    //             <option value="SM">سان مارينو</option>
    //             <option value="ST">ساو تومي وبرينسيبي</option>
    //             <option value="SA">المملكة العربية السعودية</option>
    //             <option value="SN">السنغال</option>
    //             <option value="RS">صربيا</option>
    //             <option value="CS">صربيا والجبل الأسود</option>
    //             <option value="SC">سيشيل</option>
    //             <option value="SL">سيرا ليون</option>
    //             <option value="SG">سنغافورة</option>
    //             <option value="SX">سينت مارتن</option>
    //             <option value="SK">سلوفاكيا</option>
    //             <option value="SI">سلوفينيا</option>
    //             <option value="SB">جزر سليمان</option>
    //             <option value="SO">الصومال</option>
    //             <option value="ZA">جنوب أفريقيا</option>
    //             <option value="GS">جورجيا الجنوبية وجزر ساندويتش الجنوبية</option>
    //             <option value="SS">جنوب السودان</option>
    //             <option value="ES">إسبانيا</option>
    //             <option value="LK">سيريلانكا</option>
    //             <option value="SD">السودان</option>
    //             <option value="SR">سورينام</option>
    //             <option value="SJ">سفالبارد وجان ماين</option>
    //             <option value="SZ">سوازيلاند</option>
    //             <option value="SE">السويد</option>
    //             <option value="CH">سويسرا</option>
    //             <option value="SY">الجمهورية العربية السورية</option>
    //             <option value="TW">مقاطعة تايوان الصينية</option>
    //             <option value="TJ">طاجيكستان</option>
    //             <option value="TZ">جمهورية تنزانيا المتحدة</option>
    //             <option value="TH">تايلاند</option>
    //             <option value="TL">تيمور ليشتي</option>
    //             <option value="TG">توجو</option>
    //             <option value="TK">توكيلاو</option>
    //             <option value="TO">تونغا</option>
    //             <option value="TT">ترينداد وتوباغو</option>
    //             <option value="TN">تونس</option>
    //             <option value="TR">ديك رومى</option>
    //             <option value="TM">تركمانستان</option>
    //             <option value="TC">جزر تركس وكايكوس</option>
    //             <option value="TV">توفالو</option>
    //             <option value="UG">أوغندا</option>
    //             <option value="UA">أوكرانيا</option>
    //             <option value="GB">المملكة المتحدة</option>
    //             <option value="US">الولايات المتحدة</option>
    //             <option value="UM">جزر الولايات المتحدة البعيدة الصغرى</option>
    //             <option value="UY">أوروغواي</option>
    //             <option value="UZ">أوزبكستان</option>
    //             <option value="VU">فانواتو</option>
    //             <option value="VE">فنزويلا</option>
    //             <option value="VN">فييت نام</option>
    //             <option value="VG">جزر العذراء البريطانية</option>
    //             <option value="VI">جزر فيرجن ، الولايات المتحدة</option>
    //             <option value="WF">واليس وفوتونا</option>
    //             <option value="EH">الصحراء الغربية</option>
    //             <option value="YE">اليمن</option>
    //             <option value="ZM">زامبيا</option>
    //             <option value="ZW">زيمبابوي</option>
    //         </select>';
    // }

    // public function emirates_dropdown_arabic ($control_name, $required=false) {
    //     $required = $required === true ? 'required' : '';
    //     return '<select name="' . $control_name . '" id="' . $control_name . '" tabindex="" class="form-control"' . $required . ' style="direction: rtl">
    //                 <option value="">----------</option>
    //                 <option value="AUH">أبوظبي</option>
    //                 <option value="DXB">دبي</option>
    //                 <option value="SHJ">الشارقة</option>
    //                 <option value="AJM">عجمان</option>
    //                 <option value="UAQ">أم القيوين</option>
    //                 <option value="RAK">رأس الخيمة</option>
    //                 <option value="FUJ">الفجيرة</option>
    //             </select>';
    // }

}