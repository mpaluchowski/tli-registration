<?php

namespace models;

/**
 * Produces statistics specific to the implemented registration form, allowing
 * customization of statistics depending on the various fields that are used.
 */
interface StatisticsDao {

	/**
	 * Produce all available custom statistics for the form.
	 *
	 * @return array of statistics.
	 */
	function readStatistics();

}
