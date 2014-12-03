<?php
$otherLanguage = current(array_diff(\models\L11nManager::languagesSupported(), [\models\L11nManager::language()]));
?>
<div id="tli-navigation-bar">
<div class="container">
	<nav id="tli-main-navigation" class="tli-navigation-menu">
		<ul>
			<li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavRegisterUrl') ?>" class="tli-current"><?php echo \F3::get('lang.TliNavRegister') ?></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/"><?php echo \F3::get('lang.TliNavHome') ?></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavSpeakersUrl') ?>"><?php echo \F3::get('lang.TliNavSpeakers') ?></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavContestUrl') ?>"><?php echo \F3::get('lang.TliNavContest') ?></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavScheduleUrl') ?>"><?php echo \F3::get('lang.TliNavSchedule') ?></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavEventsUrl') ?>"><?php echo \F3::get('lang.TliNavEvents') ?></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavVenuesUrl') ?>"><?php echo \F3::get('lang.TliNavVenues') ?></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavAccommodationUrl') ?>"><?php echo \F3::get('lang.TliNavAccommodation') ?></a>
			</li>
		</ul>
	</nav>

	<nav id="tli-side-navigation" class="tli-navigation-menu">
		<ul>
			<li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavOrganizersUrl') ?>" data-title="<?php echo \F3::get('lang.TliNavOrganizers') ?>"><i class="fa fa-group"></i><span><?php echo \F3::get('lang.TliNavOrganizers') ?></span></a>
			</li><li>
				<a href="http://tli.toastmasters.org.pl/<?php echo \F3::get('lang.TliNavContactUrl') ?>" data-title="<?php echo \F3::get('lang.TliNavContact') ?>"><i class="fa fa-envelope"></i><span><?php echo \F3::get('lang.TliNavContact') ?></span></a>
			</li><li>
				<a href="<?php echo \F3::get('PATH') . '?language=' . $otherLanguage ?>" data-title="<?php echo \F3::get('lang.TliNavLanguagePl') ?>"><i class="lang-<?php echo $otherLanguage ?>"></i><span><?php echo \F3::get('lang.TliNavLanguagePl') ?></span></a>
			</li>
		</ul>
	</nav>
</div>
</div>
