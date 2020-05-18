<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2019 webtrees development team
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

namespace Fisharebest\Webtrees\Services;

use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Factory;
use Fisharebest\Webtrees\Tree;
use Illuminate\Support\Str;

use function array_shift;
use function preg_split;
use function substr_count;

use const PHP_INT_MAX;

/**
 * Edit and save GEDCOM data
 */
class GedcomEditService
{
    /**
     * Add blank lines into a GEDCOM fact, to allow a user to add/edit new values.
     *
     * @param Fact $fact
     *
     * @return string
     */
    public function insertMissingSubtags(Fact $fact): string
    {
        return $this->insertMissingLevels($fact->record()->tree(), $fact->tag(), $fact->gedcom());
    }

    /**
     * @param Tree   $tree
     * @param string $tag
     * @param string $gedcom
     *
     * @return string
     */
    private function insertMissingLevels(Tree $tree, string $tag, string $gedcom): string
    {
        $next_level = substr_count($tag, ':') + 1;
        $factory    = Factory::gedcomElement();
        $subtags    = $factory->make($tag)->subtags($tree);

        // The first part is level N (includes CONT records).  The remainder are level N+1.
        $parts  = preg_split('/\n(?=' . $next_level . ')/', $gedcom);
        $return = array_shift($parts);

        foreach ($subtags as $subtag => $occurrences) {
            [$min, $max] = explode(':', $occurrences);
            if ($max === 'M') {
                $max = PHP_INT_MAX;
            } else {
                $max = (int) $max;
            }

            $count = 0;

            // Add expected subtags in our preferred order.
            foreach ($parts as $n => $part) {
                if (Str::startsWith($part, $next_level . ' ' . $subtag)) {
                    $return .= "\n" . $this->insertMissingLevels($tree, $tag . ':' . $subtag, $part);
                    $count++;
                    unset($parts[$n]);
                }
            }

            // Allowed to have more of this subtag?
            if ($count < $max) {
                // Create a new one.
                $gedcom  = $next_level . ' ' . $subtag;
                $default = $factory->make($tag . ':' . $subtag)->default();
                if ($default !== '') {
                    $gedcom .= ' ' . $default;
                }
                $return .= "\n" . $this->insertMissingLevels($tree, $tag . ':' . $subtag, $gedcom);
            }
        }

        // Now add any unexpected/existing data.
        if ($parts !== []) {
            $return .= "\n" . implode("\n", $parts);
        }

        return $return;
    }
}
