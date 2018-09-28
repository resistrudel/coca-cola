<footer role="contentinfo">
    <div class="wrapper">
        <p><a href="http://www.Global.com/" target="_blank">Global</a> &copy; <?= date("Y") ?></p>
        <p>©2017 The Coca-Cola Company. All rights reserved. COCA-COLA, COCA-COLA ZERO, DIET COKE, TASTE THE FEELING and the CONTOUR BOTTLE design are registered trademarks of The Coca-Cola Company.</p>
    </div>
</footer>
</div><!-- end of #frame -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>if (!window.jQuery) {document.write('<script src="scripts/lib/jquery.min.js"><\/script>');}</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php if (isset($security)) {
    echo '<script type="text/javascript">var t_="', $security->getPhpLabel(), '", j_="', $security->getJsLabel(), '";</script>';
} ?>

<script type="text/javascript" src="scripts/js.min.js"></script>
<script src="//cdn.gigya.com/js/gigya.js?apiKey=<?= $derrick_API_key ?>"></script>
<script src="/_shared/scripts/derrick.social.v3.js"></script>

<!--<script>-->
<!--    function doParallaxCalc() {-->
<!--        var topDist = $(document).scrollTop();-->
<!--        console.log(topDist);-->
<!--//        $('.bubble1').css('margin-top', (topDist / -13) * 9 - 50);-->
<!--        $('.big-bubble').css('margin-top', (topDist / -13) * 13 - 200);-->
<!--    }-->
<!---->
<!--    doParallaxCalc();-->
<!---->
<!--    $(document).ready(function() {-->
<!--        $(document).scroll(function () {-->
<!--            doParallaxCalc();-->
<!--        });-->
<!--    });-->
<!--</script>-->

<script>
    var env = '<?= $derrick_env ?>';
    var brandUrl;
    var brandId = '<?= $brand ?>';

    switch (env) {
        case 'local':
            brandUrl = 'http://local.thisisglobal.com:8000/';
            break;

        case 'development':
        case 'usertesting':
        case 'training':
        case 'staging':
            brandUrl = 'http://www.<?= $brand ?>.' + env + '.int.thisisglobal.com/';
            break;

        case 'live':
            brandUrl = '<?= $brands[$brand]['brandURL'] ?>';
            break;

        default:
            throw new Error('Unknown Environment.');
    }

    /**
     * Function for making the social connect login tabs clickable, called when the stepname is
     *  'UnAuthorised'.
     *  TODO: This should be moved into the core functionality.
     */
    function initialiseConnectTabs() {
        var $connectSelector = $('#connect-selector');
        if ($connectSelector.length) {
            $('#login.connect-section').hide().find('.form__sep').hide();
            $connectSelector.on('click', '.tab a', function (e) {
                e.preventDefault();
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');
                target = $(this).attr('href');
                $('.connect-section').not(target).hide();
                $(target).fadeIn(600);
            }).data('initialised', true);
        }
    }

    /**
     * `onAuthenticationChange` callback triggered when the user is logged in or logged out.
     *
     * @param profile object on authenticated or null on un-authenticated.
     */
    function onAuthenticationChange(profile, stepName) {
        if (profile && stepName === 'Authenticated') {
            console.log('Authenticated as: ' + profile.first_name);
            competitionForm.authenticated(profile);
        } else {
            console.log('Not authenticated');
            competitionForm.notAuthenticated();
        }
    }

    /**
     * `onStepChange` callback gets triggered when the user navigates through the component.
     *
     * @param stepName string
     *
     * Possible stepName values:
     *
     * - "Loading"
     * - "UnAuthenticated"
     * - "AlreadyRegistered"
     * - "Authenticated"
     * - "SocialEmailCollect"
     * - "SocialProfileCollect"
     * - "UnhandledException"
     *
     * Example Use Case: useful to hook off of for analytics purposes.
     */
    function onStepChange(stepName) {
        console.log('Changed step: ' + stepName);
        if (stepName === 'UnAuthenticated') {
            competitionForm.notAuthenticated();
            initialiseConnectTabs();
        }
    }

    var options = {
        onAuthenticationChange: onAuthenticationChange,
        onStepChange: onStepChange
    };

    var $competition_form = $('#competition-form');
    if ($competition_form.length) {
        if (typeof derrick === 'object') {
            derrick.SocialAuthComponent(brandId, brandUrl, options);
        }
        window.initForm($competition_form);
    }

</script>

<?php include('inc.analytics.php'); ?>
<?php if (isset($kruxCategories)) { include('inc.krux.php');} ?>

</body>
</html>