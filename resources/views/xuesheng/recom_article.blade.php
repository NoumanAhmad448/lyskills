@php $article = $m_lec->article; @endphp
@if ($article)
    <div class="my-5">
        <div class="container">
            <h3 class="mb-2">
                Recommended Article
            </h3>
            <textarea rows="10" class="form-control">
                                {{ $article->article_txt ?? '' }}
                            </textarea>
        </div>
    </div>
@endif
