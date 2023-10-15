<?php

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

state([
    'code' => '',
    'preset' => 'laravel',
    'result' => '',
]);

rules([
    'code' => 'required',
    'preset' => 'required|in:laravel,per,psr12,symfony',
]);

$format = function () {
    $this->validate();

    $hash = sha1($this->code);

    if (! Str::startsWith($this->code, '<?php', '<?')) {
        $this->code = "<?php $this->code";
    }

    File::put($path = sys_get_temp_dir() . "/$hash", $this->code);

    $binary = config('pint-express.php_binary');

    $result = Process::path(base_path())
        ->run("$binary vendor/bin/pint $path --preset $this->preset")
        ->throw();

    $this->result = File::get($path);

    File::delete($path);
};

$again = function () {
    $this->code = '';
    $this->result = '';
};

?>

<div>
    @if ($result)
        <x-prose>
            <pre><code class="language-php">{{ $result }}</code></pre>
        </x-prose>

        <x-button
            class="table mx-auto mt-4 bg-gray-200"
            wire:click="again"
        >
            Again
        </x-button>
    @else
        <form wire:submit="format" class="grid gap-2">
            <div>
                <label for="preset" class="text-xs font-bold uppercase">
                    Preset
                </label>

                <select id="preset" wire:model="preset" required class="w-full px-4 py-3 mt-1 border-gray-200 rounded">
                    <option value="laravel" selected>Laravel code style</option>
                    <option value="per" selected>PER code style</option>
                    <option value="psr12" selected>PSR-12 code style</option>
                    <option value="symfony" selected>Symfony code style</option>
                </select>

                @error('preset')
                    <div class="text-sm font-medium text-red-400">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <label for="code" class="text-xs font-bold uppercase">
                    Code
                </label>

                <textarea
                    id="code"
                    wire:model="code"
                    placeholder="Your PHP code snippet here…"
                    required
                    class="mt-1 w-full min-h-[30vh] px-4 py-3 placeholder-gray-300 border-gray-200 rounded resize-none"
                    x-ref="code"
                ></textarea>

                @error('code')
                    <div class="text-sm font-medium text-red-400">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <x-button class="bg-[#ffa301] text-white mt-2">
                Format
            </x-button>
        </form>
    @endif
</div>
