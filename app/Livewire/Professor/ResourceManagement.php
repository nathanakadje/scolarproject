<?php

namespace App\Livewire\Professor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Teacher;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\Subject;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\ResourceNotification;
use App\Traits\HasToastNotifications;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Layout('layouts.professor-layout')]
class ResourceManagement extends Component
{
    use HasToastNotifications, WithFileUploads, WithPagination;

    public $teacher;

    // Filters
    public $search = '';
    public $filterType = 'all';
    public $filterCategory = 'all';
    public $filterSubject = 'all';
    public $sortBy = 'recent';

    // Modals
    public $showResourceModal = false;
    public $showCategoryModal = false;
    public $showStatsModal = false;

    // Resource Form
    public $resourceId = null;
    public $title = '';
    public $description = '';
    public $type = 'file';
    public $file = null;
    public $url = '';
    public $linkType = 'website';
    public $tags = '';
    public $selectedSubjectId = null;
    public $selectedCategoryId = null;
    public $accessLevel = 'restricted';
    public $allowDownload = true;
    public $selectedClasses = [];
    public $selectedStudents = [];
    public $isFeatured = false;
    public $publishNow = true;

    // Category Form
    public $categoryId = null;
    public $categoryName = '';
    public $categoryDescription = '';
    public $categorySubjectId = null;
    public $categoryColor = '#3490dc';

    // Stats
    public $selectedResourceStats = null;

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$this->teacher) {
            session()->flash('error', 'Profil professeur non trouvé');
            return redirect()->route('professor.dashboard');
        }
        // dd($this->teacher);
    }

    #[Computed]
    public function resources()
    {
        $query = Resource::with(['category', 'subject', 'classes', 'students'])
            ->where('teacher_id', $this->teacher->id);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereJsonContains('tags', $this->search);
            });
        }

        // Filter by type
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        // Filter by category
        if ($this->filterCategory !== 'all') {
            $query->where('resource_category_id', $this->filterCategory);
        }

        // Filter by subject
        if ($this->filterSubject !== 'all') {
            $query->where('subject_id', $this->filterSubject);
        }

        // Sort
        switch ($this->sortBy) {
            case 'recent':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'downloads':
                $query->orderBy('download_count', 'desc');
                break;
            case 'title':
                $query->orderBy('title');
                break;
        }

        return $query->paginate(12);
    }

    #[Computed]
    public function categories()
    {
        return ResourceCategory::where('teacher_id', $this->teacher->id)
            ->withCount('resources')
            ->orderBy('order')
            ->get();
    }

    #[Computed]
    public function subjects()
    {
        return Subject::where('is_active', true)->get();
    }

    #[Computed]
    public function classes()
    {
        return $this->teacher->getCurrentClasses();
    }

    #[Computed]
    public function stats()
    {
        return [
            'total_resources' => Resource::where('teacher_id', $this->teacher->id)->count(),
            'total_views' => Resource::where('teacher_id', $this->teacher->id)->sum('view_count'),
            'total_downloads' => Resource::where('teacher_id', $this->teacher->id)->sum('download_count'),
            'total_categories' => ResourceCategory::where('teacher_id', $this->teacher->id)->count(),
            'files' => Resource::where('teacher_id', $this->teacher->id)->where('type', 'file')->count(),
            'links' => Resource::where('teacher_id', $this->teacher->id)->where('type', 'link')->count(),
            'videos' => Resource::where('teacher_id', $this->teacher->id)->where('type', 'video')->count(),
            'articles' => Resource::where('teacher_id', $this->teacher->id)->where('type', 'article')->count(),
        ];
    }

    public function openResourceModal($id = null)
    {
        $this->resetResourceForm();

        if ($id) {
            $resource = Resource::findOrFail($id);
            $this->resourceId = $resource->id;
            $this->title = $resource->title;
            $this->description = $resource->description;
            $this->type = $resource->type;
            $this->url = $resource->url;
            $this->linkType = $resource->link_type;
            $this->tags = is_array($resource->tags) ? implode(', ', $resource->tags) : '';
            $this->selectedSubjectId = $resource->subject_id;
            $this->selectedCategoryId = $resource->resource_category_id;
            $this->accessLevel = $resource->access_level;
            $this->allowDownload = $resource->allow_download;
            $this->selectedClasses = $resource->classes->pluck('id')->toArray();
            $this->selectedStudents = $resource->students->pluck('id')->toArray();
            $this->isFeatured = $resource->is_featured;
        }

        $this->showResourceModal = true;
    }

    public function saveResource()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:file,link,video,article',
            'selectedSubjectId' => 'nullable|exists:subjects,id',
            'selectedCategoryId' => 'nullable|exists:resource_categories,id',
            'accessLevel' => 'required|in:public,restricted',
            'allowDownload' => 'boolean',
        ];

        if ($this->type === 'file') {
            $rules['file'] = $this->resourceId ? 'nullable|file|max:51200' : 'required|file|max:51200'; // 50MB max
        } else {
            $rules['url'] = 'required|url';
            $rules['linkType'] = 'required|in:website,youtube,mooc,article';
        }

        if ($this->accessLevel === 'restricted') {
            $rules['selectedClasses'] = 'required_without:selectedStudents|array';
        }

        $this->validate($rules);

        $data = [
            'teacher_id' => $this->teacher->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'subject_id' => $this->selectedSubjectId,
            'resource_category_id' => $this->selectedCategoryId,
            'access_level' => $this->accessLevel,
            'allow_download' => $this->allowDownload,
            'is_featured' => $this->isFeatured,
            'tags' => array_filter(array_map('trim', explode(',', $this->tags))),
            'published_at' => $this->publishNow ? now() : null,
        ];

        if ($this->type === 'file' && $this->file) {
            // Delete old file if updating
            if ($this->resourceId) {
                $oldResource = Resource::find($this->resourceId);
                if ($oldResource && $oldResource->file_path) {
                    Storage::disk('public')->delete($oldResource->file_path);
                }
            }

            $path = $this->file->store('resources', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $this->file->getClientOriginalName();
            $data['file_type'] = $this->file->getClientOriginalExtension();
            $data['file_size'] = $this->file->getSize();
        } elseif ($this->type !== 'file') {
            $data['url'] = $this->url;
            $data['link_type'] = $this->linkType;
        }

        if ($this->resourceId) {
            $resource = Resource::findOrFail($this->resourceId);
            $resource->update($data);
            $message = 'Ressource mise à jour avec succès';
        } else {
            $resource = Resource::create($data);
            $message = 'Ressource créée avec succès';
        }

        // Sync classes
        if ($this->accessLevel === 'restricted' && !empty($this->selectedClasses)) {
            $resource->classes()->sync($this->selectedClasses);

            // Notify students
            $this->notifyStudentsOfNewResource($resource);
        }

        // Sync individual students
        if (!empty($this->selectedStudents)) {
            $resource->students()->sync($this->selectedStudents);
        }

        $this->toastsuccess($message);
        $this->showResourceModal = false;
        $this->resetResourceForm();
    }

    protected function notifyStudentsOfNewResource($resource)
    {
        $students = Student::whereHas('classe', function ($query) use ($resource) {
            $query->whereIn('class_id', $resource->classes->pluck('id'));
        })->get();

        foreach ($students as $student) {
            ResourceNotification::create([
                'resource_id' => $resource->id,
                'student_id' => $student->id,
            ]);
        }
    }

    public function deleteResource($id)
    {
        $resource = Resource::findOrFail($id);

        // Delete file if exists
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        $this->toastsuccess("Le fichier a été supprimé avec succès ");
    }

    public function openCategoryModal($id = null)
    {
        $this->resetCategoryForm();

        if ($id) {
            $category = ResourceCategory::findOrFail($id);
            $this->categoryId = $category->id;
            $this->categoryName = $category->name;
            $this->categoryDescription = $category->description;
            $this->categorySubjectId = $category->subject_id;
            $this->categoryColor = $category->color;
        }

        $this->showCategoryModal = true;
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryName' => 'required|string|max:255',
            'categoryDescription' => 'nullable|string',
            'categorySubjectId' => 'nullable|exists:subjects,id',
            'categoryColor' => 'required|string|size:7',
        ]);

        $data = [
            'teacher_id' => $this->teacher->id,
            'name' => $this->categoryName,
            'description' => $this->categoryDescription,
            'subject_id' => $this->categorySubjectId,
            'color' => $this->categoryColor,
        ];

        if ($this->categoryId) {
            ResourceCategory::findOrFail($this->categoryId)->update($data);
            $message = 'Catégorie mise à jour avec succès';
        } else {
            ResourceCategory::create($data);
            $message = 'Catégorie créée avec succès';
        }

        $this->toastsuccess($message);
        $this->showCategoryModal = false;
        $this->resetCategoryForm();
    }

    public function deleteCategory($id)
    {
        $category = ResourceCategory::findOrFail($id);
        $category->resources()->update(['resource_category_id' => null]);
        $category->delete();
        $this->toastsuccess("Catégorie supprimée avec succès");
        // $this->success('Catégorie supprimée avec succès');
    }

    public function viewResourceStats($id)
    {
        $this->selectedResourceStats = Resource::with(['views.student', 'downloads.student'])
            ->findOrFail($id);
        $this->showStatsModal = true;
    }

    public function duplicateResource($id)
    {
        $original = Resource::findOrFail($id);
        $duplicate = $original->replicate();
        $duplicate->title = $original->title . ' (Copie)';
        $duplicate->view_count = 0;
        $duplicate->download_count = 0;
        $duplicate->published_at = null;
        $duplicate->save();

        // Duplicate relationships
        $duplicate->classes()->attach($original->classes->pluck('id'));
        $duplicate->students()->attach($original->students->pluck('id'));

        $this->toastsuccess("Ressource dupliquée avec succès");
        // $this->success('Ressource dupliquée avec succès');
    }

    public function toggleFeatured($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->update(['is_featured' => !$resource->is_featured]);
        if ($resource->is_featured) {
            $this->toastsuccess("Ressource mise en avant avec succès !");
        } else {
            $this->toastsuccess(" Ressource retirée de la mise en avant.");
        }
        // $this->success($resource->is_featured ? 'Ressource mise en avant' : 'Ressource retirée de la mise en avant');
    }

    protected function resetResourceForm()
    {
        $this->resourceId = null;
        $this->title = '';
        $this->description = '';
        $this->type = 'file';
        $this->file = null;
        $this->url = '';
        $this->linkType = 'website';
        $this->tags = '';
        $this->selectedSubjectId = null;
        $this->selectedCategoryId = null;
        $this->accessLevel = 'restricted';
        $this->allowDownload = true;
        $this->selectedClasses = [];
        $this->selectedStudents = [];
        $this->isFeatured = false;
        $this->publishNow = true;
    }

    protected function resetCategoryForm()
    {
        $this->categoryId = null;
        $this->categoryName = '';
        $this->categoryDescription = '';
        $this->categorySubjectId = null;
        $this->categoryColor = '#3490dc';
    }

    public function render()
    {
        return view('livewire.professor.resource-management');
    }
}
