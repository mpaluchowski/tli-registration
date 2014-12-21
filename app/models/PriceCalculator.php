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
	 * @param discounts whether to include discounts in summary calculation
	 * @param time The time to calculate the summary for. 'null' is default and
	 * will use current time.
	 * @return Summary structure with pricing details.
	 */
	function calculateSummary(
		\models\RegistrationForm $form,
		$discounts = true,
		$time = null
		);

	/**
	 * Retrieves pricing details from the database, for a given moment in time.
	 * Accounts for some prices being time-sensitive, ie. changing over time.
	 *
	 * @param time optional time to return prices for. Default is now.
	 * @return pricing structure with all available options and variants.
	 */
	function fetchPricing($time = null);

}
