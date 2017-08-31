<?php include_once('commons/header.php'); ?>

<body>
    <div class="overlay"></div>
    <div class="colours"></div>
    <div class="bgimage"></div>

    <section id="container">

        <div class="start wrap">

            <div class="logo">
                <a href="./" title="THRIVE Student Health Online">
                    <img src="<?php echo BASE_URL; ?>images/logo.png" alt="THRIVE Alcohol Survey" />
                </a>
            </div>

            <h1>Welcome</h1>
            <p>This survey will ask questions about your alcohol and tobacco use and provide you personalized feedback on your drinking. It will take approximately 10 minute to complete.</p>
            <p>The survey is conducted by University of Florida to explore the use of alcohol by college students. Administrators at University of Florida will not be made aware of your responses. Your participation helps us to evaluate the use of Internet-based methods of health promotion and data collection.</p>
            <p>In order for us to personalize this survey for you, please enter a name in the box below.<br>Please do not enter your last name.</p>

            <form method="post" class="stage-form">

                <input type="hidden" name="survey-stage" value="0" />

                <p>(It doesn't have to be your real name!)</p>
                <fieldset title="Please fill in these fields">
                    <legend>Please enter your name to continue</legend>

                    <div class="field">
                        <label for="name">Your name</label>
                        <input type="text" id="name" name="participant_name" />
                    </div>

                    <button type="submit">Let's go! <i class="icn white-arrow"></i></button>

                </fieldset>

                <fieldset class="researcher">
                    <legend>Please indicate whether you are a researcher or health administrator.</legend>

                    <input type="checkbox" name="is_test" id="is_test" value="1" />
                    <label for="is_test">Select this box if you are a researcher or health service administrator reviewing THRIVE for use in your own organisation.</label>

                </fieldset>

            </form>

            <div class="authors">
                <p>The THRIVE program was developed by: Dr Kypros Kypri 1,2, Mr Jonathan Hallett 3,4,5, Professor Peter Howat 3,4,5, Associate Professor Alexandra McManus 5, Professor Bruce Maycock 3,4,5</em></p>
                <ol>
                    <li>School of Medicine and Public Health, University of Newcastle, Australia</li>
                    <li>Injury Prevention Research Unit, University of Otago, New Zealand</li>
                    <li>Western Australian Centre for Health Promotion Research, Curtin University, Perth, Australia</li>
                    <li>Centre for Behavioural Research in Cancer Control, Curtin University, Australia</li>
                    <li>Curtin Health Innovation Research Institute, Curtin University, Perth, Australia</li>
                </ol>
                <p>THRIVE was based on an e-SBI program developed by Dr Kypros Kypri and colleagues at the Injury Prevention Research Unit, University of Otago, and Professor John Saunders of the University of Queensland.</p>
            </div>

        </div><!-- start -->

        <div class="push"></div>

    </section><!-- container -->

    <?php include_once('commons/footer.php'); ?>
