<?php
require_once('includes/common.constants.php');
include('includes/form.validator.php');
include('includes/templ.header.php');

// Specify the form encoding type if it needs to handle file uploads.
$form_multipart = isset($text['competition']['fileUpload']) && $text['competition']['fileUpload'] ? 'enctype="multipart/form-data" ' : '';

// Determine the competition status based on the timestamp and the 'submitted' session value.
$competition_status =
    ($timestamp >= strtotime($text['competition']['ends']) ? 1 : //ended
        ($timestamp < strtotime($text['competition']['starts']) ? 2 : //coming
            (isset($_SESSION[$campaign][$formID]['submitted']) && $_SESSION[$campaign][$formID]['submitted'] == 1 ? 3 : 4))); // submitted || on
//<path class="fill" d="M 0 160 L 0 295 C 470 440 749 169 1010 308 L 1000 200 C 789 181 540 416 0 160 Z">
//        </path>
?>
    <section class="intro">
        <div class="bg-image">
            <div class="snow">
            </div>
        </div>
        <header role="banner">
            <div class="wrapper">
                <a id="brandLogo" class="brand-logo" href="<?= $brands[$brand]['brandURL']; ?>"
                   target="_blank"><?= $brands[$brand]['slogan']; ?></a>

                <a id="clientLogo" class="client-logo" href="<?= $client['link']; ?>"
                   target="_blank"><?= $client['slogan']; ?></a>
            </div>
        </header>
        <div class="wrapper">
            <div class="text-box">
                <h1><?= $text['intro']['title'] ?></h1>
                <?= formatText($text['intro']['text']) ?>
                <?= formatText($text['intro']['link-text'], 'cta', array('href'=>'#filter', 'class'=>'scroll')) ?>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 160 1000 180">
            <path class="curve" d="M -51 258 C 305 477 805 171 1032 299" />
            <path class="curve" d="M 1024 220 C 709 201 540 463 0 160" />
            <path class="fill" d="M 0 160 L -51 258 C 305 477 805 171 1032 299 L 1024 220 C 709 201 540 463 0 160 Z">
            </path>
        </svg>
    </section>

    <section class="bubbles">
        <div class="wrapper">
            <div class="text-box">
                <h1><?= $text['bubbles']['title'] ?></h1>
                <?= formatText($text['bubbles']['text']) ?>
            </div>
            <div class="bubblewrap">
                <div class="big-bubble">
                    <img src="img/big-bubble.jpg"/>
                </div>
                <div class="small-bubble">
                    <img src="img/small-bubble.jpg"/>
                </div>
                <span class="bubble animation bubble1"></span>
                <span class="bubble animation bubble2"></span>
                <span class="bubble animation bubble3"></span>
                <span class="bubble animation bubble4"></span>
                <span class="bubble animation bubble5"></span>
                <span class="bubble animation bubble6"></span>
                <span class="bubble animation bubble7"></span>
            </div>
        </div>
    </section>

    <section class="product">
        <div class="wrapper">
            <div class="text-box">
                <h1><?= $text['product']['title'] ?></h1>
                <?= formatText($text['product']['text']) ?>
                <p class="cta"><a target="_blank" href="<?= $text['product']['link-url'] ?>"><?= $text['product']['link-text'] ?></a></p>
            </div>
        </div>
    </section>

<?php if (isset($text['video'])) { ?>
    <section id="video" class="video">
<!--        <div class="wrapper">-->
<!--            <div class="text-box">-->
<!--                <h3>--><?//= $text['video']['title'] ?><!--</h3>-->
<!---->
<!--                <div class="copy">-->
<!--                    --><?//= formatText($text['video']['text']) ?>
<!--                </div>-->
                <p class="iframe">
                    <iframe src="<?= $text['video']['link'] ?>?api=1" frameborder="0"
                            webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </p>
<!--            </div>-->
<!--        </div>-->
    </section>

    <section class="filter" id="filter">
        <div class="wrapper">
            <div class="text-box">
                <h1><?= $text['filter']['title'] ?></h1>
                <?= formatText($text['filter']['text']) ?>
                <img src="img/filtertowin.jpg" alt="filter to win" width="439" height="439"/>
                <?= formatText($text['filter']['instructions']) ?>
            </div>
        </div>
    </section>

<?php } ?>
<?php if (isset($text['competition']['question'])) { ?>
    <section class="competition" id="competition">
        <?php if ($competition_status === 4) { ?>
        <form role="form" action="<?= $siteDetails['baseURL'] ?>#competition" id="competition-form" method="post" class="clearfix"
            <?= $form_multipart ?>  novalidate="novalidate">
            <?php } ?>
            <div id="form-wrapper" class="form-wrapper <?= $competition_status === 3 ? 'thank-you' : '' ?>">
                <?php
                if ($competition_status === 1) { ?>
                    <div class="wrapper">
                        <div class="column">
                            <p>Sorry! The competition is over already... For more chances to win, check out the <a
                                    href="<?= $brands[$brand]['brandURL'] ?>"><?= $brands[$brand]['name'] ?> website</a>
                        </div>
                    </div>
                    <?php
                    goto exitForm;
                } else if ($competition_status === 2) { ?>
                    <div class="wrapper">
                        <div class="column">
                            <p>Hold your horses! Competition starts
                                at <?= date('G:i \o\n jS F Y', strtotime($text['competition']['starts'])) ?></p>
                        </div>
                    </div>
                    <?php
                    goto exitForm;
                }
                if ($competition_status === 3) {
                    include('includes/templ.success.php');
                } else {
                    include('includes/form.competition.php');
                }
                exitForm:
                ?>
            </div>
            <?php if ($competition_status === 4) { ?>
        </form>
    <?php } ?>
    </section>
<?php } ?>
<?php
end:
include('includes/templ.footer.php');