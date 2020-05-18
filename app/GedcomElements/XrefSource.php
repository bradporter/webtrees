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

use Fisharebest\Webtrees\Factory;
use Fisharebest\Webtrees\Tree;

use function trim;
use function view;

/**
 * XREF:SOUR := {Size=1:22}
 * A pointer to, or a cross-reference identifier of, a SOURce record.
 */
class XrefSource extends AbstractXrefElement
{
    protected const SUBTAGS = [
        'PAGE' => '0:1',
        'EVEN' => '0:1',
        'DATA' => '0:1',
        'OBJE' => '0:M',
        'NOTE' => '0:M',
        'QUAY' => '0:1',
    ];

    /**
     * An edit control for this data.
     *
     * @param string $id
     * @param string $name
     * @param string $value
     * @param Tree   $tree
     *
     * @return string
     */
    public function edit(string $id, string $name, string $value, Tree $tree): string
    {
        return view('components/select-source', [
            'id'     => $id,
            'name'   => $name,
            'source' => Factory::source()->make(trim($value, '@'), $tree),
            'tree'   => $tree,
        ]);
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
        return $this->valueXrefLink($value, $tree, Factory::source());
    }
}
