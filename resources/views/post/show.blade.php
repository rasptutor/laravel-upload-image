<x-app-layout>
    
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl mb-4">{{ $post->title }}</h1>
                <div class="flex gap-4">                    
                    
                    <!--Avatar-->
                    <x-user-avatar :user="$post->user" />
                    <div>
                        <x-follow-ctr :user="$post->user" class="flex gap-2">
                            <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                                {{ $post->user->name }}
                            </a>
                            
                            @auth
                                &middot;
                                <button x-text="following ? 'Unfollow' : 'Follow'" 
                                :class="following ? 'text-red-600' : 'text-emerald-600'"
                                @click="follow()">
                                </button>
                            @endauth
                        </x-follow-ctr>
                        
                        <div class="flex gap-2 text-sm text-gray-500">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
                    @if ($post->user_id === Auth::id())
                        <div class="py-4 mt-8 border-t border-b border-gray-200">
                            <x-primary-button href="{{ route('post.edit', $post->slug) }}">
                                Edit Post
                            </x-primary-button>
                            <form class="inline-block" action="{{ route('post.destroy', $post) }}" method="post">
                                @csrf
                                @method('delete')
                                <x-danger-button>
                                    Delete Post
                                </x-danger-button>
                            </form>
                        </div>
                    @endif
                    <!--likes-->
                    <x-like-button :post="$post"/>
                    <!--Content-->
                    <div class="mt-4">
                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full">

                        <div class="mt-4">
                            {{ $post->content }}
                        </div>
                    </div>
                    <!--Category-->
                    <div class="mt-8">
                        <span class="px-4 py-2 bg-gray-200 rounded-2xl">
                            {{ $post->category->name }}
                        </span>
                    </div>
                    <!--Likes-->
                    <x-like-button :post="$post"/>
                    <div class="mt-2">
                        @if(Auth::check())
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <textarea name="body" rows="2" class="form-control w-full" required placeholder="Write your comment here..."></textarea>
                                <div class="flex justify-end">                                
                                    <button type="submit" class="btn btn-primary mt-2 rounded-full px-4 py-2 text-white bg-emerald-600">Post Comment</button>
                                </div>                                
                            </form>
                        @else
                            <p>Please <a href="{{ route('login') }}">log in</a> to post a comment.</p>
                        @endif
                    </div>
                    <div class="mt-2">
                        <h4 class="mb-2 underline">Comments</h4>
                        @foreach($post->comments as $comment)
                            <div class="mb-2">                                                                
                                <div class="flex justify-between">
                                    <strong>{{ $comment->user->name }}</strong>                                    
                                    @can('delete', $comment)
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-full px-4 py-2 text-white bg-red-600">Remove Comment</button>
                                        </form>
                                    @endcan
                                </div> 
                                <p>{{ $comment->body }}</p>
                                <small>{{ $comment->created_at->diffForHumans() }}</small>
                            </div>                                                       
                        @endforeach
                    </div>                
                </div>
            </div>            
        </div>
    </div>
</x-app-layout>