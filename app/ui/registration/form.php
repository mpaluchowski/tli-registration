<?php echo \View::instance()->render('header.php') ?>

<div class="container">
  <div class="page-header">
    <h1><?php echo \F3::get('lang.RegistrationFormHeader') ?></h1>
  </div>

  <?php if (isset($registration['messages']) && !empty($registration['messages'])): ?>
  <div class="alert alert-danger" role="alert"><?php echo \F3::get('lang.RegistrationFormValidationMsg') ?></div>
  <?php endif; ?>

  <p><?php
  echo \F3::get('lang.CurrentParticipationPaymentInfo', [
    implode(" / ", \helpers\CurrencyFormatter::moneyFormatArray($pricing['admission']->prices)),
    \F3::get('lang.Ticket-' . $pricing['admission']->variant),
    strftime('%x', strtotime($pricing['admission']->dateValidThrough)),
    ]);
  if (isset($seatStats)) {
    if ($seatStats->left != 0) {
      echo \F3::get('lang.CurrentParticipationSeatsInfo', $seatStats->left);
    } else {
      echo \F3::get('lang.CurrentParticipationSeatsWaitingInfo', [
        $seatStats->left,
        $seatStats->waitingList,
        ]);
    }
  }
  ?></p>

  <form id="registration-form" action="<?php echo \F3::get('ALIASES.registration_process') ?>" method="POST">
    <h2><?php echo \F3::get('lang.PersonalInformationHeader') ?></h2>

    <div class="form-group<?php if (isset($registration['messages']['full-name'])): ?> has-error<?php endif ?>">
      <label for="full-name" class="control-label"><?php echo \F3::get('lang.FullName') ?></label>
      <input type="text" id="full-name" name="full-name" value="<?php if (isset($registration['full-name'])) echo $registration['full-name'] ?>" placeholder="<?php echo \F3::get('lang.FullNamePlaceholder') ?>" autocomplete="name" autofocus required maxlength="100" class="form-control">
      <?php if (isset($registration['messages']['full-name'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['full-name'] ?></p><?php endif; ?>
    </div>
    <div class="form-group<?php if (isset($registration['messages']['email'])): ?> has-error<?php endif ?>" id="group-email">
      <label for="email" class="control-label"><?php echo \F3::get('lang.Email') ?></label>
      <input type="email" id="email" name="email" value="<?php if (isset($registration['email'])) echo $registration['email'] ?>" placeholder="<?php echo \F3::get('lang.EmailPlaceholder') ?>" autocomplete="email" required class="form-control">
      <?php if (isset($registration['messages']['email'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['email'] ?></p><?php endif; ?>
    </div>
    <div class="form-group<?php if (isset($registration['messages']['phone'])): ?> has-error<?php endif ?>">
      <label for="phone" class="control-label"><?php echo \F3::get('lang.Phone') ?></label>
      <input type="tel" id="phone" name="phone" value="<?php if (isset($registration['phone'])) echo $registration['phone'] ?>" placeholder="<?php echo \F3::get('lang.PhonePlaceholder') ?>" autocomplete="tel" required pattern="^\+?[0-9 \-]{9,}$" class="form-control">
      <?php if (isset($registration['messages']['phone'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['phone'] ?></p><?php endif; ?>
    </div>

    <div class="form-group<?php if (isset($registration['messages']['home-club-custom'])): ?> has-error<?php endif ?>">
      <label for="home-club" class="control-label"><?php echo \F3::get('lang.HomeClub') ?></label>
      <select name="home-club" id="home-club" class="form-control">
        <option value="None"<?php if (isset($registration['home-club']) && $registration['home-club'] == 'None') echo ' selected' ?>><?php echo \F3::get('lang.HomeClubNonMember') ?></option>
        <option value="Other"<?php if (isset($registration['home-club']) && $registration['home-club'] == 'Other') echo ' selected' ?>><?php echo \F3::get('lang.HomeClubNotListed') ?></option>
        <optgroup label="<?php echo \F3::get('lang.HomeClubClubs') ?>">
        <?php foreach ($clubs as $club): ?>
          <option value="<?php echo $club->name ?>"<?php if (isset($registration['home-club']) && $registration['home-club'] == $club->name) echo ' selected' ?>><?php echo $club->name ?></option>
        <?php endforeach; ?>
        </optgroup>
      </select>
      <p id="home-club-custom-help" class="help-block"><?php echo \F3::get('lang.HomeClubCustomHelp', \F3::get('lang.HomeClubNotListed')) ?></p>
      <input type="text" id="home-club-custom" name="home-club-custom" value="<?php if (isset($registration['home-club-custom'])) echo $registration['home-club-custom'] ?>" placeholder="<?php echo \F3::get('lang.HomeClubCustomPlaceholder') ?>" class="form-control">
      <?php if (isset($registration['messages']['home-club-custom'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['home-club-custom'] ?></p><?php endif; ?>
    </div>

    <div class="form-group<?php if (isset($registration['messages']['exec-position'])): ?> has-error<?php endif ?>">
      <label for="exec-position" class="control-label"><?php echo \F3::get('lang.ExecCommmitteePosition') ?></label>
      <select name="exec-position" id="exec-position" class="form-control">
        <option value="none"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'none') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-none') ?></option>
        <option value="president"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'president') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-president') ?></option>
        <option value="vpe"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'vpe') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-vpe') ?></option>
        <option value="vpm"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'vpm') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-vpm') ?></option>
        <option value="vppr"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'vppr') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-vppr') ?></option>
        <option value="treasurer"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'treasurer') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-treasurer') ?></option>
        <option value="secretary"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'secretary') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-secretary') ?></option>
        <option value="saa"<?php if (isset($registration['exec-position']) && $registration['exec-position'] == 'saa') echo ' selected' ?>><?php echo \F3::get('lang.ExecCommmitteePosition-saa') ?></option>
      </select>
      <?php if (isset($registration['messages']['exec-position'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['exec-position'] ?></p><?php endif; ?>
    </div>

    <div class="form-group<?php if (isset($registration['messages']['educational-awards'])): ?> has-error<?php endif ?>">
      <label for="educational-awards" class="control-label"><?php echo \F3::get('lang.EducationalAwards') ?></label>
      <input type="text" id="educational-awards" name="educational-awards" value="<?php if (isset($registration['educational-awards'])) echo $registration['educational-awards'] ?>" placeholder="<?php echo \F3::get('lang.EducationalAwardsPlaceholder') ?>" pattern="(?:(?:^|, |,| )(CC|ACB|ACS|ACG|CL|ALB|ALS|DTM))+$" class="form-control" title="<?php echo \F3::get('lang.EducationalAwardsTitle') ?>">
      <?php if (isset($registration['messages']['educational-awards'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['educational-awards'] ?></p><?php endif; ?>
    </div>

    <h2><?php echo \F3::get('lang.AccommodationHeader') ?></h2>

    <div class="form-group<?php if (isset($registration['messages']['accommodation-with-toastmasters'])): ?> has-error<?php endif ?>">
      <label class="control-label"><?php echo \F3::get('lang.AccommodationWithToastmasters') ?></label>
      <p class="help-block"><?php echo \F3::get('lang.AccommodationWithToastmastersHelp') ?></p>
      <div class="radio">
        <label><input type="radio" name="accommodation-with-toastmasters" value="stay" required<?php if (isset($registration['accommodation-with-toastmasters']) && $registration['accommodation-with-toastmasters'] == 'stay') echo ' checked' ?>><?php echo \F3::get('lang.AccommodationWithToastmastersStayAnswer') ?></label>
      </div>

      <div class="form-group-dependent" data-depends-on="accommodation-with-toastmasters" data-depends-on-value="stay">
        <div class="form-group<?php if (isset($registration['messages']['accommodation-on'])): ?> has-error<?php endif ?>">
          <label class="control-label"><?php echo \F3::get('lang.AccommodationWithToastmastersNeededOn') ?></label>
          <div class="checkbox">
            <label><input name="accommodation-on[]" type="checkbox" value="fri-sat"<?php if (isset($registration['accommodation-on']) && in_array('fri-sat', $registration['accommodation-on'])) echo ' checked' ?>><?php echo \F3::get('lang.AccommodationWithToastmastersFriSat') ?></label>
          </div>
          <div class="checkbox">
            <label><input name="accommodation-on[]" type="checkbox" value="sat-sun"<?php if (isset($registration['accommodation-on']) && in_array('sat-sun', $registration['accommodation-on'])) echo ' checked' ?>><?php echo \F3::get('lang.AccommodationWithToastmastersSatSun') ?></label>
          </div>

          <?php if (isset($registration['messages']['accommodation-on'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['accommodation-on'] ?></p><?php endif; ?>
        </div>
      </div>

      <div class="radio">
        <label><input type="radio" name="accommodation-with-toastmasters" value="host"<?php if (isset($registration['accommodation-with-toastmasters']) && $registration['accommodation-with-toastmasters'] == 'host') echo ' checked' ?>><?php echo \F3::get('lang.AccommodationWithToastmastersHostAnswer') ?></label>
      </div>
      <div class="radio">
        <label><input type="radio" name="accommodation-with-toastmasters" value="independent"<?php if (isset($registration['accommodation-with-toastmasters']) && $registration['accommodation-with-toastmasters'] == 'independent') echo ' checked' ?>><?php echo \F3::get('lang.AccommodationWithToastmastersIndependentAnswer') ?></label>
      </div>

      <?php if (isset($registration['messages']['accommodation-with-toastmasters'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['accommodation-with-toastmasters'] ?></p><?php endif; ?>
    </div>

    <h2><?php echo \F3::get('lang.EventOptionsHeader') ?></h2>

    <div class="checkbox form-group">
      <label><input type="checkbox" name="translator"<?php if (isset($registration['translator']) && $registration['translator'] == 'on') echo ' checked' ?>><?php echo \F3::get('lang.EventsTranslatorYes') ?></label>
      <p class="help-block"><?php echo \F3::get('lang.EventTranslatorHelp') ?></p>
    </div>

    <div class="checkbox form-group">
      <label><input type="checkbox" name="contest-attend"<?php if (isset($registration['contest-attend']) && $registration['contest-attend'] == 'on') echo ' checked' ?>><?php echo \F3::get('lang.EventsContestYes') ?></label>
    </div>

    <div class="checkbox form-group">
      <label><input type="checkbox" name="friday-social-event"<?php if (isset($registration['friday-social-event']) && $registration['friday-social-event'] == 'on') echo ' checked' ?>><?php echo \F3::get('lang.EventsFridaySocialYes') ?></label>
    </div>

    <div class="checkbox form-group">
      <label><input type="checkbox" name="lunch"<?php if (isset($registration['lunch']) && $registration['lunch'] == 'on') echo ' checked' ?>><?php echo \F3::get('lang.EventsLunchYes') ?></label>

      <div class="form-group-dependent" data-depends-on="lunch" data-depends-on-value="on">
        <div class="form-group<?php if (isset($registration['messages']['lunch-days'])): ?> has-error<?php endif ?>">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="lunch-days[]" class="field-price-affecting" value="saturday"<?php if (isset($registration['lunch-days']) && in_array('saturday', $registration['lunch-days'])) echo ' checked' ?>><?php echo \F3::get('lang.EventsLunchSaturday') ?>
              <span class="label label-default"><?php echo implode(\helpers\CurrencyFormatter::moneyFormatArray($pricing['lunch']->prices), ' / ') ?></span>
            </label>
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="lunch-days[]" class="field-price-affecting" value="sunday"<?php if (isset($registration['lunch-days']) && in_array('sunday', $registration['lunch-days'])) echo ' checked' ?>><?php echo \F3::get('lang.EventsLunchSunday') ?>
              <span class="label label-default"><?php echo implode(\helpers\CurrencyFormatter::moneyFormatArray($pricing['lunch']->prices), ' / ') ?></span>
            </label>
          </div>

          <?php if (isset($registration['messages']['lunch-days'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['lunch-days'] ?></p><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="checkbox form-group">
      <label>
        <input type="checkbox" name="saturday-dinner-participate" class="field-price-affecting"<?php if (isset($registration['saturday-dinner-participate']) && $registration['saturday-dinner-participate'] == 'on') echo ' checked' ?>><?php echo \F3::get('lang.EventsSaturdayDinnerYes') ?>
        <span class="label label-default"><?php echo implode(\helpers\CurrencyFormatter::moneyFormatArray($pricing['saturday-dinner-participate']->prices), ' / ') ?></span>
      </label>

      <div class="form-group-dependent" data-depends-on="saturday-dinner-participate" data-depends-on-value="on">
        <div class="form-group<?php if (isset($registration['messages']['saturday-dinner-meal'])): ?> has-error<?php endif ?>">
          <div class="radio">
            <label>
              <input type="radio" name="saturday-dinner-meal" value="meat" data-required="required"<?php if (isset($registration['saturday-dinner-meal']) && $registration['saturday-dinner-meal'] == 'meat') echo ' checked' ?>><?php echo \F3::get('lang.EventsSaturdayDinnerMeat') ?>
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="saturday-dinner-meal" value="vegetarian" data-required="required"<?php if (isset($registration['saturday-dinner-meal']) && $registration['saturday-dinner-meal'] == 'vegetarian') echo ' checked' ?>><?php echo \F3::get('lang.EventsSaturdayDinnerVegetarian') ?>
            </label>
          </div>

          <?php if (isset($registration['messages']['saturday-dinner-meal'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['saturday-dinner-meal'] ?></p><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="checkbox form-group">
      <label>
        <input type="checkbox" name="saturday-party-participate" class="field-price-affecting"<?php if (isset($registration['saturday-party-participate']) && $registration['saturday-party-participate'] == 'on') echo ' checked' ?>><?php echo \F3::get('lang.EventsSaturdayPartyYes') ?>
        <span class="label label-default"><?php echo implode(\helpers\CurrencyFormatter::moneyFormatArray($pricing['saturday-party-participate']->prices), ' / ') ?></span>
      </label>
    </div>

    <h2><?php echo \F3::get('lang.CommentsHeader') ?></h2>

    <div class="form-group">
      <label for="comments" class="sr-only"><?php echo \F3::get('lang.Comments') ?></label>
      <p class="help-block"><?php echo \F3::get('lang.CommentsHelp') ?></p>
      <textarea name="comments" id="comments" rows="6" class="form-control"><?php if (isset($registration['comments'])) echo $registration['comments'] ?></textarea>
    </div>

    <div class="checkbox form-group<?php if (isset($registration['messages']['data-collection-consent'])): ?> has-error<?php endif ?>">
      <label>
        <input type="checkbox" name="data-collection-consent" required<?php if (isset($registration['data-collection-consent']) && $registration['data-collection-consent'] == 'on') echo ' checked' ?>><?php echo \F3::get('lang.DataCollectionConsentStatement') ?>
      </label>

      <?php if (isset($registration['messages']['data-collection-consent'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $registration['messages']['data-collection-consent'] ?></p><?php endif; ?>
    </div>

    <button type="submit" class="btn btn-lg btn-success"><?php echo \F3::get('lang.SubmitAndReviewButton') ?></button>
    <p class="help-block"><?php echo \F3::get('lang.SubmitAndReviewButtonHelp') ?></p>
  </form>
</div>

<footer class="navbar navbar-default navbar-fixed-bottom">
  <div class="container">
    <h3 class="navbar-text navbar-right">
      <?php echo \F3::get('lang.CurrentTotalDue') ?>
      <span id="total-due" class="label label-info">&mdash;</span>
    </h3>
  </div>
</footer>

<?php echo \View::instance()->render('footer.php') ?>
