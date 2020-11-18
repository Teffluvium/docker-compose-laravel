<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;

    public $modalFormVisible = false;  // controlls visibility of modal create/update dialog
    public $modalConfirmDeleteVisible = false;  // controlls visibility of modal delete dialog
    public $modelId;
    public $title;
    public $slug;
    public $content;
        
    /**
     * Validation rules for the form fields
     * Get invoked by the Laravel validate method
     *
     * @return void
     */
    public function rules() {
        return [
            'title' => 'required',
            'slug' => [
                'required',
                Rule::unique('pages', 'slug')->ignore( $this->modelId )
            ],
            'content' => 'required',
        ];
    }
    
    /**
     * The Livewire mount function
     *
     * @return void
     */
    public function mount() {
        // Resets the pagination after reloading the page
        $this->resetPage();
    }
    
    /**
     * Update the slug based on the title
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedTitle( $value ) {
        $this->generateSlug($value);
    }

    /**
     * Create function
     *
     * @return void
     */
    public function create() {
        $this->validate();
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetVars();
    }
    
    /**
     * The read function
     *
     * @return void
     */
    public function read() {
        return Page::paginate(5);
    }
    
    /**
     * Update function
     *
     * @return void
     */
    public function update() {
        $this->validate();
        Page::find( $this->modelId )->update( $this->modelData() );
        $this->modalFormVisible = false;
        $this->resetVars();
    }
    
    /**
     * The delete function
     *
     * @return void
     */
    public function delete() {
        Page::destroy( $this->modelId );
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }
    
    /**
     * Reset the Livewire variables back to null after saving
     *
     * @return void
     */
    public function resetVars() {
        $this->modelId = null;
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }

    /**
     * The craeteShowModal function
     * Show the modal form for the create button
     *
     * @return void
     */
    public function createShowModal() {
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
    }
    
    /**
     * The updateShowModal function
     * Show populated model form for the update button
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal( $id ) {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }
    
    /**
     * The deleteShowModal function
     * Show delete confirmation modal
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal( $id ) {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }
    
    /**
     * The loadModel function
     *
     * @return void
     */
    public function loadModel() {
        $data = Page::find( $this->modelId );
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
    }
            
    /**
     * The data for the model mapped in this component
     *
     * @return void
     */
    public function modelData() {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ];
    }
    
    /**
     * Modify the title string to make an appropriate url slug
     *
     * @param  mixed $value
     * @return void
     */
    private function generateSlug( $value ) {
        $process1 = str_replace( ' ', '_', $value );
        $process2 = strtolower( $process1 );
        $process3 = urlencode( $process2 );
        $this->slug = $process3;
    }

    /**
     * The Livewire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages', [
            'data' => $this->read(),
        ]);
    }
}
