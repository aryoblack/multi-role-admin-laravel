@props([
'id',
'title' => '',
'icon' => '',
'formId' => '',
'size' => 'max-w-3xl', // max-w-md, max-w-lg, max-w-xl, max-w-2xl, max-w-3xl, max-w-4xl, max-w-5xl, max-w-6xl, max-w-7xl, max-w-full
'method' => 'POST'
])

<div id="{{ $id }}" class="fixed inset-0 z-[1050] hidden overflow-y-auto" aria-labelledby="{{ $id }}-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('{{ $id }}')"></div>

    <!-- Modal Container -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full {{ $size }} transform scale-95 overflow-hidden rounded-lg border border-gray-200 bg-white opacity-0 shadow-xl transition-all duration-200">
            <!-- Modal Header -->
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center gap-3 text-lg font-semibold text-gray-900" id="{{ $id }}-title">
                        @if($icon)
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white">
                            <i class="{{ $icon }} text-lg"></i>
                        </span>
                        @endif
                        <span id="{{ $id }}RealTitle">{{ $title }}</span>
                    </h3>
                    <button type="button"
                        onclick="closeModal('{{ $id }}')"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="{{ $formId }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}">
                @if($method !== 'GET')
                @csrf
                @endif
                {{ $hidden ?? '' }}

                <div class="p-6 md:p-8 max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                    {{ $slot }}
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4">
                    <button type="button"
                        onclick="closeModal('{{ $id }}')"
                        class="btn-secondary-theme">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="submit"
                        id="btnSave{{ $id }}"
                        class="btn-primary-theme">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
