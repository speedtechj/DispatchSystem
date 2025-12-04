<x-filament-panels::page>
  <form wire:submit="search" >
        {{ $this->form }}
    </form>
    <div>
        {{ $this->table }}
    </div>

    {{-- <x-filament::modal id="myModal">
        <x-slot name="heading">
        <form wire:submit="uploadPic" >
       {{$this->unManifestedForm}}
       <x-slot name="footer">
            <x-filament::button wire:click="uploadPic">Submit</x-filament::button>
        </x-slot>
        </form>
    </x-slot>
  
</x-filament::modal> --}}
</x-filament-panels::page>
