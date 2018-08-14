@php
    /** @var $tag \seo_db\Models\Tag */
@endphp
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <ul class="category__tags">
            @foreach($categoryTags as $tag)
                <li>
                    <a class="{{Request::is('*/' . $tag->slug) ? 'active' : ''}}"
                       href="{{url('filter/' . $categoryTags->category->slug . '/' . $tag->slug)}}">{{$tag->name}}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>