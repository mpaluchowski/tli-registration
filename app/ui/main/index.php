<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Form | TLI 2015</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
  </head>
  <body>

    <div class="container">
      <h1>Register for TLI 2015</h1>

      <form action="/" method="POST">
        <h2>Personal information</h2>

        <div class="form-group">
          <label for="full-name">Full name</label>
          <input type="text" id="full-name" placeholder="John Doe" autofocus required maxlength="100" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" placeholder="john@example.com" required class="form-control">
        </div>
        <div class="form-group">
          <label for="cell-phone">Cell phone</label>
          <input type="tel" id="cell-phone" placeholder="+48 555 123 456" required pattern="\+?[0-9 \-]{9,}" class="form-control">
        </div>

        <div class="form-group">
          <label for="home-club">Home club</label>
          <select name="home-club" id="home-club" class="form-control">
            <option value="">I'm not a member of Toastmasters</option>
            <option value="">Speaking Elephants</option>
            <option value="">Toastmasters Polska SA</option>
            <option value="">Top Careers Toastmasters</option>
            <option value="">My club is not on this list</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exec-position">Executive Committee position</label>
          <select name="exec-position" id="exec-position" class="form-control">
            <option value="">I'm a regular member</option>
            <option value="">President</option>
            <option value="">Vice President Education</option>
            <option value="">Vice President Membership</option>
          </select>
        </div>

        <div class="form-group">
          <label for="educational-awards">Educational awards</label>
          <input type="text" id="educational-awards" placeholder="CC, ALB" pattern="[(CC|ACB|ACS|ACG|CL|ALB|ALS|DTM), ]*" class="form-control" title="Choose from: CC, ACB, ACS, ACG, CL, ALB, ALS, DTM">
        </div>

        <h2>Accommodation</h2>

        <div class="form-group">
          <label>Accommodation with Toastmasters</label>
          <p class="help-block">You can choose to sleep over with a member of Toastmasters or hose an incoming guest.</p>
          <div class="radio">
            <label><input type="radio" name="accommodation-with-toastmasters" required>I'd like to <strong>stay with</strong> a member of Toastmasters</label>
          </div>

          <div class="container-fluid">
            <div class="form-group col-xs-11 col-xs-offset-1">
              <label>I need accommodation on...</label>
              <div class="radio">
                <label><input name="accommodation-on" type="radio"> Friday/Saturday and Saturday/Sunday</label>
              </div>
              <div class="radio">
                <label><input name="accommodation-on" type="radio"> Only Saturday/Sunday</label>
              </div>
            </div>
            <div class="form-group col-xs-11 col-xs-offset-1">
              <label>I can sleep on...</label>
              <div class="radio">
                <label><input name="sleep-on" type="radio">Bed</label>
              </div>
              <div class="radio">
                <label><input name="sleep-on" type="radio">Mattress</label>
              </div>
              <div class="radio">
                <label><input name="sleep-on" type="radio">Foam pad</label>
              </div>
              <div class="radio">
                <label><input name="sleep-on" type="radio">Honestly don't care as long as it's safe and warm</label>
              </div>
            </div>
          </div>

          <div class="radio">
            <label><input type="radio" name="accommodation-with-toastmasters">I'd like to <strong>host</strong> an attendee</label>
          </div>
          <div class="radio">
            <label><input type="radio" name="accommodation-with-toastmasters">I'll arrange accomodation <strong>on my own</strong></label>
          </div>
        </div>

        <h2>Food</h2>

        <div class="checkbox">
          <label><input type="checkbox" name="saturday-dinner-participate">Yes, I will participate in Saturday's dinner</label>

          <div class="container-fluid">
            <div class="form-group col-xs-11 col-xs-offset-1">
              <div class="radio">
                <label><input type="radio" name="saturday-dinner-meal">I'll have a <strong>meat</strong> meal</label>
              </div>
              <div class="radio">
                <label><input type="radio" name="saturday-dinner-meal">I'll have a <strong>vegetarian</strong> meal</label>
              </div>
            </div>
          </div>
        </div>

        <h2>Events</h2>

        <div class="checkbox">
          <p class="help-block">We're going out to party on Saturday evening. Are you coming?</p>
          <label><input type="checkbox" name="saturday-party-participate">Yes, I will take part in Saturday's party</label>
        </div>

        <div class="checkbox">
          <p class="help-block">We're doing something fun on Friday evening together. Will you join?</p>
          <label><input type="checkbox" name="friday-social-event">Yes, I'd love to join Friday's social event</label>
        </div>

        <h2>Comments</h2>

        <div class="form-group">
          <label for="comments">Additional comments</label>
          <p class="help-block">Anything else you'd like to communicate or ask?</p>
          <textarea name="comments" id="comments" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-lg btn-success">Submit</button>
      </form>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>
