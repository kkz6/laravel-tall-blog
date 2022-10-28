<a href="{{ route('posts.show', $post->slug) }}" class="group" @click="window.fathom?.trackGoal('WQ8HQTOO', 0)">
    <p class="font-serif leading-tight group-hover:text-blue-400 text-lg transition-colors">
        {{ $post->title }}
    </p>

    <x-metadata
        :published-at="$post->getPublishedAtDate()"
        :read-time="$post->getReadTime()"
        class="mt-3"
    />
</a>
