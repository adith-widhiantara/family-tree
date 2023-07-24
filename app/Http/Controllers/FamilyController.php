<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Responses\FamilyResponse;
use Illuminate\Http\JsonResponse;
use function route;
use function is_null;

class FamilyController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $text = 'Families retrieved successfully.';

        $families = Family::query()
            ->get();

        if ($request->filled('children')) {
            $parent = Family::query()
                ->where('name', $request->children)
                ->first();

            if (is_null($parent)) {
                return FamilyResponse::json('Family not found.', NULL, 404);
            }

            $text = 'Children of ' . $parent->name . ' retrieved successfully.';

            $families = $parent->children;
        }

        if ($request->filled('grandchildren')) {
            $parent = Family::query()
                ->where('name', $request->grandchildren)
                ->first();

            if (is_null($parent)) {
                return FamilyResponse::json('Family not found.', NULL, 404);
            }

            $text = 'Grandchildren of ' . $parent->name . ' retrieved successfully.';

            $families = $parent->children->map(function ($family) {
                return $family->children;
            })->flatten();
        }

        if ($request->filled('tree')) {
            $parent = Family::query()
                ->where('name', 'budi')
                ->first();

            $text = 'Family tree of ' . $parent->name . ' retrieved successfully.';

            $families = $this->buildFamilyTree($parent->id);
        }

        return FamilyResponse::json($text, $families);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', Rule::unique('families')],
            'gender' => ['required', Rule::in('L', 'P')],
            'parent' => ['required', Rule::exists('families', 'name')],
        ], [
            'gender.in' => 'The gender must be L or P.',
            'parent.exists' => 'The selected parent is not exists.',
        ]);

        $parent = Family::query()
            ->where('name', $request->parent)
            ->value('id');

        $family = Family::query()
            ->create([
                'name' => Str::title($request->name),
                'gender' => Str::title($request->gender),
                'father_id' => $parent,
            ]);

        return FamilyResponse::json('Family created successfully.', $family);
    }

    /**
     * @param Family $family
     * @return JsonResponse
     */
    public function show(Family $family): JsonResponse
    {
        return FamilyResponse::json('Family retrieved successfully.', $family);
    }

    /**
     * @param Family $family
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Family $family, Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', Rule::unique('families')],
            'gender' => ['required', Rule::in('L', 'P')],
        ], [
            'gender.in' => 'The gender must be L or P.',
        ]);

        $family->update([
            'name' => Str::title($request->name),
            'gender' => Str::title($request->gender),
        ]);

        return FamilyResponse::json('Family updated successfully.', $family->refresh(), 200, route('families.show', $family));
    }

    /**
     * @param Family $family
     * @return JsonResponse
     */
    public function destroy(Family $family): JsonResponse
    {
        $families = Family::query()
            ->pluck('father_id')
            ->toArray();

        if (in_array($family->id, $families)) {
            FamilyResponse::json('Family cannot be deleted because it has children.', $family, 403);
        }

        $family->delete();

        return FamilyResponse::json('Family deleted successfully.', $family, 200, route('families.index'));
    }

    /**
     * @param $parent
     * @return array|null
     */
    private function buildFamilyTree($parent): ?array
    {
        $person = Family::query()
            ->where('id', $parent)
            ->first();

        if (!$person) {
            return NULL;
        }

        $tree = [
            'name' => $person->name,
            'gender' => $person->gender,
        ];

        $children = $person->children;
        if ($children->count() > 0) {
            $tree['children'] = [];
            foreach ($children as $child) {
                $tree['children'][] = $this->buildFamilyTree($child->id);
            }
        }

        return $tree;
    }
}
