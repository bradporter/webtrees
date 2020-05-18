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
 * NAME_PERSONAL := {Size=1:120}
 * [
 * <NAME_TEXT> | /<NAME_TEXT>/ |
 * <NAME_TEXT> /<NAME_TEXT>/ | /<NAME_TEXT>/ <NAME_TEXT> |
 * <NAME_TEXT> /<NAME_TEXT>/ <NAME_TEXT> ]
 * The surname of an individual, if known, is enclosed between two slash (/)
 * characters. The order of the name parts should be the order that the person
 * would, by custom of their culture, have used when giving it to a recorder.
 * Early versions of Personal Ancestral File ® and other products did not use
 * the trailing slash when the surname was the last element of the name. If
 * part of name is illegible, that part is indicated by an ellipsis (...).
 * Capitalize the name of a person or place in the conventional manner—
 * capitalize the first letter of each part and lowercase the other letters,
 * unless conventional usage is otherwise. For example: McMurray.
 * Examples:
 * William Lee (given name only or surname not known)
 * /Parry/ (surname only)
 * William Lee /Parry/
 * William Lee /Mac Parry/ (both parts (Mac and Parry) are surname parts
 * William /Lee/ Parry (surname imbedded in the name string)
 * William Lee /Pa.../
 */
class NamePersonal extends AbstractElement
{
}
