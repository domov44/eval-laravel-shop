<ul class="grid grid-cols-4 gap-8">
    @foreach ($products as $product)
        <li class="flex flex-col justify-between p-4 space-y-6 bg-white rounded-lg shadow">
            <div class="space-y-2">
                <h2 class="text-lg">{{ $product->name }}</h2>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    {{ Number::currency($product->price, 'EUR', 'fr') }}
                </div>
                <div class="flex items-center gap-1 flex-nowrap">
                    <button wire:click="decrement({{ $product->id }})"
                            type="button"
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-300">-</button>
                    <div class="w-8 text-center">{{ $cart[$product->id] ?? 0 }}</div>
                    <button wire:click="increment({{ $product->id }})"
                            type="button"
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-300">+</button>
                </div>
            </div>
        </li>
    @endforeach
</ul>
