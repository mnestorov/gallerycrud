<?php

namespace SmartyStudio\GalleryCrud\app\Http\Controllers\Admin;

use SmartyStudio\GalleryCrud\app\Models\Gallery;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use SmartyStudio\GalleryCrud\app\Http\Requests\GalleryRequest;

/**
 * Class GalleryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GalleryCrudController extends CrudController
{
	use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

	public function setup()
	{
		$this->crud->setModel(Gallery::class);
		$this->crud->setRoute(config('backpack.base.route_prefix') . '/gallery');
		$this->crud->setEntityNameStrings('gallery', 'galleries');
	}

	/**
	 * Define what happens when the List operation is loaded.
	 *
	 * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
	 * @return void
	 */
	protected function setupListOperation()
	{
		/**
		 * Fields can be defined using the fluent syntax or array syntax:
		 * - CRUD::field('price')->type('number');
		 * - CRUD::addField(['name' => 'price', 'type' => 'number'])); (1)
		 * - $this->crud->addField(['name' => 'title']); (2)
		 */
		$this->crud->addColumns(['title']); // add multiple columns, at the end of the stack

		$this->crud->addColumn([
			'name' => 'status',
			'label' => 'Status',
			'type' => 'boolean',
			'options' => [
				0 => 'DRAFT',
				1 => 'PUBLISHED'
			],
		]);

		$this->crud->addColumn('created_at');
		$this->crud->addColumn('updated_at');

		if (!backpack_user()->hasRole('Superadministrator') || !backpack_user()->hasPermissionTo('Delete Galleries')) {
			$this->crud->denyAccess('delete');
			$this->crud->removeButton('delete');
		}
	}

	/**
	 * Define what happens when the Create operation is loaded.
	 *
	 * @see https://backpackforlaravel.com/docs/crud-operation-create
	 * @return void
	 */
	public function setupCreateOperation()
	{
		/**
		 * Fields can be defined using the fluent syntax or array syntax:
		 * - CRUD::field('price')->type('number');
		 * - CRUD::addField(['name' => 'price', 'type' => 'number'])); (1)
		 * - $this->crud->addField(['name' => 'title']); (2)
		 */
		$this->crud->setValidation(GalleryRequest::class);

		$this->crud->addField([
			'name' => 'title',
			'label' => 'Title',
			'type' => 'text',
			'placeholder' => 'Your title here',
		]);
		$this->crud->addField([
			'name' => 'slug',
			'label' => 'Slug (URL)',
			'type' => 'text',
			'hint' => 'Will be automatically generated from your title, if left empty.',
		]);

		$this->crud->addField([
			'name' => 'body',
			'label' => 'Body',
			'type'      => 'wysiwyg',
			'options'   => [
				'allowedContent'        => true,
				'toolbar'               => [
					['Font', 'FontSize', 'Bold', 'Italic', 'Underline', 'Strike'],
					['-', 'Source'],
					['Maximize']
				],
			],
			'placeholder' => 'Your textarea text here',
		]);

		$this->crud->addField([
			'name'      => 'images',
			'label'     => 'Images',
			'type'      => 'browse_multiple',
			'multiple'   => true,
			'sortable'   => true,
			'mime_types' => ['image'],
		]);

		$this->crud->addField([
			'name' => 'captions',
			'label' => 'Captions',
			'type' => 'gallery_table',
			'entity_singular' => 'image_item', // used on the "Add X" button
			'columns' => [
				'image' => 'Upload Image',
				'caption' => 'Caption',
			],
		]);

		$this->crud->addField([
			'label' => 'Status',
			'type' => 'select_from_array',
			'name' => 'status',
			'allows_null' => true,
			'options' => [
				0 => 'DRAFT',
				1 => 'PUBLISHED'
			],
			'default' => 0,
		]);
	}

	/**
	 * Define what happens when the Update operation is loaded.
	 *
	 * @see https://backpackforlaravel.com/docs/crud-operation-update
	 * @return void
	 */
	public function setupUpdateOperation()
	{
		$this->setupCreateOperation();
	}
}