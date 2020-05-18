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

/**
 * NAME_PIECE_SUFFIX := {Size=1:30}
 * [ <NAME_PIECE> | <NAME_PIECE_SUFFIX>, <NAME_PIECE> ]
 * Non-indexing name piece that appears after the given name and surname parts. Different name
 * suffix parts are separated by a comma.
 * For example:
 * Lt. Cmndr. Joseph /Allen/ jr.
 * In this example jr. is considered as the name suffix portion.
 */
class NamePieceSuffix extends AbstractElement
{
}
