<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;

class Cart extends Component
{
    public array $cart = [];
    public $total = 0;

    public function mount()
    {
        // session()->flush();
    }

    public function increment($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]++;
        } else {
            $this->cart[$id] = 1;
        }
        session(['cart' => $this->cart]);
        $this->dispatch('refresh:cart');
    }

    public function decrement($id)
    {
        if (isset($this->cart[$id]) && $this->cart[$id] > 1) {
            $this->cart[$id]--;
        } elseif (isset($this->cart[$id]) && $this->cart[$id] == 1) {
            unset($this->cart[$id]);
        }
        session(['cart' => $this->cart]);
        $this->dispatch('refresh:cart');
    }

    public function calculTotal($products)
    {
        $this->total = 0;
        foreach ($products as $product) {
            $this->total += $product->price * $this->cart[$product->id];
        };
    }

    #[On('cart:refresh')]
    public function render()
    {
        $this->cart = session('cart', []);
        if (!is_array($this->cart)) {
            $this->cart = [];
        }

        $products = Product::whereIn('id', array_keys($this->cart))->get();

        $this->calculTotal($products);

        return view('livewire.cart', [
            'cart' => $this->cart,
            'products' => $products,
        ]);
    }
}
