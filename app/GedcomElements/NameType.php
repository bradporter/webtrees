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
 * NAME_TYPE := {Size=5:30}
 * [ aka | birth | immigrant | maiden | married | <user defined>]
 * Indicates the name type, for example the name issued or assumed as an immigrant.
 * aka          = also known as, alias, etc.
 * birth        = name given on birth certificate.
 * immigrant    = name assumed at the time of immigration.
 * maiden       = maiden name, name before first marriage.
 * married      =name was persons previous married name.
 * user_defined = other text name that defines the name type.
 */
class NameType extends AbstractElement
{
}
