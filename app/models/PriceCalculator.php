<?php

namespace models;

interface PriceCalculator {

	function calculateSummary(\models\RegistrationForm $form);

}
