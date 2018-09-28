<?php
$error_output = isset($error['general']) ? '<p class="error">' . $error['general'] . '</p>' : '';
?>
	<div id="form-container" class="form-container">

		<input type="hidden" id="formID" name="formID" value="<?= $formID ?>"/>
		<input type="hidden" id="brandID" name="brandID" value="<?= $brand ?>"/>
		<input type="hidden" name="<?= $security->getPhpLabel() ?>" value="<?= $security->getPhpToken(); ?>"/>

		<div class="question column" id="question">
			<div class="wrapper question-wrapper">
				<fieldset id="competitionQuestion" class="competition-question column">
					<div class="text-box">
						<h2><?= $text['competition']['title'] ?></h2>
						<?= formatText($text['competition']['text']) ?>
						<?php
						echo $error_output;
						if (isset($text['competition']['answers']) && is_array($text['competition']['answers'])) { ?>
							<div class="question-container">
								<p id="answer">Q: <?= $text['competition']['question'] ?></p>
							</div>
							<div class="answers-container">
								<ul>
									<?php
									foreach ($text['competition']['answers'] as $idx => $val) {
										echo $form->answerElement($idx, $val);
									} ?>
								</ul>
							</div>
						<?php
						} else {
							if (!isset($text['competition']['question'])) {
								goto end;
							}
							?>
							<p class="full">
								<label for="answer">Q: <?= $text['competition']['question'] ?></label>
							</p>
							<p>
								<textarea id="answer" name="answer"><?= $form->getValue('answer') ?></textarea>
							</p>
							<?php
							if (!isset($text['competition']['answerLimit'])) { ?>
								<p>Set the <b>answerLimit</b> variable in the content file.</p>
								<?php
								goto end;
							}
							if (!isset($text['competition']['answerLimitType'])) { ?>
								<p>Set the <b>answerLimitType</b> variable in the content file.</p>
								<?php
								goto end;
							}
							?>
							<p class="answer-length" id="answerLength" data-target="answer"
							   data-type="<?= $text['competition']['answerLimitType'] ?>">Please limit your answer
								to <span><?= $text['competition']['answerLimit'] ?></span>
								<?= $text['competition']['answerLimitType'] ?> or less</p>
						<?php }
						end: ?>
					</div>

				</fieldset>
			</div>
		</div>
        <div class="login-container" id="login-container">
            <div class="social-connect-container">
                <div class="wrapper">
                    <div class="text-box">
                        <h2>Login to enter the competition</h2>
                    </div>
                </div>
                <div id="derrick-social-auth-component">
                </div>
            </div>
            <div id="user-details" class="user-details details column">
                <div class="wrapper">
                    <h3 class="title">Please complete the following details to enter the competition:</h3>
                    <fieldset id="competitionDetails" class="competition-details">
                        <div class="register-container">
                            <?php
                            echo $form->printField('gender', 'div', 'clearfix');
                            echo $form->printField('firstName', 'div', 'clearfix');
                            echo $form->printField('surname', 'div', 'clearfix');
                            echo $form->printField('email', 'div', 'clearfix');
                            echo $form->printField('dateOfBirth', 'div', 'clearfix');
                            echo $form->printField('postCode', 'div', 'clearfix');
                            echo $form->printField('phone', 'div', 'clearfix');
                            ?>

                            <noscript>
                                <?php if (!isset($userCaptcha)) {
                                    echoCaptcha();
                                } ?>
                            </noscript>
                            <?php
                            if (isset($userCaptcha)) {
                                echoCaptcha();
                            }
                            // Un-comment the following line to print out the captcha code as plain text.
                            // echo $security->spillTheBeans();
                            ?>
                        </div>
                    </fieldset>
                    <fieldset id="competitionOptIns" class="competition-optins column">
                        <?php
                        echo $form->printField('clientOptIn', 'p', '', 'I\'d like to know more about <a href="' . $client['link'] . '">' . $client['name'] . '</a>.');
                        echo $form->printField('stationOptIn', 'p', '', 'Yes! I want to be the first to hear about news, special promotions and offers from <a href="' . $brands[$brand]['brandURL'] . '" target="_blank">' . $brands[$brand]['name'] . '</a>.');
                        echo $form->printField('termsOptIn', 'p', '', 'I have read and agreed to the <a href="' . $text['competition']['terms'] . '" target="_blank">Terms and Conditions</a> and <a href="' . $brands[$brand]['privacy'] . '" target="_blank">Privacy Policy</a>.');
                        ?>
                        <p class="cta clear">
                            <button type="submit" name="enter">Submit<span></span></button>
                        </p>
                        <small><span class="req">*</span> required field</small>
                    </fieldset>
                </div>
            </div>
        </div>


	</div>
<?php // End of file: form.competition.php