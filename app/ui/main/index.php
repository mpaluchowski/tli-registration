<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo \F3::get('lang.RegistrationFormPageTitle') ?> | TLI 2015</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
  </head>
  <body>

    <div class="container">
      <h1><?php echo \F3::get('lang.RegistrationFormHeader') ?></h1>

      <form action="/process" method="POST">
        <h2><?php echo \F3::get('lang.PersonalInformationHeader') ?></h2>

        <div class="form-group">
          <label for="full-name"><?php echo \F3::get('lang.FullName') ?></label>
          <input type="text" id="full-name" name="full-name" placeholder="<?php echo \F3::get('lang.FullNamePlaceholder') ?>" autocomplete="name" autofocus required maxlength="100" class="form-control">
        </div>
        <div class="form-group">
          <label for="email"><?php echo \F3::get('lang.Email') ?></label>
          <input type="email" id="email" name="email" placeholder="<?php echo \F3::get('lang.EmailPlaceholder') ?>" autocomplete="email" required class="form-control">
        </div>
        <div class="form-group">
          <label for="phone"><?php echo \F3::get('lang.Phone') ?></label>
          <input type="tel" id="phone" name="phone" placeholder="<?php echo \F3::get('lang.PhonePlaceholder') ?>" autocomplete="tel" required pattern="^\+?[0-9 \-]{9,}$" class="form-control">
        </div>

        <div class="form-group">
          <label for="home-club"><?php echo \F3::get('lang.HomeClub') ?></label>
          <select name="home-club" id="home-club" class="form-control">
            <option value="None"><?php echo \F3::get('lang.HomeClubNonMember') ?></option>
          <?php foreach ($clubs as $club): ?>
            <option value="<?php echo $club->name ?>"><?php echo $club->name ?></option>
          <?php endforeach; ?>
            <option value="Other"><?php echo \F3::get('lang.HomeClubNotListed') ?></option>
          </select>
        </div>

        <div class="form-group">
          <label for="exec-position"><?php echo \F3::get('lang.ExecCommmitteePosition') ?></label>
          <select name="exec-position" id="exec-position" class="form-control">
            <option value="None"><?php echo \F3::get('lang.ExecCommmitteePositionNone') ?></option>
            <option value="President"><?php echo \F3::get('lang.ExecCommmitteePositionPresident') ?></option>
            <option value="VPE"><?php echo \F3::get('lang.ExecCommmitteePositionVpe') ?></option>
            <option value="VPM"><?php echo \F3::get('lang.ExecCommmitteePositionVpm') ?></option>
            <option value="VPPR"><?php echo \F3::get('lang.ExecCommmitteePositionVppr') ?></option>
            <option value="Treasurer"><?php echo \F3::get('lang.ExecCommmitteePositionTreasurer') ?></option>
            <option value="Secretary"><?php echo \F3::get('lang.ExecCommmitteePositionSecretary') ?></option>
            <option value="SAA"><?php echo \F3::get('lang.ExecCommmitteePositionSaa') ?></option>
          </select>
        </div>

        <div class="form-group">
          <label for="educational-awards"><?php echo \F3::get('lang.EducationalAwards') ?></label>
          <input type="text" id="educational-awards" name="educational-awards" placeholder="<?php echo \F3::get('lang.EducationalAwardsPlaceholder') ?>" pattern="^[(CC|ACB|ACS|ACG|CL|ALB|ALS|DTM), ]*$" class="form-control" title="<?php echo \F3::get('lang.EducationalAwardsTitle') ?>">
        </div>

        <h2><?php echo \F3::get('lang.AccommodationHeader') ?></h2>

        <div class="form-group">
          <label><?php echo \F3::get('lang.AccommodationWithToastmasters') ?></label>
          <p class="help-block"><?php echo \F3::get('lang.AccommodationWithToastmastersHelp') ?></p>
          <div class="radio">
            <label><input type="radio" name="accommodation-with-toastmasters" value="stay" required><?php echo \F3::get('lang.AccommodationWithToastmastersStay') ?></label>
          </div>

          <div class="container-fluid">
            <div class="form-group col-xs-11 col-xs-offset-1">
              <label><?php echo \F3::get('lang.AccommodationWithToastmastersNeededOn') ?></label>
              <div class="checkbox">
                <label><input name="accommodation-on[]" type="checkbox" value="friday/saturday"><?php echo \F3::get('lang.AccommodationWithToastmastersFriSat') ?></label>
              </div>
              <div class="checkbox">
                <label><input name="accommodation-on[]" type="checkbox" value="saturday/sunday"><?php echo \F3::get('lang.AccommodationWithToastmastersSatSun') ?></label>
              </div>
            </div>
            <div class="form-group col-xs-11 col-xs-offset-1">
              <label><?php echo \F3::get('lang.AccommodationWithToastmastersSleepOn') ?></label>
              <div class="checkbox">
                <label><input name="sleep-on[]" type="checkbox" value="bed"><?php echo \F3::get('lang.AccommodationWithToastmastersSleepOnBed') ?></label>
              </div>
              <div class="checkbox">
                <label><input name="sleep-on[]" type="checkbox" value="mattress"><?php echo \F3::get('lang.AccommodationWithToastmastersSleepOnMattress') ?></label>
              </div>
              <div class="checkbox">
                <label><input name="sleep-on[]" type="checkbox" value="foam-pad"><?php echo \F3::get('lang.AccommodationWithToastmastersSleepOnFoamPad') ?></label>
              </div>
              <div class="checkbox">
                <label><input name="sleep-on[]" type="checkbox" value="dont-care"><?php echo \F3::get('lang.AccommodationWithToastmastersSleepOnAnything') ?></label>
              </div>
            </div>
          </div>

          <div class="radio">
            <label><input type="radio" name="accommodation-with-toastmasters" value="host"><?php echo \F3::get('lang.AccommodationWithToastmastersHost') ?></label>
          </div>
          <div class="radio">
            <label><input type="radio" name="accommodation-with-toastmasters" value="independent"><?php echo \F3::get('lang.AccommodationWithToastmastersOnMyOwn') ?></label>
          </div>
        </div>

        <h2><?php echo \F3::get('lang.EventsHeader') ?></h2>

        <div class="checkbox">
          <label><input type="checkbox" name="friday-social-event"><?php echo \F3::get('lang.EventsFridaySocialYes') ?></label>
        </div>

        <div class="checkbox">
          <label><input type="checkbox" name="saturday-dinner-participate"><?php echo \F3::get('lang.EventsSaturdayDinnerYes') ?></label>

          <div class="container-fluid">
            <div class="form-group col-xs-11 col-xs-offset-1">
              <div class="radio">
                <label><input type="radio" name="saturday-dinner-meal" value="meat"><?php echo \F3::get('lang.EventsSaturdayDinnerMeat') ?></label>
              </div>
              <div class="radio">
                <label><input type="radio" name="saturday-dinner-meal" value="vegetarian"><?php echo \F3::get('lang.EventsSaturdayDinnerVege') ?></label>
              </div>
            </div>
          </div>
        </div>

        <div class="checkbox">
          <label><input type="checkbox" name="saturday-party-participate"><?php echo \F3::get('lang.EventsSaturdayPartyYes') ?></label>
        </div>

        <h2><?php echo \F3::get('lang.CommentsHeader') ?></h2>

        <div class="form-group">
          <label for="comments" class="sr-only"><?php echo \F3::get('lang.Comments') ?></label>
          <p class="help-block"><?php echo \F3::get('lang.CommentsHelp') ?></p>
          <textarea name="comments" id="comments" rows="6" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-lg btn-success"><?php echo \F3::get('lang.SubmitAndReviewButton') ?></button>
        <p class="help-block"><?php echo \F3::get('lang.SubmitAndReviewButtonHelp') ?></p>
      </form>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>
