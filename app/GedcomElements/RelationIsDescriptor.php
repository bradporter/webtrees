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
 * RELATION_IS_DESCRIPTOR := {Size=1:25}
 * A word or phrase that states object 1's relation is object 2. For example
 * you would read the following as "Joe Jacob's great grandson is the submitter
 * pointed to by the @XREF:SUBM@":
 * 0 INDI
 * 1 NAME Joe /Jacob/
 * 1 ASSO @<XREF:SUBM>@
 * 2 RELA great grandson
 */
class RelationIsDescriptor extends AbstractElement
{
}
