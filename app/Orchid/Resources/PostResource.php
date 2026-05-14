<?php

namespace App\Orchid\Resources;

use App\Models\Post;
use App\Models\User;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class PostResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Post::class;

    public static function label(): string
    {
        return 'Posts';
    }

    public static function singularLabel(): string
    {
        return 'Post';
    }

    public static function uriKey(): string
    {
        return 'posts';
    }

    public static function icon(): string
    {
        return 'bs.file-text';
    }

    public static function description(): ?string
    {
        return 'Manage blog posts created in the system.';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('title')
                ->title('Title')
                ->placeholder('Enter title here')
                ->required()
                ->max(255),

            TextArea::make('text')
                ->title('Text')
                ->placeholder('Enter post text here')
                ->rows(8)
                ->required(),

            Relation::make('user_id')
                ->title('Author')
                ->fromModel(User::class, 'name')
                ->required(),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort(),

            TD::make('title', 'Title')
                ->sort()
                ->filter(Input::make()),

            TD::make('user.name', 'Author')
                ->render(fn(Post $post) => e($post->user?->name ?? 'Unknown')),

            TD::make('created_at', 'Date of creation')
                ->sort()
                ->render(fn(Post $post) => $post->created_at?->toDateTimeString()),

            TD::make('updated_at', 'Update date')
                ->sort()
                ->render(fn(Post $post) => $post->updated_at?->toDateTimeString()),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id', 'ID'),
            Sight::make('title', 'Title'),
            Sight::make('text', 'Text'),
            Sight::make('user.name', 'Author'),
            Sight::make('created_at', 'Created at'),
            Sight::make('updated_at', 'Updated at'),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    public function with(): array
    {
        return ['user'];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function paginationQuery(ResourceRequest $request, \Illuminate\Database\Eloquent\Model $model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->query()->with($this->with())->orderByDesc('id');
    }
}
