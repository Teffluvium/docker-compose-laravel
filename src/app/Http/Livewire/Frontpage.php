<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;
    
    /**
     * Livewire mount function
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function mount( $urlslug = null ) {
        $this->retrieveContent( $urlslug );
    }
    
    /**
     * retrieveContent function
     * Load dynamic content based on the $urlslug
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function retrieveContent( $urlslug ) {
        // Get default home page
        if ( empty($urlslug) ) {
            $data = Page::where( 'is_default_home', true )->first();
        } else {
            // Use requested page
            $data = Page::where( 'slug', $urlslug )->first();

            // If unable to retrieve the page go to the default 404 page
            if ( !$data ) {
                $data = Page::where( 'is_default_not_found', true )->first();
            }
        }

        $this->title = $data->title;
        $this->content = $data->content;
    }
    
    /**
     * Livewire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.frontpage')->layout('layouts.frontpage');
    }
}
