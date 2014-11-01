<?php

namespace models;

/**
 * Common interface for any price calculators for registration forms.
 */
interface PriceCalculator {

	/**
	 * Calculate the full pricing summary for a registration form, including:
	 *
	 * <ul>
	 *  <li>admission price</li>
	 *  <li>every item, variant and its price</li>
	 *  <li>the grand total price</li>
	 * </ul>
	 *
	 * Prices are returned for all supported currencies.
	 *
	 * @param form The registration form to calculate prices for.
	 * @return Summary structure with pricing details.
	 */
	function calculateSummary(\models\RegistrationForm $form);

}
