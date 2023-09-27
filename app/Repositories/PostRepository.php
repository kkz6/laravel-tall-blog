<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;
use Algolia\AlgoliaSearch\RecommendClient;
use App\Repositories\Contracts\PostRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryContract
{
    public function __construct(
        public RecommendClient $recommend
    ) {
    }

    public function get(string $slug) : ?Post
    {
        return Post::query()
            ->where('slug', $slug)
            ->with('categories', 'media', 'user')
            ->published()
            ->first();
    }

    public function latest(int $page = null) : LengthAwarePaginator|Collection
    {
        /** @var LengthAwarePaginator|Collection */
        $posts = Post::query()
            ->with('categories', 'media')
            ->published()
            ->latest()
            ->when(
                $page,
                fn ($query) => $query->paginate(21),
                fn ($query) => $query->limit(11)->get(),
            );

        return $posts;
    }

    public function popular() : Collection
    {
        /** @var LengthAwarePaginator|Collection */
        $posts = Post::query()
            ->with('categories', 'media')
            ->published()
            ->orderBy('sessions_last_7_days', 'desc')
            ->limit(11)
            ->get();

        return $posts;
    }

    public function recommendations(int $id) : Collection
    {
        $ids = $this->getAlgoliaRecommendations($id)->pluck('objectID');

        /** @var Collection */
        $recommendations = Post::query()
            ->with('categories', 'media')
            ->published()
            ->whereNotIn('id', [$id])
            ->unless(
                ! empty($ids),
                fn ($query) => $query->asSequence($ids),
                fn ($query) => $query->inRandomOrder()->limit(11)
            )
            ->get();

        return $recommendations;
    }

    protected function getAlgoliaRecommendations(int $id) : Collection
    {
        return $this->algoliaEnabled() ? collect($this->recommend->getRelatedProducts([[
            'indexName' => config('scout.prefix') . 'posts',
            'objectID' => "$id",
            'maxRecommendations' => 11,
        ]])) : new Collection;
    }

    protected function algoliaEnabled() : bool
    {
        return ! empty(config('scout.algolia.id')) &&
               ! empty(config('scout.algolia.secret'));
    }
}