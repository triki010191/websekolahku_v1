<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Handles several simple entities that share the same generic CRUD pattern:
 * Events, Extracurriculars, Facilities, Partners, FAQs.
 *
 * Each concrete controller extends this with its own $model and $view/$route prefix.
 */
abstract class SimpleCrudController extends Controller
{
    protected string $model;
    protected string $viewPrefix;
    protected string $routePrefix;
    protected string $label;

    protected function rules(?object $entity = null): array { return []; }

    protected function beforeSave(array $data, Request $request, ?object $entity = null): array { return $data; }

    public function index()
    {
        $items = $this->model::latest()->paginate(20);
        return view("{$this->viewPrefix}.index", ['items' => $items, 'label' => $this->label, 'routePrefix' => $this->routePrefix]);
    }

    public function create()
    {
        return view("{$this->viewPrefix}.form", ['item' => new $this->model(), 'label' => $this->label, 'routePrefix' => $this->routePrefix]);
    }

    public function store(Request $r)
    {
        $data = $r->validate($this->rules());
        $data = $this->beforeSave($data, $r);
        $this->model::create($data);
        return redirect()->route("{$this->routePrefix}.index")->with('success', "{$this->label} ditambahkan.");
    }

    public function edit($id)
    {
        $item = $this->model::findOrFail($id);
        return view("{$this->viewPrefix}.form", ['item' => $item, 'label' => $this->label, 'routePrefix' => $this->routePrefix]);
    }

    public function update(Request $r, $id)
    {
        $item = $this->model::findOrFail($id);
        $data = $r->validate($this->rules($item));
        $data = $this->beforeSave($data, $r, $item);
        $item->update($data);
        return redirect()->route("{$this->routePrefix}.index")->with('success', "{$this->label} diperbarui.");
    }

    public function destroy($id)
    {
        $item = $this->model::findOrFail($id);
        $item->delete();
        return back()->with('success', "{$this->label} dihapus.");
    }
}

class EventCrudController extends SimpleCrudController
{
    protected string $model = Event::class;
    protected string $viewPrefix = 'admin.events';
    protected string $routePrefix = 'admin.events';
    protected string $label = 'Event';
    protected function rules(?object $e = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content'     => ['nullable', 'string'],
            'location'    => ['nullable', 'string', 'max:255'],
            'start_at'    => ['required', 'date'],
            'end_at'      => ['nullable', 'date', 'after_or_equal:start_at'],
            'status'      => ['required', 'in:upcoming,ongoing,finished,cancelled'],
            'is_featured' => ['sometimes', 'boolean'],
        ];
    }
    protected function beforeSave(array $d, Request $r, ?object $e = null): array
    {
        $d['slug'] = $e?->slug ?? Str::slug($d['title']) . '-' . now()->format('YmdHis');
        return $d;
    }
}

class FacilityCrudController extends SimpleCrudController
{
    protected string $model = Facility::class;
    protected string $viewPrefix = 'admin.facilities';
    protected string $routePrefix = 'admin.facilities';
    protected string $label = 'Fasilitas';
    protected function rules(?object $e = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'content'     => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['sometimes', 'boolean'],
        ];
    }
    protected function beforeSave(array $d, Request $r, ?object $e = null): array
    {
        $d['slug'] = $e?->slug ?? Str::slug($d['name']);
        return $d;
    }
}

class ExtracurricularCrudController extends SimpleCrudController
{
    protected string $model = Extracurricular::class;
    protected string $viewPrefix = 'admin.extracurriculars';
    protected string $routePrefix = 'admin.extracurriculars';
    protected string $label = 'Ekstrakurikuler';
    protected function rules(?object $e = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:20'],
            'category' => ['nullable', 'string', 'max:50'],
            'coach' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'member_count' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
    protected function beforeSave(array $d, Request $r, ?object $e = null): array
    {
        $d['slug'] = $e?->slug ?? Str::slug($d['name']);
        return $d;
    }
}

class PartnerCrudController extends SimpleCrudController
{
    protected string $model = Partner::class;
    protected string $viewPrefix = 'admin.partners';
    protected string $routePrefix = 'admin.partners';
    protected string $label = 'Mitra DU-DI';
    protected function rules(?object $e = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'mou_number' => ['nullable', 'string', 'max:100'],
            'mou_start' => ['nullable', 'date'],
            'mou_end' => ['nullable', 'date', 'after_or_equal:mou_start'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
    protected function beforeSave(array $d, Request $r, ?object $e = null): array
    {
        $d['slug'] = $e?->slug ?? Str::slug($d['name']);
        return $d;
    }
}

class FaqCrudController extends SimpleCrudController
{
    protected string $model = Faq::class;
    protected string $viewPrefix = 'admin.faqs';
    protected string $routePrefix = 'admin.faqs';
    protected string $label = 'FAQ';
    protected function rules(?object $e = null): array
    {
        return [
            'category' => ['required', 'string', 'max:50'],
            'question' => ['required', 'string', 'max:255'],
            'answer'   => ['required', 'string'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }
}
