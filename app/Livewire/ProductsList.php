<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductsList extends Component
{
    public array $cart;

    public function increment($id)
    {

        $this->cart = session('cart', []);

        if (isset($this->cart[$id])) {
            $this->cart[$id]++;
        } else {
            $this->cart[$id] = 1;
        }
        session(['cart' => $this->cart]);
        $this->dispatch('cart:refresh');
    }

    public function decrement($id)
    {
        $this->cart = session('cart', []);

        if (isset($this->cart[$id]) && $this->cart[$id] > 1) {
            $this->cart[$id]--;
        } elseif (isset($this->cart[$id]) && $this->cart[$id] == 1) {
            unset($this->cart[$id]);
        }
        session(['cart' => $this->cart]);
        $this->dispatch('cart:refresh');
    }

    #[On('refresh:cart')]
    public function render()
    {
        $this->cart = session('cart', []);
        $products = Product::get();
        session(['cart' => $this->cart]);
        return view('livewire.products-list', compact('products'));
    }
}
