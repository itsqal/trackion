<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'ml-[16.6%]' : 'ml-0'"
    x-bind:style="sidebarOpen ? 'width: calc(100% - 16.6%)' : 'width: 100%'">
     
    <x-page-menu>
     <div>
         <span class="text-2xl text-white font-sans font-semibold">Data Truk</span>
     </div>

     <div class="flex justify-around gap-3.5">
        <x-button wire:click="viewAddTruck()" style='white'>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>  
            Tambah
        </x-button>

        {{-- Not yet implemented --}}
        <x-button wire:click='exportExcel' style='green'>Cetak .xlsx</x-button>
      </div>
  </x-page-menu>

  <livewire:trucks.table lazy />

    <x-modal title="Tambah Truk" name="view-add-truck">
        Add truck here
    </x-modal>
    
 </div>
 