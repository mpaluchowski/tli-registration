<?php

namespace models;

/**
 * Produces data for reports.
 */
interface ReportsDao {

	/**
	 * Read data for a specified report.
	 *
	 * @param name of the report to read data for. Must correspond to
	 * camel-cased method in the implementation of this interface
	 * @return data from the requested report, empty array if no data available
	 * or null if report not found
	 */
	function read($name);

}
