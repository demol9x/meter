<?php
\Yii::$app->session->open();

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = Yii::t('app','create_shop');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-page-store">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md12 col-sm-12 col-xs-12">
                <div class="form-create-store">
                    <div class="title-form">
                        <h2>
                            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> 
                            <?= $this->title ?>
                        </h2>
                    </div>
                    <?php if(isset($_SESSION['create_shop'])) { ?>
                        <div class="list-process-payment" style="border-bottom: none;">
                            <ul>
                                <li class="active">
                                    <a href="">
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-1.png" alt="">
                                        <span><?=  Yii::t('app', 'signup_user')  ?></span>
                                    </a>
                                </li>
                                <li class="active current">
                                    <a href="">
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-2.png" alt="">
                                        <span><?=  Yii::t('app', 'enter_info')  ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-3.png" alt="">
                                        <span><?=  Yii::t('app', 'enter_auth')  ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    <!-- <div class="ctn-form form-buywith-gca">
                        <div class="item-input-form">
                            <label for="">Loại hình kinh doanh <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="flex">
                                    <div class="awe-check">
                                        <div class="radio">
                                            <input type="radio" class="" name="sex" checked="checked">
                                            <label><span class="text-clip" title="Cá nhân">Cá nhân</span></label>
                                        </div>
                                        <div class="radio">
                                            <input type="radio" class="" name="sex">
                                            <label><span class="text-clip" title="Công ty / hộ kinh doanh">Công ty / hộ kinh doanh</span></label>
                                        </div>
                                    </div>
                                    <div class="note-check">
                                        <p>
                                            Cá nhân từ 18 tuổi trở lên và có CMTND còn thời hạn
                                        </p>
                                        <p>
                                            Cần có giấy phép đăng ký kinh doanh còn thời hạn và ngành hàng kinh doanh bán lẻ !
                                        </p>
                                        <em>
                                            Lưu ý 1 GPKD chỉ được đăng kí 1 gian hàng.
                                        </em>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Quốc gia <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="full-input">
                                    <select>
                                        <option value="ISO 3166-2:AF">Afghanistan</option>
                                        <option value="ISO 3166-2:AX">Åland Islands</option>
                                        <option value="ISO 3166-2:AL">Albania</option>
                                        <option value="ISO 3166-2:DZ">Algeria</option>
                                        <option value="ISO 3166-2:AS">American Samoa</option>
                                        <option value="ISO 3166-2:AD">Andorra</option>
                                        <option value="ISO 3166-2:AO">Angola</option>
                                        <option value="ISO 3166-2:AI">Anguilla</option>
                                        <option value="ISO 3166-2:AQ">Antarctica</option>
                                        <option value="ISO 3166-2:AG">Antigua and Barbuda</option>
                                        <option value="ISO 3166-2:AR">Argentina</option>
                                        <option value="ISO 3166-2:AM">Armenia</option>
                                        <option value="ISO 3166-2:AW">Aruba</option>
                                        <option value="ISO 3166-2:AU">Australia</option>
                                        <option value="ISO 3166-2:AT">Austria</option>
                                        <option value="ISO 3166-2:AZ">Azerbaijan</option>
                                        <option value="ISO 3166-2:BS">Bahamas</option>
                                        <option value="ISO 3166-2:BH">Bahrain</option>
                                        <option value="ISO 3166-2:BD">Bangladesh</option>
                                        <option value="ISO 3166-2:BB">Barbados</option>
                                        <option value="ISO 3166-2:BY">Belarus</option>
                                        <option value="ISO 3166-2:BE">Belgium</option>
                                        <option value="ISO 3166-2:BZ">Belize</option>
                                        <option value="ISO 3166-2:BJ">Benin</option>
                                        <option value="ISO 3166-2:BM">Bermuda</option>
                                        <option value="ISO 3166-2:BT">Bhutan</option>
                                        <option value="ISO 3166-2:BO">Bolivia, Plurinational State of</option>
                                        <option value="ISO 3166-2:BQ">Bonaire, Sint Eustatius and Saba</option>
                                        <option value="ISO 3166-2:BA">Bosnia and Herzegovina</option>
                                        <option value="ISO 3166-2:BW">Botswana</option>
                                        <option value="ISO 3166-2:BV">Bouvet Island</option>
                                        <option value="ISO 3166-2:BR">Brazil</option>
                                        <option value="ISO 3166-2:IO">British Indian Ocean Territory</option>
                                        <option value="ISO 3166-2:BN">Brunei Darussalam</option>
                                        <option value="ISO 3166-2:BG">Bulgaria</option>
                                        <option value="ISO 3166-2:BF">Burkina Faso</option>
                                        <option value="ISO 3166-2:BI">Burundi</option>
                                        <option value="ISO 3166-2:KH">Cambodia</option>
                                        <option value="ISO 3166-2:CM">Cameroon</option>
                                        <option value="ISO 3166-2:CA">Canada</option>
                                        <option value="ISO 3166-2:CV">Cape Verde</option>
                                        <option value="ISO 3166-2:KY">Cayman Islands</option>
                                        <option value="ISO 3166-2:CF">Central African Republic</option>
                                        <option value="ISO 3166-2:TD">Chad</option>
                                        <option value="ISO 3166-2:CL">Chile</option>
                                        <option value="ISO 3166-2:CN">China</option>
                                        <option value="ISO 3166-2:CX">Christmas Island</option>
                                        <option value="ISO 3166-2:CC">Cocos (Keeling) Islands</option>
                                        <option value="ISO 3166-2:CO">Colombia</option>
                                        <option value="ISO 3166-2:KM">Comoros</option>
                                        <option value="ISO 3166-2:CG">Congo</option>
                                        <option value="ISO 3166-2:CD">Congo, the Democratic Republic of the</option>
                                        <option value="ISO 3166-2:CK">Cook Islands</option>
                                        <option value="ISO 3166-2:CR">Costa Rica</option>
                                        <option value="ISO 3166-2:CI">Côte d'Ivoire</option>
                                        <option value="ISO 3166-2:HR">Croatia</option>
                                        <option value="ISO 3166-2:CU">Cuba</option>
                                        <option value="ISO 3166-2:CW">Curaçao</option>
                                        <option value="ISO 3166-2:CY">Cyprus</option>
                                        <option value="ISO 3166-2:CZ">Czech Republic</option>
                                        <option value="ISO 3166-2:DK">Denmark</option>
                                        <option value="ISO 3166-2:DJ">Djibouti</option>
                                        <option value="ISO 3166-2:DM">Dominica</option>
                                        <option value="ISO 3166-2:DO">Dominican Republic</option>
                                        <option value="ISO 3166-2:EC">Ecuador</option>
                                        <option value="ISO 3166-2:EG">Egypt</option>
                                        <option value="ISO 3166-2:SV">El Salvador</option>
                                        <option value="ISO 3166-2:GQ">Equatorial Guinea</option>
                                        <option value="ISO 3166-2:ER">Eritrea</option>
                                        <option value="ISO 3166-2:EE">Estonia</option>
                                        <option value="ISO 3166-2:ET">Ethiopia</option>
                                        <option value="ISO 3166-2:FK">Falkland Islands (Malvinas)</option>
                                        <option value="ISO 3166-2:FO">Faroe Islands</option>
                                        <option value="ISO 3166-2:FJ">Fiji</option>
                                        <option value="ISO 3166-2:FI">Finland</option>
                                        <option value="ISO 3166-2:FR">France</option>
                                        <option value="ISO 3166-2:GF">French Guiana</option>
                                        <option value="ISO 3166-2:PF">French Polynesia</option>
                                        <option value="ISO 3166-2:TF">French Southern Territories</option>
                                        <option value="ISO 3166-2:GA">Gabon</option>
                                        <option value="ISO 3166-2:GM">Gambia</option>
                                        <option value="ISO 3166-2:GE">Georgia</option>
                                        <option value="ISO 3166-2:DE">Germany</option>
                                        <option value="ISO 3166-2:GH">Ghana</option>
                                        <option value="ISO 3166-2:GI">Gibraltar</option>
                                        <option value="ISO 3166-2:GR">Greece</option>
                                        <option value="ISO 3166-2:GL">Greenland</option>
                                        <option value="ISO 3166-2:GD">Grenada</option>
                                        <option value="ISO 3166-2:GP">Guadeloupe</option>
                                        <option value="ISO 3166-2:GU">Guam</option>
                                        <option value="ISO 3166-2:GT">Guatemala</option>
                                        <option value="ISO 3166-2:GG">Guernsey</option>
                                        <option value="ISO 3166-2:GN">Guinea</option>
                                        <option value="ISO 3166-2:GW">Guinea-Bissau</option>
                                        <option value="ISO 3166-2:GY">Guyana</option>
                                        <option value="ISO 3166-2:HT">Haiti</option>
                                        <option value="ISO 3166-2:HM">Heard Island and McDonald Islands</option>
                                        <option value="ISO 3166-2:VA">Holy See (Vatican City State)</option>
                                        <option value="ISO 3166-2:HN">Honduras</option>
                                        <option value="ISO 3166-2:HK">Hong Kong</option>
                                        <option value="ISO 3166-2:HU">Hungary</option>
                                        <option value="ISO 3166-2:IS">Iceland</option>
                                        <option value="ISO 3166-2:IN">India</option>
                                        <option value="ISO 3166-2:ID">Indonesia</option>
                                        <option value="ISO 3166-2:IR">Iran, Islamic Republic of</option>
                                        <option value="ISO 3166-2:IQ">Iraq</option>
                                        <option value="ISO 3166-2:IE">Ireland</option>
                                        <option value="ISO 3166-2:IM">Isle of Man</option>
                                        <option value="ISO 3166-2:IL">Israel</option>
                                        <option value="ISO 3166-2:IT">Italy</option>
                                        <option value="ISO 3166-2:JM">Jamaica</option>
                                        <option value="ISO 3166-2:JP">Japan</option>
                                        <option value="ISO 3166-2:JE">Jersey</option>
                                        <option value="ISO 3166-2:JO">Jordan</option>
                                        <option value="ISO 3166-2:KZ">Kazakhstan</option>
                                        <option value="ISO 3166-2:KE">Kenya</option>
                                        <option value="ISO 3166-2:KI">Kiribati</option>
                                        <option value="ISO 3166-2:KP">Korea, Democratic People's Republic of</option>
                                        <option value="ISO 3166-2:KR">Korea, Republic of</option>
                                        <option value="ISO 3166-2:KW">Kuwait</option>
                                        <option value="ISO 3166-2:KG">Kyrgyzstan</option>
                                        <option value="ISO 3166-2:LA">Lao People's Democratic Republic</option>
                                        <option value="ISO 3166-2:LV">Latvia</option>
                                        <option value="ISO 3166-2:LB">Lebanon</option>
                                        <option value="ISO 3166-2:LS">Lesotho</option>
                                        <option value="ISO 3166-2:LR">Liberia</option>
                                        <option value="ISO 3166-2:LY">Libya</option>
                                        <option value="ISO 3166-2:LI">Liechtenstein</option>
                                        <option value="ISO 3166-2:LT">Lithuania</option>
                                        <option value="ISO 3166-2:LU">Luxembourg</option>
                                        <option value="ISO 3166-2:MO">Macao</option>
                                        <option value="ISO 3166-2:MK">Macedonia, the former Yugoslav Republic of</option>
                                        <option value="ISO 3166-2:MG">Madagascar</option>
                                        <option value="ISO 3166-2:MW">Malawi</option>
                                        <option value="ISO 3166-2:MY">Malaysia</option>
                                        <option value="ISO 3166-2:MV">Maldives</option>
                                        <option value="ISO 3166-2:ML">Mali</option>
                                        <option value="ISO 3166-2:MT">Malta</option>
                                        <option value="ISO 3166-2:MH">Marshall Islands</option>
                                        <option value="ISO 3166-2:MQ">Martinique</option>
                                        <option value="ISO 3166-2:MR">Mauritania</option>
                                        <option value="ISO 3166-2:MU">Mauritius</option>
                                        <option value="ISO 3166-2:YT">Mayotte</option>
                                        <option value="ISO 3166-2:MX">Mexico</option>
                                        <option value="ISO 3166-2:FM">Micronesia, Federated States of</option>
                                        <option value="ISO 3166-2:MD">Moldova, Republic of</option>
                                        <option value="ISO 3166-2:MC">Monaco</option>
                                        <option value="ISO 3166-2:MN">Mongolia</option>
                                        <option value="ISO 3166-2:ME">Montenegro</option>
                                        <option value="ISO 3166-2:MS">Montserrat</option>
                                        <option value="ISO 3166-2:MA">Morocco</option>
                                        <option value="ISO 3166-2:MZ">Mozambique</option>
                                        <option value="ISO 3166-2:MM">Myanmar</option>
                                        <option value="ISO 3166-2:NA">Namibia</option>
                                        <option value="ISO 3166-2:NR">Nauru</option>
                                        <option value="ISO 3166-2:NP">Nepal</option>
                                        <option value="ISO 3166-2:NL">Netherlands</option>
                                        <option value="ISO 3166-2:NC">New Caledonia</option>
                                        <option value="ISO 3166-2:NZ">New Zealand</option>
                                        <option value="ISO 3166-2:NI">Nicaragua</option>
                                        <option value="ISO 3166-2:NE">Niger</option>
                                        <option value="ISO 3166-2:NG">Nigeria</option>
                                        <option value="ISO 3166-2:NU">Niue</option>
                                        <option value="ISO 3166-2:NF">Norfolk Island</option>
                                        <option value="ISO 3166-2:MP">Northern Mariana Islands</option>
                                        <option value="ISO 3166-2:NO">Norway</option>
                                        <option value="ISO 3166-2:OM">Oman</option>
                                        <option value="ISO 3166-2:PK">Pakistan</option>
                                        <option value="ISO 3166-2:PW">Palau</option>
                                        <option value="ISO 3166-2:PS">Palestinian Territory, Occupied</option>
                                        <option value="ISO 3166-2:PA">Panama</option>
                                        <option value="ISO 3166-2:PG">Papua New Guinea</option>
                                        <option value="ISO 3166-2:PY">Paraguay</option>
                                        <option value="ISO 3166-2:PE">Peru</option>
                                        <option value="ISO 3166-2:PH">Philippines</option>
                                        <option value="ISO 3166-2:PN">Pitcairn</option>
                                        <option value="ISO 3166-2:PL">Poland</option>
                                        <option value="ISO 3166-2:PT">Portugal</option>
                                        <option value="ISO 3166-2:PR">Puerto Rico</option>
                                        <option value="ISO 3166-2:QA">Qatar</option>
                                        <option value="ISO 3166-2:RE">Réunion</option>
                                        <option value="ISO 3166-2:RO">Romania</option>
                                        <option value="ISO 3166-2:RU">Russian Federation</option>
                                        <option value="ISO 3166-2:RW">Rwanda</option>
                                        <option value="ISO 3166-2:BL">Saint Barthélemy</option>
                                        <option value="ISO 3166-2:SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                        <option value="ISO 3166-2:KN">Saint Kitts and Nevis</option>
                                        <option value="ISO 3166-2:LC">Saint Lucia</option>
                                        <option value="ISO 3166-2:MF">Saint Martin (French part)</option>
                                        <option value="ISO 3166-2:PM">Saint Pierre and Miquelon</option>
                                        <option value="ISO 3166-2:VC">Saint Vincent and the Grenadines</option>
                                        <option value="ISO 3166-2:WS">Samoa</option>
                                        <option value="ISO 3166-2:SM">San Marino</option>
                                        <option value="ISO 3166-2:ST">Sao Tome and Principe</option>
                                        <option value="ISO 3166-2:SA">Saudi Arabia</option>
                                        <option value="ISO 3166-2:SN">Senegal</option>
                                        <option value="ISO 3166-2:RS">Serbia</option>
                                        <option value="ISO 3166-2:SC">Seychelles</option>
                                        <option value="ISO 3166-2:SL">Sierra Leone</option>
                                        <option value="ISO 3166-2:SG">Singapore</option>
                                        <option value="ISO 3166-2:SX">Sint Maarten (Dutch part)</option>
                                        <option value="ISO 3166-2:SK">Slovakia</option>
                                        <option value="ISO 3166-2:SI">Slovenia</option>
                                        <option value="ISO 3166-2:SB">Solomon Islands</option>
                                        <option value="ISO 3166-2:SO">Somalia</option>
                                        <option value="ISO 3166-2:ZA">South Africa</option>
                                        <option value="ISO 3166-2:GS">South Georgia and the South Sandwich Islands</option>
                                        <option value="ISO 3166-2:SS">South Sudan</option>
                                        <option value="ISO 3166-2:ES">Spain</option>
                                        <option value="ISO 3166-2:LK">Sri Lanka</option>
                                        <option value="ISO 3166-2:SD">Sudan</option>
                                        <option value="ISO 3166-2:SR">Suriname</option>
                                        <option value="ISO 3166-2:SJ">Svalbard and Jan Mayen</option>
                                        <option value="ISO 3166-2:SZ">Swaziland</option>
                                        <option value="ISO 3166-2:SE">Sweden</option>
                                        <option value="ISO 3166-2:CH">Switzerland</option>
                                        <option value="ISO 3166-2:SY">Syrian Arab Republic</option>
                                        <option value="ISO 3166-2:TW">Taiwan, Province of China</option>
                                        <option value="ISO 3166-2:TJ">Tajikistan</option>
                                        <option value="ISO 3166-2:TZ">Tanzania, United Republic of</option>
                                        <option value="ISO 3166-2:TH">Thailand</option>
                                        <option value="ISO 3166-2:TL">Timor-Leste</option>
                                        <option value="ISO 3166-2:TG">Togo</option>
                                        <option value="ISO 3166-2:TK">Tokelau</option>
                                        <option value="ISO 3166-2:TO">Tonga</option>
                                        <option value="ISO 3166-2:TT">Trinidad and Tobago</option>
                                        <option value="ISO 3166-2:TN">Tunisia</option>
                                        <option value="ISO 3166-2:TR">Turkey</option>
                                        <option value="ISO 3166-2:TM">Turkmenistan</option>
                                        <option value="ISO 3166-2:TC">Turks and Caicos Islands</option>
                                        <option value="ISO 3166-2:TV">Tuvalu</option>
                                        <option value="ISO 3166-2:UG">Uganda</option>
                                        <option value="ISO 3166-2:UA">Ukraine</option>
                                        <option value="ISO 3166-2:AE">United Arab Emirates</option>
                                        <option value="ISO 3166-2:GB">United Kingdom</option>
                                        <option value="ISO 3166-2:US">United States</option>
                                        <option value="ISO 3166-2:UM">United States Minor Outlying Islands</option>
                                        <option value="ISO 3166-2:UY">Uruguay</option>
                                        <option value="ISO 3166-2:UZ">Uzbekistan</option>
                                        <option value="ISO 3166-2:VU">Vanuatu</option>
                                        <option value="ISO 3166-2:VE">Venezuela, Bolivarian Republic of</option>
                                        <option value="ISO 3166-2:VN" selected="selected">Việt Nam</option>
                                        <option value="ISO 3166-2:VG">Virgin Islands, British</option>
                                        <option value="ISO 3166-2:VI">Virgin Islands, U.S.</option>
                                        <option value="ISO 3166-2:WF">Wallis and Futuna</option>
                                        <option value="ISO 3166-2:EH">Western Sahara</option>
                                        <option value="ISO 3166-2:YE">Yemen</option>
                                        <option value="ISO 3166-2:ZM">Zambia</option>
                                        <option value="ISO 3166-2:ZW">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Số điện thoại <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="full-input two-input">
                                    <input type="text" placeholder="+84" class="location-phone">
                                    <input type="text" placeholder="123 456 789" class="input-phone">
                                    <p>
                                        Vui lòng điền đúng định dạng, không bao gồm số 0 ở đầu tiên. Ví dụ: +84 1681234567
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Tên gian hàng <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="full-input">
                                    <input type="text" placeholder="Nhập tên gian hàng">
                                    <p>
                                        Tên gian hàng chỉ bao gồm các ký từ từ a-z, và các số từ 0-9
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Link gian hàng</label>
                            <div class="group-input">
                                <p>
                                    <a href="">http://www.gcaeco.vn/s/nguyenviethung/</a>
                                </p>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Email <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="full-input">
                                    <input type="text" placeholder="Nhập email">
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Mật khẩu <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="full-input">
                                    <input type="text" placeholder="Nhập Mật khẩu">
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Xác nhận lại mật khẩu <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="full-input">
                                    <input type="text" placeholder="Nhập lại mật khẩu">
                                    <p>
                                        Tối thiểu 8 kí tự, phải bao gồm 1 kí tự chữ, 1 kí tự số, 1 kí tự đặc biệt (!,@,#,...)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form">
                            <label for="">Capcha <span class="required">*</span></label>
                            <div class="group-input">
                                <div class="full-input flex">
                                    <img src="images/capcha.jpg" alt="">
                                    <input style="margin-top: 15px;" type="text" placeholder="Nhập mã capcha">
                                </div>
                            </div>
                        </div>
                        <div class="item-input-form" style="border-top: 1px solid #ebebeb;margin-top: 30px;padding-top: 40px;">
                            <label for=""></label>
                            <div class="group-input">
                                <a href="" class="btn-step-gca">Về trang chủ</a>
                                <div class="btn-submit-form" style="float: left; margin-top: 0px">
                                    <input type="submit" value="Bước tiếp theo">
                                </div>
                            </div>
                        </div>              
                    </div> -->
                    <div class="ctn-form form-buywith-gca">
                        <?= 
                            $this->render('_form', [
                                'model' => $model,
                                'images' => $images,
                                'list_district' => $list_district,
                                'list_ward' => $list_ward,
                                'list_province' => $list_province,
                                'user' => $user
                            ]) 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    <?php if(isset($alert) && $alert) echo "alert('$alert');"; ?>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }
</script>