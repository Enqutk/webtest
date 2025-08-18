<div class="pbmit-header-social">
    <ul class="pbmit-social-links">
        @foreach ($socialRefs as $ref)
            <li class="pbmit-social-li" title="{{ $ref->title }}">
                <a href="{{ $ref->link }}" target="_blank">
                    <span>
                        <i class="{{ $ref->icon_class }}"></i>
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
