<?php include_once('commons/header.php'); ?>

<body>
    <div class="overlay"></div>
    <div class="colours"></div>
    <div class="bgimage internal"></div>

    <section id="container">
        <div class="survey wrap">
            <div class="logo">
                <a href="./" title="THRIVE Student Health Online">
                    <img src="<?php echo BASE_URL; ?>images/logo.png" class="hide-mob-lnd-prt" alt="THRIVE Alcohol Survey" />
                    <img src="<?php echo BASE_URL; ?>images/logo-mobile.png" class="mob-lnd-prt" alt="THRIVE Alcohol Survey" />
                </a>
            </div>

            <p class="title"><strong>Alcohol Survey</strong></p>

            <div class="content">
                <section class="progress step-one">
                    <div class="line"></div>
                    <div class="line current-pos"></div>
                    <div class="step hi"><i class="icn"></i></div>
                    <div class="step s-one"><i class="icn"></i><span>All about you</span><i class="icn arrow"></i></div>
                    <div class="step s-two"><i class="icn s2"></i></div>
                    <div class="step s-three"><i class="icn s3"></i></div>
                    <div class="step s-four"><i class="icn s4"></i></div>
                    <div class="step s-five"><i class="icn s5"></i></div>
                </section><!-- progress -->

                <section class="intro">
                    <h1>All about you</h1>
                    <p>Thanks, <?php echo h(ifne($page_meta, 'participant_name')); ?>. First of all we'd like to know a little bit more about you...</p>
                </section><!-- intro -->

                <section class="questions">
                    <form class="stage-form" method="post" action="survey.php?t=<?php echo h(urlencode(ifne($page_meta, 'token'))); ?>">
                        <input type="hidden" name="survey-stage" value="1" />
                        <fieldset title="Please fill in the fields below">
                            <legend>Please fill in these details about yourself.</legend>

                            <div class="field gender radio-set clearfix">
                                <i class="icn number">01</i>

                                <p>Gender?</p>
                                <div class="gender-wrap">
                                    <i class="icn female"></i>
                                    <div class="input-wrap female">
                                        <input type="radio" name="gender-mf" id="gender-female"value="Female">
                                        <label for="gender-female">Female</label>
                                    </div>
                                    <i class="icn male"></i>
                                    <div class="input-wrap male">
                                        <input type="radio" name="gender-mf" id="gender-male" value="Male">
                                        <label for="gender-male">Male</label>
                                    </div>
                                    <div class="select styled">
                                        <select name="gender-more" title="If other, please select from the following options.">
                                            <option value="">Select more options</option>
                                            <option value="transgender-ftm">Transgender or transexual FtM</option>
                                            <option value="transgender-mtf">Transgender or transexual MtF</option>
                                            <option value="genderqueer">Genderqueer</option>
                                            <option value="androgynous">Androgynous</option>
                                            <option value="intersex">Intersex</option>
                                        </select>
                                    </div>
                                </div><!-- gender-wrap -->
                            </div><!-- field -->

                            <div class="field age select-right">
                                <i class="icn number">02</i>
                                <p>How old are you?</p>
                                <div class="select styled">
                                    <select name="age" id="age" title="Please select your age from the drop down.">
                                        <option value="">Please select</option>
                                        <?php foreach (range(18, 24) as $i): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- field -->

                            <div class="field race radio-set clearfix">
                                <i class="icn number">03</i>
                                <p>Which of the following best describes your race?</p>
                                <div class="select styled">
                                    <select name="race" id="race">
                                        <option value="">Please select</option>
                                        <option value="American Indian or Alaskan Native"> American Indian or Alaskan Native</option>
                                        <option value="Asian">Asian</option>
                                        <option value="Native Hawaiian or Other Pacific Islander">Native Hawaiian or Other Pacific Islander</option>
                                        <option value="Black or African American">Black or African American</option>
                                        <option value="White/Caucasian">White/Caucasian</option>
                                        <option value="Mixed Race">Mixed Race</option>
                                        <option value="Other">Other</option>
                                        <option value="I Choose Not to Answer">I Choose Not to Answer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="field ethnicity">
                                <i class="icn number">04</i>
                                <p>What is your ethnicity?</p>
                                <div class="select styled">
                                    <select name="ethnicity" id="ethnicity">
                                        <option value="">Please select</option>
                                        <option value="Hispanic or Latino(a)">Hispanic or Latino(a)</option>
                                        <option value="Not Hispanic or Latino(a)">Not Hispanic or Latino(a)</option>
                                        <option value="I Choose Not to Answer">I Choose Not to Answer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="field where select-left" id="on-campus-wrapper">
                                <i class="icn number">05</i>
                                <p>Where are you living right now?</p>
                                <div class="select styled">
                                    <select name="where" id="where">
                                        <option value="">Please select</option>
                                        <option value="dorm">Dorm</option>
                                        <option value="Apartment or house with parents or other relatives">Apartment or house with parents or other relatives</option>
                                        <option value="Apartment or house with friends or roommates">Apartment or house with friends or roommates</option>
                                    </select>
                                </div>
                                <i class="icn accom"></i>
                            </div><!-- field -->

                            <div class="field class-hours radio-set radios-left clearfix">
                                <i class="icn number">06</i>
                                <p>Did either of your parents graduate from a 4-year college? (Please include biological parents, guardians and step-parents.)</p>
                                <div class="input-wrap">
                                    <input type="radio" name="parents" id="parents-yes" value="yes">
                                    <label for="parents-yes">Yes</label>
                                    <input type="radio" name="parents" id="parents-no" value="no">
                                    <label for="parents-no">No</label>
                                </div>
                                <i class="icn books"></i>
                            </div><!-- field -->

                            <div class="field where">
                                <i class="icn number">07</i>
                                <p>Have you attended only UF or did you transfer in from another college or university? </p>
                                <div class="select styled">
                                    <select name="history" id="history">
                                        <option value="">Please select</option>
                                        <option value="I have attended only Albertus">I have attended only UF</option>
                                        <option value="I transferred from another college/university">I transferred from another college/university</option>
                                    </select>
                                </div>
                            </div><!-- field -->

                            <div class="field submit">
                                <p class="incomplete"><i class="icn cross"></i> Please answer all questions</p>
                                <p class="complete" style="display: none;"><i class="icn tick"></i> All questions have been answered</p>
                                <button type="submit">Next section</button>
                            </div>
                        </fieldset>
                    </form>
                </section><!-- questions -->
            </div><!-- content -->
        </div><!-- survey wrap -->
        <div class="push"></div>
    </section><!-- container -->

    <?php include_once('commons/footer.php'); ?>
