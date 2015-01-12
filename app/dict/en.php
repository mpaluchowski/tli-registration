<?php

return ['lang' => [
	"dateTimeFormat" => "%Y-%m-%d %H:%M",
	"dateFormat" => "%Y-%m-%d",
	"decimalPoint" => ".",
	"thousandsSeparator" => ",",

	"Yes" => "Yes",
	"No" => "No",

	"InLanguage" => "in",
	"InLanguage-en" => "English",
	"InLanguage-pl" => "Polish",

	"FieldDisabledExclusiveMsg" => "Option unavailable because it's conflicting with \"{0}\" you already selected.",

	"TliNavRegister" => 'Register',
	"TliNavRegisterUrl" => 'register',
	"TliNavHome" => 'Home',
	"TliNavSpeakers" => 'Speakers',
	"TliNavSpeakersUrl" => 'speakers',
	"TliNavContest" => 'Contest',
	"TliNavContestUrl" => 'contest',
	"TliNavSchedule" => 'Schedule',
	"TliNavScheduleUrl" => 'schedule',
	"TliNavEvents" => 'Events',
	"TliNavEventsUrl" => 'events',
	"TliNavVenues" => 'Venues',
	"TliNavVenuesUrl" => 'venues',
	"TliNavAccommodation" => 'Accommodation',
	"TliNavAccommodationUrl" => 'accommodation',
	"TliNavOrganizers" => 'Organizers',
	"TliNavOrganizersUrl" => 'organizers',
	"TliNavContact" => 'Contact',
	"TliNavContactUrl" => 'contact',
	"TliNavLanguagePl" => 'strona polskojęzyczna',

	'RegistrationFormPageTitle' => 'Registration Form',
	'RegistrationFormHeader' => 'Registration form',
	'RegistrationFormValidationMsg' => "Some things are not quite right in the form. Please review the messages below on how to correct the entries.",

	'PersonalInformationHeader' => 'Personal Information',
	'FullName' => 'Full name',
	'FullNamePlaceholder' => 'John Doe',
	'FullNameValidationMsg' => "Please provide your full name.",
	'Email' => 'Email',
	'EmailPlaceholder' => 'john@example.com',
	'EmailValidationMsg' => "Please provide your email address.",
	'EmailAlertRegisteredNoPayment' => "We seem to already have your e-mail address on file, probably because you filled in this registration form earlier. Would you like to <a href=\"{0}\">proceed to payment</a> now?",
	'EmailAlertRegistered' => "We seem to already have your e-mail address on file, probably because you filled in this registration form earlier. Would you like to <a href=\"{0}\">retrieve your registration details</a> now?",
	'Phone' => 'Phone',
	'PhonePlaceholder' => '+48 555 123 456',
	'PhoneValidationMsg' => "Please provide a phone number, including the operator code and optionally, the country code. You may use dashes and spaces.",
	'Country' => "Country of residence",
	'CountryPolandAnswer' => "Poland",
	'Country-poland' => "Poland",
	'CountryOutsideAnswer' => "Outside of Poland",
	'Country-outside' => "Outside of Poland",
	'CountryValidationMsg' => "Please select a country you're coming from.",
	'HomeClub' => 'Home club',
	'HomeClubNonMember' => "I'm not a member of Toastmasters",
	'HomeClubNotListed' => "My club is not on this list",
	'HomeClubClubs' => "Clubs",
	'HomeClubCustomHelp' => "If you selected \"{0}\", enter your club name below.",
	'HomeClubCustomPlaceholder' => "Type the name of your club...",
	'HomeClubCustomValidationMsg' => "Please provide the exact name of your home club, or choose one from the list.",
	'ExecCommmitteePosition' => "Executive Committee position",
	'ExecCommmitteePositionValidationMsg' => "You selected you're not a member of Toastmasters, and yet selected an Executive Committee position. This can't be right.",
	'ExecCommmitteePosition-none' => "I hold no position",
	'ExecCommmitteePositionShort-none' => "None",
	'ExecCommmitteePosition-president' => "President",
	'ExecCommmitteePositionShort-president' => "President",
	'ExecCommmitteePosition-vpe' => "Vice President Education",
	'ExecCommmitteePositionShort-vpe' => "VPE",
	'ExecCommmitteePosition-vpm' => "Vice President Membership",
	'ExecCommmitteePositionShort-vpm' => "VPM",
	'ExecCommmitteePosition-vppr' => "Vice President Public Relations",
	'ExecCommmitteePositionShort-vppr' => "VPPR",
	'ExecCommmitteePosition-treasurer' => "Treasurer",
	'ExecCommmitteePositionShort-treasurer' => "Treasurer",
	'ExecCommmitteePosition-secretary' => "Secretary",
	'ExecCommmitteePositionShort-secretary' => "Secretary",
	'ExecCommmitteePosition-saa' => "Sergeant at Arms",
	'ExecCommmitteePositionShort-saa' => "SAA",
	'EducationalAwards' => "Educational awards",
	'EducationalAwardsNone' => "None",
	'EducationalAwardsPlaceholder' => "CC, ALB",
	'EducationalAwardsTitle' => "Choose from: CC, ACB, ACS, ACG, CL, ALB, ALS, DTM",
	'EducationalAwardsValidationMsg' => "Please enter your educational awards from among: CC, ACB, ACS, ACG, CL, ALB, ALS, DTM, separated by comas or spaces.",

	'AccommodationHeader' => "Accommodation",
	'AccommodationWithToastmasters' => "Accommodation with Toastmasters",
	'AccommodationWithToastmastersHelp' => "You can choose to sleep over with a member of Toastmasters or host an incoming guest.",
	'AccommodationWithToastmastersValidationMsg' => "Please choose an accommodation option.",
	'AccommodationWithToastmastersStayAnswer' => "I'd like to <strong>stay with</strong> a member of Toastmasters",
	'AccommodationWithToastmasters-stay' => "Stay with a member of Toastmasters",
	'AccommodationWithToastmastersNeededOn' => "I need accommodation on...",
	'AccommodationWithToastmastersNeededOnValidationMsg' => "Please choose the day or days you'll need accommodation on.",
	'AccommodationWithToastmastersFriSat' => "Friday/Saturday",
	'AccommodationWithToastmasters-fri-sat' => "Friday/Saturday",
	'AccommodationWithToastmastersSatSun' => "Saturday/Sunday",
	'AccommodationWithToastmasters-sat-sun' => "Saturday/Sunday",
	'AccommodationWithToastmastersHostAnswer' => "I'd like to <strong>host</strong> an attendee",
	'AccommodationWithToastmastersHostHelp' => "Incoming Toastmasters often rely on the hospitality of locals for accommodation. Would you like to help out?",
	'AccommodationWithToastmasters-host' => "Host an attendee",
	'AccommodationWithToastmastersIndependentAnswer' => "I'll <strong>arrange my own</strong> accomodation",
	'AccommodationWithToastmastersDontNeedAnswer' => "I <strong>don't need</strong> accomodation",
	'AccommodationWithToastmasters-independent' => "On my own or don't need",

	'EventOptionsHeader' => "Event Options",
	'EventsTranslator' => "Translator",
	'EventsTranslatorYes' => "I can act as an English-Polish-English <strong>translator</strong>",
	'EventTranslatorHelp' => "We'll give you a special badge and may ask you to help out translating some sessions for those, who don't speak their language.",
	'EventsContestYes' => "I will attend the <a href=\"http://tli.toastmasters.org.pl/2015-01/contest\" rel=\"external\"><strong>Humorous Speech and Table Topics contests</strong></a> on Friday",
	'EventsContest' => "Friday's contests",
	'EventsContestCopernicusPlanetariumCollisionValidationMsg' => "You won't be able to attend both the <strong>Contest and the Copernicus Planetarium</strong>, because both happen <em>at the same time</em>. Please select only one of them.",
	'EventsFridayCopernicus' => "Friday's Copernicus Science Centre",
	'EventsFridayCopernicusYes' => "I'd like to visit the <a href=\"http://tli.toastmasters.org.pl/2015-01/events#event-copernicus\" rel=\"external\"><strong>Copernicus Science Centre</strong></a> on Friday",
	'EventsFridayCopernicusAttendCenter' => "I'd like to see the <strong>main exhibition</strong>",
	'EventsFridayCopernicusAttend-center' => "Exhibition",
	'EventsFridayCopernicusAttendPlanetarium' => "I'd like to see the <strong>show in the Planetarium</strong>",
	'EventsFridayCopernicusAttend-planetarium' => "Planetarium",
	'EventsFridayCopernicusOptionsValidationMsg' => "Please choose one or both of the options for visiting the Copernicus Science Centere.",
	'EventsFridaySocial' => "Friday's party",
	'EventsFridaySocialYes' => "I'd love to join <a href=\"http://tli.toastmasters.org.pl/2015-01/events#event-opera\" rel=\"external\"><strong>Friday's party at Opera Club</strong></a>",
	'EventsLunch' => "Lunch",
	'EventsLunchYes' => "I'd like to have organized <strong>lunch</strong> during the conference",
	'EventsLunchSaturday' => "on Saturday",
	'EventsLunch-saturday' => "Saturday",
	'EventsLunchSunday' => "on Sunday",
	'EventsLunch-sunday' => "Sunday",
	'EventsLunchDaysValidationMsg' => "Please choose one or both days on which you'd like to have organized lunch.",
	'EventsSaturdayDinner' => "Saturday's dinner",
	'EventsSaturdayDinnerYes' => "I will participate in <a href=\"http://tli.toastmasters.org.pl/2015-01/events#event-street\" rel=\"external\"><strong>Saturday's dinner at Street Restaurant</strong></a>",
	'EventsSaturdayDinnerMeal' => "Meal",
	'EventsSaturdayDinnerMealValidationMsg' => "Please choose a meal option for the Saturday dinner.",
	'EventsSaturdayDinnerMeat' => "I'll have a <strong>meat</strong> meal",
	'EventsSaturdayDinner-meat' => "meat",
	'EventsSaturdayDinnerVegetarian' => "I'll have a <strong>vegetarian</strong> meal",
	'EventsSaturdayDinner-vegetarian' => "vegetarian",
	'EventsSaturdayParty' => "Saturday's party",
	'EventsSaturdayPartyYes' => "I will take part in <a href=\"http://tli.toastmasters.org.pl/2015-01/events#event-club70\" rel=\"external\"><strong>Saturday's party at Club70</strong></a>",

	'CommentsHeader' => "Comments",
	'Comments' => "Additional comments",
	'CommentsNone' => "None",
	'CommentsHelp' => "Anything else you'd like to communicate or ask?",

	'DataCollectionConsentStatement' => "I consent to the collection and processing of my personal data for the purpose of arranging my participation in the Toastmasters Leadership Institute 2015 in Warsaw. I understand that my data may be shared with third parties to the <em>minimal</em> extent required to perform services I requested.",
	'DataCollectionConsentStatementValidationMsg' => "Please confirm that you allow for processing of your personal data. We are legally required to receive your consent before proceeding.",

	'SubmitAndReviewButton' => "Submit and Review",
	'SubmitAndReviewButtonHelp' => "You will have a chance to review your registration before proceeding to payment.",

	"CurrentParticipationPaymentInfo" => 'Your current participation price is <span class="label label-info">{0}</span> ({1}) if paid by {2}.',
	"CurrentParticipationSeatsInfo" => 'There are <span class="label label-success">{0}</span> seats left for taking.',
	"CurrentParticipationSeatsWaitingInfo" => 'There are <span class="label label-danger">{0}</span> seats left for taking and <span class="label label-default">{1}</span> people on the waiting list.',
	"CurrentTotalDue" => "Your current total due payment is",

	"RegistrationReviewHeader" => "Review registration for {0}",
	"RegistrationReviewIntro" => "Please <strong>review the contents</strong> of the registration form you have just submitted, the resulting participation cost calculation and final price. If everything is correct, click the button at the bottom of the page to <strong>proceed to payment</strong>.",
	'RegistrationFormSavedMsg' => "We've successfully stored your registration information and sent you an e-mail to <strong>{0}</strong> with a summary of your selections.",

	"RegistrationStatus" => "Registration status",
	"RegistrationStatus-pending-payment" => "Pending payment",
	"RegistrationStatusInfo-pending-payment" => "Your registration was recorded on <time>{0}</time> and is awaiting payment to complete.",
	"RegistrationStatus-pending-review" => "Pending confirmation",
	"RegistrationStatusInfo-pending-review" => "Your registration was recorded on <time>{0}</time> and is awaiting confirmation from one of our team members. Please wait with your payment until a member of the team contacts you.",
	"RegistrationStatus-paid" => "Paid",
	"RegistrationStatusInfo-paid" => "Your registration was recorded on <time>{0}</time>, paid for on <time>{1}</time> and you're all good for the event!",
	"RegistrationStatus-processing-payment" => "Processing payment",
	"RegistrationStatusInfo-processing-payment" => "Your registration payment is being processed and as soon as we receive a confirmation from the processing authority, we'll update your status to Paid.",
	"RegistrationStatus-waiting-list" => "Waiting list",
	"RegistrationStatusInfo-waiting-list" => "Your registration was recorded on <time>{0}</time>, but is <strong>waiting for an available seat</strong> after the initial limit was reached. We'll get back to you when this happens.",
	"RegistrationStatus-cancelled" => "Cancelled",
	"RegistrationStatusInfo-cancelled" => "Your registration was cancelled, hopefully after receiving prior notice from us! If you think that's a mistake, please contact us and we'll sort things out.",

	"PaymentBreakdownHeader" => "Payment breakdown",
	"PaymentBreakdownIntro-pending-payment" => "Based on the options you selected, your total due payment breaks down as follows:",
	"PaymentBreakdownIntro-pending-review" => "We'll be able to accept your payment as soon as your registration is confirmed. Hang on!",
	"PaymentBreakdownIntro-paid" => "We <strong>received your payment</strong> on {0}. Based on the options you selected, your payment covered the following items:",
	"PaymentBreakdownIntro-processing-payment" => "We're <strong>processing your payment</strong>, awaiting confirmation from the online payment authority. Here's an overview of what your payment included:",
	"PaymentBreakdownIntro-waiting-list" => "We'll be able to accept your payment as soon as your registration switches from the waiting list onto the main roster. Hang on!",
	"PaymentBreakdownIntro-cancelled" => "Based on the options you selected, your total due payment breaks down as follows:",

	"PaymentItemHead" => "Item",
	"PaymentTypeHead" => "Type",
	"PaymentPriceHead" => "Price",
	"PriceValidThrough" => "valid through {0}",
	"PaymentTotal" => "Grand total",

	'Pricing-friday-copernicus-attend' => "Friday's Copernicus Science Centre",
	'Pricing-friday-copernicus-attend-center' => "Exhibition",
	'Pricing-friday-copernicus-attend-planetarium' => "Planetarium",
	'Pricing-lunch' => "Lunch",
	'Pricing-saturday-dinner-participate' => "Saturday's dinner",
	'Pricing-saturday-party-participate' => "Saturday's party",
	"Pricing-admission" => "Participation",
	"Pricing-admission-early" => "Early bird",
	"Pricing-admission-regular" => "Regular",
	"Pricing-admission-late" => "Late",

	"DiscountCode" => "Discount code",
	"DiscountCodeHelp" => "Have a discount code? Enter it here and click 'Redeem code'.",
	"DiscountCodeTitle" => "13-character code, mixed uppercase letters and numbers",
	"DiscountCodeRedeemButton" => "Redeem code",
	"DiscountCodeNotFoundMsg" => "We couldn't find the code {0} in our records. Please try entering it again and if you think that's an error, contact us for clarification.",
	"DiscountCodeInvalidMsg" => "The discount code \"{0}\" doesn't seem quite right. Please paste the code <em>exactly</em> how you received it - a 13-character string of letters and numbers. If you're having trouble, please contact us.",
	"DiscountCodeInvalidRegistrationStatusMsg" => "Discount codes can be redeemed only for registrations, which have the status of \"Pending payment\".",
	"DiscountCodeRedeemedMsg" => "Your code {0} was successfully redeemed and prices updated.",

	"SelectPaymentOptionButton" => "Pay online with Przelewy24 now",

	"HowProceedToPaymentHeader" => "How can I proceed to payment?",
	"HowProceedToPaymentInfo" => "We have an existing registration for the e-mail address <strong>{0}</strong>, which hasn't been paid for yet. To let you proceed, we need to make sure it's really you, who owns the said e-mail address. Right after filling in your registration form, you received a message with a unique link that lets you access details of your registration. To proceed to payment now, please:",
	"HowProceedToPaymentStep1" => "Find the email and click the link, then",
	"HowProceedToPaymentStep2" => "Scroll down to the bottom of the page with your registration details and click the button to proceed to payment.",
	"HowProceedToPaymentHavingTroubleHeader" => "Having trouble?",
	"HowProceedToPaymentHavingTroubleInfo1" => "If you didn't receive the email with the link, please <strong>check your Spam folder</strong> first. If you still cannot find it there, we'll be happy to re-send it to you. Just click the button below and the e-mail should arrive within minutes.",
	"HowProceedToPaymentHavingTroubleResendEmail" => "Re-send e-mail",
	"HowProceedToPaymentHavingTroubleInfo2" => "If nothing helps, you have no e-mail, the link doesn't work, or anything else is wrong, please contact the person responsible for registration.",

	"PaymentTestModeActiveAlert" => "Payment processing is working in <strong>test mode</strong>. <strong>No actual transaction will be performed</strong> - the payment processor will merely confirm that a payment was made and your registration will automatically be confirmed.",
	"PaymentProcessingErrorMsg" => "There was an error in communication with the payment processing authority. Please try proceeding to payment again (you will <em>not</em> be charged twice), and if the problem reappears, contact us to report it.",
	"PaymentProcessing-paid" => "We received your payment on {1} and your registration is complete.",
	"PaymentProcessing-processing-payment" => "Your payment transaction started on {0} and we're waiting for the processing entity to return to us with a confirmation. If you completed the payment successfully, your registration should shortly change its status to Paid. If however you cancelled the transaction before completion, you can try again any time. If the status should change but takes suspiciously long to do so, let us know and we'll look into it.",
	"PaymentProcessing-waiting-list" => "We cannot process your payment until your registration reaches the 'Pending payment' status. Hang on and we'll get back to you as soon as we can.",
	"PaymentProcessing-pending-review" => "We cannot process your payment until your registration reaches the 'Pending payment' status. Hang on and we'll get back to you as soon as we can.",
	"PaymentProcessing-cancelled" => "We cannot process your payment because your registration was cancelled.",

	"EmailRegistrationConfirmationSubject" => "Registration confirmation for {0}",
	"EmailRegistrationConfirmationIntro" => "We received your registration for the e-mail address <strong>{0}</strong>. You can access and review your registration at any time at:",
	"EmailRegistrationConfirmationReview" => "Here's a summary of your entries from the registration:",

	"SendEmailSuccessHeader" => "Registration e-mail sent to {0}",
	"SendEmailSuccessInfo" => "We successfully sent an e-mail to your address at <strong>{0}</strong>. Please allow a few minutes for it to arrive.",

	"SendEmailProblemHeader" => "Problem sending email to {0}",
	"SendEmailProblemInfo" => "Sorry about that. There's been some hiccup on the way and we couldn't get your e-mail out to <strong>{0}</strong>. This may be a one-time problem, so before calling the cavalry please do try this one more time by clicking the button below. If you get to this very same page, contact the person responsible for registration.",

	"RegistrationsListHeader" => "Registrations list",
	"RegistrationsListIntro" => "We currently have {0} registrations on file, {1} registered, {4} of which are paid, {2} on waiting list and {3} pending review. Last registration was on {5}.",
	"RegistrationsDownloadCsv" => "Download CSV",

	"StatusChangeSendEmail" => "Send notification to attendee",
	"StatusChangeButton" => "Change status",
	"CancelButton" => "Cancel",
	"StatusChangedAlreadySetMsg" => "Registration already has the status of '{0}'. No change was made.",
	"StatusChangedSuccessMsg" => "Registration status successfully changed to '{0}'.",
	"StatusChangedEmailedSuccessMsg" => "Registration status successfully changed to '{0}' and an email sent to the attendee.",
	"StatusChangeAwayMsg-paid" => "Changing from an already Paid registration is usually only needed when an attendee <strong>cancels their participation</strong>. Please make sure you're making the right choice.",

	"DateEntered" => "Date entered",
	"DatePaid" => "Date paid",

	"CodesHeader" => "Discount codes",
	"CodesRecipientEmail" => "Recipient's email",
	"CodesSelectDiscountedItems" => "Select discounted items",
	"CodesSendByEmail" => "Send code by email to recipient",
	"CodesSendByEmailHelp" => "Select this, unless you want to send the code to the recipient yourself.",
	"CodesCreateCodeButton" => "Create code",
	"CodesCreateEmailCodeButton" => "Create and email code",
	"CodesCode" => "Code",
	"CodesDateCreated" => "Date created",
	"CodesDateRedeemed" => "Date redeemed",
	"CodesCreatedMsg" => "Code for <strong>{0}</strong> successfully generated.",
	"CodesCreatedEmailedMsg" => "Code for <strong>{0}</strong> successfully generated and emailed.",
	"CodesCreatedNotEmailedMsg" => "Code for <strong>{0}</strong> successfully generated but could not be emailed. Please email the code manually.",
	"CodesRegistrationEmailMsg-paid" => "A registration already exists for {0} and was <strong>paid on {1}</strong>. A code cannot be generated.",
	"CodesRegistrationEmailMsg-cancelled" => "A registration already exists for {0} and was <strong>cancelled</strong>. A code cannot be generated.",

	"CodesEmailValidationMsg" => "Please provide a valid email address",
	"CodesPricingItemsValidationMsg" => "Please choose at least one pricing item to discount",
	"CodesPricingItemValueValidationMsg" => "Please enter a price between 0 and {0} for currency {1}",

	"EmailDiscountCodeSubject" => "Discount code for {0}",
	"EmailDiscountCodeIntro" => "You just received a discount code for your registration for the TLI. Your code is:",
	"EmailDiscountCodeInstructions" => "To redeem the code, after filling in the registration form, and just before proceeding to pay online, paste the code in the field right underneath the breakdown of your payment. If you registered previously, but have not paid yet, you can open the registration review with the link that came in your confirmation email, scroll down to the payment breakdown and enter the code there. Once the code is successfully submitted, your prices will automatically and permanently be reduced.",
	"EmailDiscountCodeItemsHeader" => "Discounted items",

	"StatisticsHeader" => "Statistics",
	"StatisticsSeatsHeader" => "Seats",
	"StatisticsSeatsPaid" => "{0} paid",
	"StatisticsSeatsLeft" => "{0} free",
	"StatisticsSeatsWaitingList" => "{0} on waiting list",
	"StatisticsSeatsPendingReview" => "{0} pending confirmation",
	"StatisticsSeatsPendingPayment" => "{0} pending payment",
	"StatisticsSeatsCancelled" => "{0} cancelled",
	"StatisticsRegistrationsByStatusHeader" => "Registrations by status",
	"StatisticsRegistrationStatusLabel" => "Status",
	"StatisticsRegistrationsLabel" => "Registrations",
	"StatisticsRegistrationsByWeekHeader" => "Registrations by week",
	"StatisticsRegistrationsRegisteredLabel" => "Registered",
	"StatisticsRegistrationsPaidLabel" => "Paid",

	"StatisticsIncludePaidPendingPaymentInfo" => "Includes only registrations paid or pending payment.",

	"StatisticsRegistrationsByClubHeader" => "Registrations by Club",
	"StatisticsClubLabel" => "Club",
	"StatisticsRegistrationsLabel" => "Registrations",

	"StatisticsOfficersByClubHeader" => "Officers by Club",
	"StatisticsOfficersPaidLabel" => "Paid",
	"StatisticsOfficersUnpaidLabel" => "Unpaid",
	"StatisticsOfficersLabel" => "Officers",
	"StatisticsNonOfficersLabel" => "Non-Officers",
	"StatisticsOfficerRatioHeader" => "Officer registration ratio",

	"StatisticsAccommodationHeader" => "Accommodation",
	"StatisticsAccommodation-stay" => "Stay",
	"StatisticsAccommodation-host" => "Host",
	"StatisticsAccommodation-independent" => "Independent",

	"StatisticsEventEnrollmentHeader" => "Event enrollments",
	"StatisticsEventLabel" => "Event",

	"ReportUpdated" => "Updated on {0}",

	"ReportOfficersByClubHeader" => "Officers by club",
	"ReportOfficersByPositionHeader" => "Officers by position",
	"ReportExecCommitteePositionShort" => "Position",

	"ReportOrganizersSpeakersHeader" => "Organizers and speakers",
	"TliFunction-organizer" => "Organizers",
	"TliFunction-speaker" => "Speakers",

	"ReportAccommodationWithToastmastersHeader" => "Accommodation with Toastmasters",

	"ReportTranslatorsHeader" => "Translators",

	"ReportLunchOrdersHeader" => "Lunch orders",

	"ReportLatestCommentsHeader" => "Latest comments",

	"ReportWaitingListHeader" => "Waiting list",

	"ReportOfficerDuplicatesHeader" => "Duplicate officers",

	"ReportEventEnrollmentsHeader" => "Event enrollments",
	"ReportEventEnrollmentsHeader-friday-copernicus-options-center" => "Friday's Copernicus Science Centre: Exhibition",
	"ReportEventEnrollmentsHeader-friday-copernicus-options-planetarium" => "Friday's Copernicus Science Centre: Planetarium",
	"ReportEventEnrollmentsHeader-friday-social-event" => "Friday's party",
	"ReportEventEnrollmentsHeader-saturday-dinner-participate" => "Saturday's dinner",
	"ReportEventEnrollmentsHeader-saturday-party-participate" => "Saturday's party",

	"DivisionName" => "Division {0}",
	"DivisionOther" => "Other divisions",

	"AuditLogHeader" => "Audit Log",
	"AuditLogAdminName" => "Administrator",
	"AuditLogEventName" => "Event",
	"AuditLogEventObject" => "Object",
	"AuditLogEventData" => "Data",
	"AuditLogEventDate" => "Date",

	"Password" => "Password",
	"SignInButton" => "Sign in",
	"SignInGoogle" => "Sign in with Google",
	"SignInErrorUserUnknown" => "We couldn't find a user account for you in our records. Please contact your friendly administrator for help.",
	"SignInErrorGoogleProcessing" => "We couldn't retrieve your information from Google. Please try signing in again and if the problem persists, contact the administrator.",

	"ToggleNavigation" => "Toggle navigation",
	"AdminNavRegistrations" => "Registrations",
	"AdminNavCodes" => "Codes",
	"AdminNavStatistics" => "Statistics",
	"AdminNavReports" => "Reports",
	"AdminNavReportsOfficersByClub" => "Officers by club",
	"AdminNavReportsOfficersByPosition" => "Officers by position",
	"AdminNavReportsOrganizersSpeakers" => "Organizers and speakers",
	"AdminNavReportsAccommodationWithToastmasters" => "Accommodation",
	"AdminNavReportsTranslators" => "Translators",
	"AdminNavReportsLunchOrders" => "Lunch orders",
	"AdminNavReportsLatestComments" => "Latest comments",
	"AdminNavReportsWaitingList" => "Waiting list",
	"AdminNavReportsOfficerDuplicates" => "Officer duplicates",
	"AdminNavReportsEventEnrollments" => "Event enrollments",
	"AdminNavAuditLog" => "Audit Log",
	"LogoutButton" => "Logout",
	"SignedInAs" => "Signed in as {0}",

	"Error404Header" => "Not the page you were looking for?",
	"Error404Info" => "Seems we have a gap in the time-space continuum and the page you were expecting to find right here is missing. You'll be better off going back to the beginning. Hit the button below to do so.",
	"ErrorDefaultHeader" => "Oops!",
	"ErrorDefaultInfo" => "Something went badly wrong and we couldn't complete your request. Sometimes that's a passing issue, like a sudden solar flare causing bits and bytes to lose their way. You can hit the button below to go back home and try again. If you continue to see this, be a good chap and let us know so we can fix it up as soon as possible.",
	"ErrorGoHome" => "Go home",
]];
