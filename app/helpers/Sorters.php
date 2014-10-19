<?php

namespace helpers;

class Sorters {

	static function sortRegistrationsByFullName($a, $b) {
		if ($a->getField('full-name') == $b->getField('full-name'))
			return 0;

		return ($a->getField('full-name') < $b->getField('full-name'))
			? -1
			: 1;
	}

}
