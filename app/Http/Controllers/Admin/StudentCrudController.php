<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\StudentRequest;
use Prologue\Alerts\Facades\Alert;
use Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;


class StudentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use BulkDeleteOperation;
    public function setup()
    {
        CRUD::setModel(\App\Models\Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('étudiant', 'étudiants');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'type' => 'checkbox',
            'name' => 'bulk_actions', // ce champ n’existe pas, mais Backpack affiche les cases
        ]);
        CRUD::column('photo')->type('image')->label('Photo')->height('50px');
        CRUD::column('student_number')->label('N° Étudiant');
        CRUD::column('first_name')->label('Prénom');
        CRUD::column('last_name')->label('Nom');
        CRUD::column('birth_date')->type('date')->label('Date de naissance');
        CRUD::column('gender')->label('Genre');
        CRUD::column('phone')->label('Téléphone');
        CRUD::column('status')->label('Statut')->type('enum');
        CRUD::column('current_class')->label('Classe actuelle')
            ->value(function ($entry) {
                $enrollment = $entry->currentEnrollment;
                return $enrollment ? $enrollment->class->name : 'Non inscrit';
            });
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(StudentRequest::class);

        // Informations de base
        CRUD::field('student_number')->label('N° Étudiant')->type('text')
            ->attributes(['readonly' => 'readonly']);
        CRUD::field('first_name')->label('Prénom')->type('text');
        CRUD::field('last_name')->label('Nom')->type('text');
        CRUD::field('birth_date')->label('Date de naissance')->type('date');
        CRUD::field('birth_place')->label('Lieu de naissance')->type('text');
        CRUD::field('gender')->label('Genre')->type('enum')
            ->options(['M' => 'Masculin', 'F' => 'Féminin']);
        CRUD::field('nationality')->label('Nationalité')->type('text')->default('Ivoirienne');

        // Contact
        CRUD::field('phone')->label('Téléphone')->type('text')
            ->hint('Format: +225XXXXXXXX ou XXXXXXXX');
        CRUD::field('email')->label('Email')->type('email');
        CRUD::field('address')->label('Adresse')->type('textarea');

        // Photo
        CRUD::field('photo')->label('Photo')->type('upload')
            ->upload(true)->disk('public');

        // Informations académiques
        CRUD::field('enrollment_date')->label('Date d\'inscription')->type('date');
        CRUD::field('status')->label('Statut')->type('enum')
            ->options([
                'active' => 'Actif',
                'suspended' => 'Suspendu',
                'graduated' => 'Diplômé',
                'dropped' => 'Abandon'
            ]);

        // Informations supplémentaires
        CRUD::field('medical_info')->label('Informations médicales')->type('textarea');
        CRUD::field('notes')->label('Notes')->type('textarea');

        // Relation parents
        CRUD::field('parents')->label('Parents/Tuteurs')
            ->type('select_multiple')
            ->entity('parents')
            ->model(\App\Models\ParentModel::class)
            ->attribute('full_name')
            ->pivot(true)
            ->options(function ($query) {
                return $query->orderBy('last_name', 'ASC')->get();
            });

    }


    /**
     * Store - Utilise la logique du StudentRequest
     */
    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        try {
            // Utiliser la méthode statique du StudentRequest
            $student = StudentRequest::createStudent(request()->all());

            // Définir l'entrée courante pour Backpack
            $this->crud->setOperationSetting('saveAllInputsExcept', ['_token']);
            $this->data['entry'] = $student;

            // Message de succès
            // Alert::success(trans('backpack::crud.update_success'))->flash();
            Alert::add('success', trans('backpack::crud.insert_success'))->flash();


            // Redirection
            // return redirect($this->crud->route);
            return $this->traitStore();

        } catch (\Exception $e) {
            Alert::add('error', 'Erreur lors de la création user')->flash();

            return redirect()->back()->withInput();
        }
    }

    /**
     * Update - Utilise la logique du StudentRequest
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        try {
            $student = $this->crud->getCurrentEntry();

            // Utiliser la méthode statique du StudentRequest
            $updatedStudent = StudentRequest::updateStudent($student, request()->all());

            // Définir l'entrée courante pour Backpack
            $this->data['entry'] = $updatedStudent;

            // Message de succès
            Alert::add('success', trans('backpack::crud.update_success'))->flash();

            // Redirection
            return $this->traitStore();

        } catch (\Exception $e) {
            Alert::add('error', 'Erreur lors de la création')->flash();
            return redirect()->back()->withInput();
        }
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        // Rendre le numéro d'étudiant modifiable en mise à jour
        CRUD::field('student_number')->attributes(['readonly' => false]);
    }

}