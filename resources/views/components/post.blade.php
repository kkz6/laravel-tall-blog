<div {{ $attributes->except(['@click', 'post'])->merge(['class' => 'bg-gradient-to-r from-white dark:from-gray-800/50 to-gray-50/30 dark:to-gray-800/50 p-4 sm:p-5 rounded-lg shadow-lg shadow-gray-200 dark:shadow-black/10']) }}>
    <div class="flex items-center justify-between gap-8">
        <div>
            <div class="flex items-center gap-2 text-sm">
                <img loading="lazy" src="https://www.gravatar.com/avatar/{{ md5($post->user_email) }}" width="18" height="18" alt="{{ $post->user_name }}" class="-translate-y-[.5px] rounded-full" />

                <p>
                    <a href="{{ route('consulting') }}" target="_blank" rel="noopener noreferrer" class="font-semibold" @click="window.fathom?.trackGoal('LNRXVF3B', 0)">{{ $post->user_name }}</a>

                    —

                    <span class="opacity-75">@choice(':count&nbsp;minute|:count&nbsp;minutes', $post->read_time) read</span>
                </p>
            </div>

            <a
                href="{{ route('posts.show', $post->slug) }}"
                class="font-normal inline-block mt-2 text-indigo-600 dark:text-indigo-400"
                {{ $attributes->only('@click') }}
            >
                {{ $post->title }}
            </a>
        </div>

        @if ($post->image)
            <a
                href="{{ route('posts.show', $post->slug) }}"
                {{ $attributes->only('@click') }}
                class="flex-shrink-0"
            >
                <img loading="lazy" src="{{ str_replace('w_auto', 'h_128', $post->image) }}" width="64" height="64" alt="{{ $post->title }}" class="aspect-square object-cover" />
            </a>
        @endif
    </div>

    <p class="leading-relaxed mt-3 text-sm">{{ $post->description }}</p>
</div>
