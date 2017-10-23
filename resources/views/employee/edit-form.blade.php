@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('employee.lists')  }}">Employees</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Update Employee</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Register Employee</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.update',['id' => $details->id ]) }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <input type="hidden" name="platform" value="web"/>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                   value="{{ $details->userName }}" name="name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                {{ $errors->first('name') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Email Address</label>
                                        <div class="col-md-7">
                                            <input type="email" class="form-control" placeholder="Enter Email Address"
                                                   value="{{old('email') }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                {{ $errors->first('email') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Mobile No</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Mobile No"
                                                   value="{{ old('mobile_no') }}" name="mobile_no">
                                            @if ($errors->has('mobile_no'))
                                                <span class="help-block">
                                                {{ $errors->first('mobile_no') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('nric_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">NRIC</label>
                                        <div class="col-md-7">
                                            <input disabled type="text" class="form-control" placeholder="Enter NRIC"
                                                   name="nric_no" value="{{ $details->nric_no }}"/>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('nric_no') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Birthdate</label>
                                        <div class="col-md-7">
                                            <div class="input-group date form_datetime form_datetime bs-datetime"
                                                 id="birthdate">
                                                <input type="text" name="birthdate" value="{{ old('birthdate') }}" size="16" class="form-control">
                                                <span class="input-group-addon">
                                                    <button class="btn default date-set" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                                @if ($errors->has('birthdate'))
                                                    <span class="help-block">
                                                {{ $errors->first('birthdate') }}
                                               </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">School</label>
                                        <div class="col-md-7">
                                            <input type="text" value="{{ old('school') }}"class="form-control" placeholder="Enter School"
                                                   name="school"/>
                                            @if ($errors->has('school'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('school') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('school_expiry_date') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">School Expiry Date</label>
                                        <div class="col-md-7">
                                            <div class="input-group date form_datetime form_datetime bs-datetime"
                                                 id="school-expiry-date">
                                                <input type="text" value="{{ old('school_expiry_date') }}"name="school_expiry_date" size="16"
                                                       class="form-control">
                                                <span class="input-group-addon">
                                                    <button class="btn default date-set" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                                @if ($errors->has('school_expiry_date'))
                                                    <span class="help-block">
                                                {{ $errors->first('school_expiry_date') }}
                                               </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Nationality</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="nationality">
                                                <option value="">-- select one --</option>
                                                <option value="afghan">Afghan</option>
                                                <option value="albanian">Albanian</option>
                                                <option value="algerian">Algerian</option>
                                                <option value="american">American</option>
                                                <option value="andorran">Andorran</option>
                                                <option value="angolan">Angolan</option>
                                                <option value="antiguans">Antiguans</option>
                                                <option value="argentinean">Argentinean</option>
                                                <option value="armenian">Armenian</option>
                                                <option value="australian">Australian</option>
                                                <option value="austrian">Austrian</option>
                                                <option value="azerbaijani">Azerbaijani</option>
                                                <option value="bahamian">Bahamian</option>
                                                <option value="bahraini">Bahraini</option>
                                                <option value="bangladeshi">Bangladeshi</option>
                                                <option value="barbadian">Barbadian</option>
                                                <option value="barbudans">Barbudans</option>
                                                <option value="batswana">Batswana</option>
                                                <option value="belarusian">Belarusian</option>
                                                <option value="belgian">Belgian</option>
                                                <option value="belizean">Belizean</option>
                                                <option value="beninese">Beninese</option>
                                                <option value="bhutanese">Bhutanese</option>
                                                <option value="bolivian">Bolivian</option>
                                                <option value="bosnian">Bosnian</option>
                                                <option value="brazilian">Brazilian</option>
                                                <option value="british">British</option>
                                                <option value="bruneian">Bruneian</option>
                                                <option value="bulgarian">Bulgarian</option>
                                                <option value="burkinabe">Burkinabe</option>
                                                <option value="burmese">Burmese</option>
                                                <option value="burundian">Burundian</option>
                                                <option value="cambodian">Cambodian</option>
                                                <option value="cameroonian">Cameroonian</option>
                                                <option value="canadian">Canadian</option>
                                                <option value="cape verdean">Cape Verdean</option>
                                                <option value="central african">Central African</option>
                                                <option value="chadian">Chadian</option>
                                                <option value="chilean">Chilean</option>
                                                <option value="chinese">Chinese</option>
                                                <option value="colombian">Colombian</option>
                                                <option value="comoran">Comoran</option>
                                                <option value="congolese">Congolese</option>
                                                <option value="costa rican">Costa Rican</option>
                                                <option value="croatian">Croatian</option>
                                                <option value="cuban">Cuban</option>
                                                <option value="cypriot">Cypriot</option>
                                                <option value="czech">Czech</option>
                                                <option value="danish">Danish</option>
                                                <option value="djibouti">Djibouti</option>
                                                <option value="dominican">Dominican</option>
                                                <option value="dutch">Dutch</option>
                                                <option value="east timorese">East Timorese</option>
                                                <option value="ecuadorean">Ecuadorean</option>
                                                <option value="egyptian">Egyptian</option>
                                                <option value="emirian">Emirian</option>
                                                <option value="equatorial guinean">Equatorial Guinean</option>
                                                <option value="eritrean">Eritrean</option>
                                                <option value="estonian">Estonian</option>
                                                <option value="ethiopian">Ethiopian</option>
                                                <option value="fijian">Fijian</option>
                                                <option value="filipino">Filipino</option>
                                                <option value="finnish">Finnish</option>
                                                <option value="french">French</option>
                                                <option value="gabonese">Gabonese</option>
                                                <option value="gambian">Gambian</option>
                                                <option value="georgian">Georgian</option>
                                                <option value="german">German</option>
                                                <option value="ghanaian">Ghanaian</option>
                                                <option value="greek">Greek</option>
                                                <option value="grenadian">Grenadian</option>
                                                <option value="guatemalan">Guatemalan</option>
                                                <option value="guinea-bissauan">Guinea-Bissauan</option>
                                                <option value="guinean">Guinean</option>
                                                <option value="guyanese">Guyanese</option>
                                                <option value="haitian">Haitian</option>
                                                <option value="herzegovinian">Herzegovinian</option>
                                                <option value="honduran">Honduran</option>
                                                <option value="hungarian">Hungarian</option>
                                                <option value="icelander">Icelander</option>
                                                <option value="indian">Indian</option>
                                                <option value="indonesian">Indonesian</option>
                                                <option value="iranian">Iranian</option>
                                                <option value="iraqi">Iraqi</option>
                                                <option value="irish">Irish</option>
                                                <option value="israeli">Israeli</option>
                                                <option value="italian">Italian</option>
                                                <option value="ivorian">Ivorian</option>
                                                <option value="jamaican">Jamaican</option>
                                                <option value="japanese">Japanese</option>
                                                <option value="jordanian">Jordanian</option>
                                                <option value="kazakhstani">Kazakhstani</option>
                                                <option value="kenyan">Kenyan</option>
                                                <option value="kittian and nevisian">Kittian and Nevisian</option>
                                                <option value="kuwaiti">Kuwaiti</option>
                                                <option value="kyrgyz">Kyrgyz</option>
                                                <option value="laotian">Laotian</option>
                                                <option value="latvian">Latvian</option>
                                                <option value="lebanese">Lebanese</option>
                                                <option value="liberian">Liberian</option>
                                                <option value="libyan">Libyan</option>
                                                <option value="liechtensteiner">Liechtensteiner</option>
                                                <option value="lithuanian">Lithuanian</option>
                                                <option value="luxembourger">Luxembourger</option>
                                                <option value="macedonian">Macedonian</option>
                                                <option value="malagasy">Malagasy</option>
                                                <option value="malawian">Malawian</option>
                                                <option value="malaysian">Malaysian</option>
                                                <option value="maldivan">Maldivan</option>
                                                <option value="malian">Malian</option>
                                                <option value="maltese">Maltese</option>
                                                <option value="marshallese">Marshallese</option>
                                                <option value="mauritanian">Mauritanian</option>
                                                <option value="mauritian">Mauritian</option>
                                                <option value="mexican">Mexican</option>
                                                <option value="micronesian">Micronesian</option>
                                                <option value="moldovan">Moldovan</option>
                                                <option value="monacan">Monacan</option>
                                                <option value="mongolian">Mongolian</option>
                                                <option value="moroccan">Moroccan</option>
                                                <option value="mosotho">Mosotho</option>
                                                <option value="motswana">Motswana</option>
                                                <option value="mozambican">Mozambican</option>
                                                <option value="namibian">Namibian</option>
                                                <option value="nauruan">Nauruan</option>
                                                <option value="nepalese">Nepalese</option>
                                                <option value="new zealander">New Zealander</option>
                                                <option value="ni-vanuatu">Ni-Vanuatu</option>
                                                <option value="nicaraguan">Nicaraguan</option>
                                                <option value="nigerien">Nigerien</option>
                                                <option value="north korean">North Korean</option>
                                                <option value="northern irish">Northern Irish</option>
                                                <option value="norwegian">Norwegian</option>
                                                <option value="omani">Omani</option>
                                                <option value="pakistani">Pakistani</option>
                                                <option value="palauan">Palauan</option>
                                                <option value="panamanian">Panamanian</option>
                                                <option value="papua new guinean">Papua New Guinean</option>
                                                <option value="paraguayan">Paraguayan</option>
                                                <option value="peruvian">Peruvian</option>
                                                <option value="polish">Polish</option>
                                                <option value="portuguese">Portuguese</option>
                                                <option value="qatari">Qatari</option>
                                                <option value="romanian">Romanian</option>
                                                <option value="russian">Russian</option>
                                                <option value="rwandan">Rwandan</option>
                                                <option value="saint lucian">Saint Lucian</option>
                                                <option value="salvadoran">Salvadoran</option>
                                                <option value="samoan">Samoan</option>
                                                <option value="san marinese">San Marinese</option>
                                                <option value="sao tomean">Sao Tomean</option>
                                                <option value="saudi">Saudi</option>
                                                <option value="scottish">Scottish</option>
                                                <option value="senegalese">Senegalese</option>
                                                <option value="serbian">Serbian</option>
                                                <option value="seychellois">Seychellois</option>
                                                <option value="sierra leonean">Sierra Leonean</option>
                                                <option value="singaporean">Singaporean</option>
                                                <option value="slovakian">Slovakian</option>
                                                <option value="slovenian">Slovenian</option>
                                                <option value="solomon islander">Solomon Islander</option>
                                                <option value="somali">Somali</option>
                                                <option value="south african">South African</option>
                                                <option value="south korean">South Korean</option>
                                                <option value="spanish">Spanish</option>
                                                <option value="sri lankan">Sri Lankan</option>
                                                <option value="sudanese">Sudanese</option>
                                                <option value="surinamer">Surinamer</option>
                                                <option value="swazi">Swazi</option>
                                                <option value="swedish">Swedish</option>
                                                <option value="swiss">Swiss</option>
                                                <option value="syrian">Syrian</option>
                                                <option value="taiwanese">Taiwanese</option>
                                                <option value="tajik">Tajik</option>
                                                <option value="tanzanian">Tanzanian</option>
                                                <option value="thai">Thai</option>
                                                <option value="togolese">Togolese</option>
                                                <option value="tongan">Tongan</option>
                                                <option value="trinidadian or tobagonian">Trinidadian or Tobagonian
                                                </option>
                                                <option value="tunisian">Tunisian</option>
                                                <option value="turkish">Turkish</option>
                                                <option value="tuvaluan">Tuvaluan</option>
                                                <option value="ugandan">Ugandan</option>
                                                <option value="ukrainian">Ukrainian</option>
                                                <option value="uruguayan">Uruguayan</option>
                                                <option value="uzbekistani">Uzbekistani</option>
                                                <option value="venezuelan">Venezuelan</option>
                                                <option value="vietnamese">Vietnamese</option>
                                                <option value="welsh">Welsh</option>
                                                <option value="yemenite">Yemenite</option>
                                                <option value="zambian">Zambian</option>
                                                <option value="zimbabwean">Zimbabwean</option>
                                            </select>

                                            @if ($errors->has('nationality'))
                                                <span class="help-block">
                                                {{ $errors->first('nationality') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Language</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="language">
                                                <option value="">-- select one --</option>
                                                <option value="english">English</option>
                                            </select>

                                            @if ($errors->has('language'))
                                                <span class="help-block">
                                                {{ $errors->first('language') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Religion</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter religion"
                                                   name="religion" value="{{ old('religion') }}"/>
                                            @if ($errors->has('religion'))
                                                <span class="help-block">
                                                    {{ $errors->first('religion') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Gender</label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" id="gender" value="male"> Male
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" id="gender" value="female"> Female
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if ($errors->has('gender'))
                                                <span class="help-block">
                                                {{ $errors->first('gender') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('emergency_contact_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency contact person</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter contact person"
                                                   name="emergency_contact_person" value="{{ old('emergency_contact_person') }}"/>
                                            @if ($errors->has('emergency_contact_person'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_contact_person') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('emergency_contact_person_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency person contact no.</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter emergency contact no."
                                                   name="emergency_contact_person_no" value="{{ old('emergency_contact_person_no') }}"/>
                                            @if ($errors->has('emergency_contact_person_no'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_contact_person_no') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('emergency_person_relationship') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency person relationship</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter emergency person relationship"
                                                   name="emergency_person_relationship" value="{{ old('emergency_person_relationship') }}"/>
                                            @if ($errors->has('emergency_person_relationship'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_person_relationship') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('emergency_person_address') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency person address</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter emergency person address"
                                                   name="emergency_person_address" value="{{ old('emergency_person_address') }}"/>
                                            @if ($errors->has('emergency_person_address'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_person_address') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('contact_method') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact Method</label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox">

                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="sms"
                                                    > Sms
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="phone"

                                                    > Phone
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="email"

                                                    > Email
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="other"
                                                    > Other
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if ($errors->has('contact_method'))
                                                <span class="help-block">
                                                {{ $errors->first('contact_method') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('criminal_record') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Criminal Record</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="criminal_record" rows="3"></textarea>
                                            @if ($errors->has('criminal_record'))
                                                <span class="help-block">
                                                {{ $errors->first('criminal_record') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('medication') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Medication</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="medication" rows="3"></textarea>
                                            @if ($errors->has('medication'))
                                                <span class="help-block">
                                                {{ $errors->first('medication') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="address" rows="3"></textarea>
                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                                {{ $errors->first('address') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Submit</button>
                                            <button type="button" class="btn default">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection