<div>
    @if ($resourcesLength > 12)
        <div class="row mb-3">
            <div class="col-12">
                <div class="input-group" id="searchInput">
                    <input type="text" class="form-control p-2" placeholder="Rechercher par mot clé, auteur, titre" wire:model.debounce.150ms="searchInput">
                    <span class="input-group-text d-block p-2 h-100"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    @endif


    <div class="row g-3 mb-3">
        @if (count($resources) > 0)
            @foreach ($resources as $resource)
                <div class="col-lg-6 col-12">
                    <div class="card" style="min-height: 200px">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="/storage/coverPages/{{ $resource->cover_page }}" class="img-fluid rounded-start" alt="" style="height: 200px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::words($resource->authors, 4, '...') }}</h6>
                                    <p class="card-text">{{ Str::words($resource->title, 12, ' ...') }}</p>
                                    <p>{{ ($resource->available_number > 0 && $resource->status) ? 'Disponible' : 'Indisponible' }} <i class="fa fa-circle {{ ($resource->available_number > 0 && $resource->status) ? 'actif' : 'inactif' }}"></i></p>
                                    <div>
                                        <a href="/resources/{{ $resource->id }}" class="btn see-more-btn">Voir plus</a>
                                        @if (!Auth::user())
                                            <a href="/resources" class="btn reservation-btn">Réserver</a>
                                        @elseif (Auth::user()->role != "Administrateur" && Auth::user()->role != "Bibliothécaire")
                                            <a href="/resources" class="btn reservation-btn">Réserver</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h6 class="error text-center mt-5">Nous sommes désolés, mais la ressource que vous recherchez n'est pas encore disponible dans notre bibliothèque. Veuillez vérifier ultérieurement pour voir si elle est disponible.</h6>
        @endif

    </div>

    <div>
        {{ $resources->links() }}
    </div>
</div>
