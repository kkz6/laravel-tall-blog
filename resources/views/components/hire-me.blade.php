<a
    href="{{ route('home') }}"
    {{ $attributes->merge(['class' => 'bg-gradient-to-r from-indigo-300 dark:from-indigo-400 to-indigo-400 dark:to-indigo-500 font-normal px-3 sm:px-4 py-2 sm:py-3 rounded shadow-md text-white tracking-widest text-xs uppercase']) }}
    @click="window.fathom?.trackGoal('SJKONFQC', 0)"
>
    Hire me!
</a>
