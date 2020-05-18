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

namespace Fisharebest\Webtrees\Http\RequestHandlers;

use Fisharebest\Webtrees\Auth;
use Fisharebest\Webtrees\Exceptions\HttpNotFoundException;
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Factory;
use Fisharebest\Webtrees\Http\ViewResponseTrait;
use Fisharebest\Webtrees\Services\GedcomEditService;
use Fisharebest\Webtrees\Tree;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;

/**
 * Edit a fact.
 */
class EditFact implements RequestHandlerInterface
{
    use ViewResponseTrait;

    /** @var GedcomEditService */
    private $gedcom_edit_service;

    /**
     * EditFact constructor.
     *
     * @param GedcomEditService $gedcom_edit_service
     */
    public function __construct(GedcomEditService $gedcom_edit_service)
    {
        $this->gedcom_edit_service = $gedcom_edit_service;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $tree = $request->getAttribute('tree');
        assert($tree instanceof Tree);

        $xref    = $request->getQueryParams()['xref'];
        $fact_id = $request->getQueryParams()['fact_id'];

        $record = Factory::gedcomRecord()->make($xref, $tree);
        $record = Auth::checkRecordAccess($record, true);

        // Find the fact to edit
        $fact = $record->facts()
            ->first(static function (Fact $fact) use ($fact_id): bool {
                return $fact->id() === $fact_id && $fact->canEdit();
            });


        if ($fact === null) {
            throw new HttpNotFoundException();
        }

        $can_edit_raw = Auth::isAdmin() || $tree->getPreference('SHOW_GEDCOM_RECORD');

        $title = $record->fullName() . ' - ' . Factory::gedcomElement()->make($fact->tag())->label();

        return $this->viewResponse('edit/edit-fact', [
            'can_edit_raw' => $can_edit_raw,
            'fact'         => $fact,
            'gedcom'       => $this->gedcom_edit_service->insertMissingSubtags($fact),
            'record'       => $record,
            'title'        => $title,
            'tree'         => $tree,
        ]);
    }
}
