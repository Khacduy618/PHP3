<div class="container-fluid bg-faded fh5co_padd_mediya padding_786">
    <div class="container padding_786">
        {{-- Note: navbar-toggleable-md is a BS4 class, BS5 uses navbar-expand-md --}}
        <nav class="navbar navbar-expand-md navbar-light "> {{-- Changed navbar-toggleable-md to navbar-expand-md --}}
            <button class="navbar-toggler navbar-toggler-right mt-3" type="button" data-bs-toggle="collapse" {{--
                Changed data-toggle to data-bs-toggle --}} data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="fa fa-bars"></span></button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('site/images/logo.png') }}" alt="img"
                    {{-- Added home route to brand --}} class="mobile_logo_width" /></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    {{-- Home Link --}}
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                    </li>

                    {{-- Dynamic Categories from MenuComposer --}}
                    @if (isset($menuCategories))
                        @foreach ($menuCategories as $parentCategory)
                            @if ($parentCategory->children->isNotEmpty())
                                {{-- Category with Children (Dropdown on Hover) --}}
                                <li class="nav-item dropdown">
                                    {{-- Link now goes to parent category page, dropdown triggered by CSS hover --}}
                                    <a class="nav-link" href="{{ route('category.parent.show', $parentCategory->slug) }}"
                                        id="navbarDropdown{{ $parentCategory->id }}">
                                        {{ $parentCategory->name }}
                                    </a>
                                    {{-- Dropdown menu remains for hover effect --}}
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $parentCategory->id }}">
                                        @foreach ($parentCategory->children as $childCategory)
                                            {{-- Link to child category page --}}
                                            <li><a class="dropdown-item"
                                                    href="{{ route('category.show', $childCategory->slug) }}">{{ $childCategory->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                {{-- Category without Children (Regular Link) --}}
                                <li class="nav-item">
                                    {{-- Link to category page --}}
                                    <a class="nav-link"
                                        href="{{ route('category.show', $parentCategory->slug) }}">{{ $parentCategory->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif

                    {{-- Example Static Link (Optional) --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="/contact-us">Contact</a>
                    </li> --}}
                </ul>
            </div>
        </nav>
    </div>
</div>

{{-- Basic CSS for Hover Dropdown (Add to your main CSS file ideally) --}}
<style>
    .dropdown:hover>.dropdown-menu {
        display: block;
        margin-top: 0;
        /* Adjust if needed */
    }

    .dropdown>.dropdown-toggle:active {
        /* Prevent dropdown staying open on mobile tap */
        pointer-events: none;
    }
</style>