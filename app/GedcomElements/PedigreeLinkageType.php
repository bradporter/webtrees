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
 * PEDIGREE_LINKAGE_TYPE := {Size=5:7}
 * [ adopted | birth | foster | sealing ]
 * A code used to indicate the child to family relationship for pedigree navigation purposes.
 * Where:
 * adopted = indicates adoptive parents.
 * birth   = indicates birth parents.
 * foster  = indicates child was included in a foster or guardian family.
 * sealing = indicates child was sealed to parents other than birth parents.
 */
class PedigreeLinkageType extends AbstractElement
{
}
