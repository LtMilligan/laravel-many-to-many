@extends('layouts.dashboard')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Aggiungi nuovo progetto</h2>
            </div>
            <div class="col-12">
                <form action="{{ route('admin.projects.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="" class="control-label my-2">Nome progetto</label>
                            <input type="text" id="" class="form-control form-control-sm" name="name" placeholder="Nome progetto">
                        </div>
                        <div class="col-12">
                            <label for="" class="control-label my-2">Immagine del progetto</label>
                            <input type="file" class="form-control form-control-sm" name="project_image" id="project_image">
                        </div>
                        <div class="col-12">
                            <label for="" class="control-label my-2">Categoria del progetto</label>
                            <select name="category_id" id="" class="form-select" required>
                                <option value="">Scegli una categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="" class="control-lable">Seleziona la tecnologia</label>
                            <div>
                                @foreach($technologies as $technology)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="technologies[]" value="{{ $technology->id }}" @checked(is_array(old('technologies')) && in_array($technology->id, old('technologies')))>
                                        <label class="form-check-label">{{ $technology->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="" class="control-label my-2">Sommario progetto</label>
                            <textarea name="summary" id="" cols="30" rows="10" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-sm btn-success my-2">Salva</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection