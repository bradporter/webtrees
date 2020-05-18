<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2020 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees\GedcomElements;

use Fisharebest\Webtrees\Filter;
use Fisharebest\Webtrees\Tree;

/**
 * TEXT_FROM_SOURCE := {Size=1:248}
 * <TEXT>
 * A verbatim copy of any description contained within the source. This indicates notes or text
 * that are actually contained in the source document, not the submitter's opinion about the
 * source. This should be, from the evidence point of view, "what the original record keeper
 * said" as opposed to the researcher's interpretation. The word TEXT, in this case, means from
 * the text which appeared in the source record including labels.
 */
class TextFromSource extends AbstractElement
{
    /**
     * Convert a value to a canonical form.
     *
     * @param string $value
     *
     * @return string
     */
    public function canonical(string $value): string
    {
        // Browsers use MS-DOS line endings in multi-line data.
        return strtr($value, ["\r\n" => "\n", "\r" => "\n"]);
    }

    /**
     * Display the value of this type of element.
     *
     * @param string $value
     * @param Tree   $tree
     *
     * @return string
     */
    public function value(string $value, Tree $tree): string
    {
        return Filter::formatText($value, $tree);
    }
}
