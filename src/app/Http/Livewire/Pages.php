<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pages extends Component
{
    public $modalFormVisible = false;  // controlls visibility of modal dialog
    public $title;
    public $slug;
    public $content;
        
    /**
     * Validation rules for the form fields
     *
     * @return void
     */
    public function rules() {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')],
            'content' => 'required',
        ];
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
     * create
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
     * Reset the Livewire variables back to null after saving
     *
     * @return void
     */
    public function resetVars() {
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }

    /**
     * Show the modal form for the create button
     *
     * @return void
     */
    public function createShowModal() {
        $this->modalFormVisible = true;
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
        return view('livewire.pages');
    }
}
